<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://votingplugin.xyz
 * @since      1.0.0
 *
 * @package    Voting_Plugin_Hrvoje
 * @subpackage Voting_Plugin_Hrvoje/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Voting_Plugin_Hrvoje
 * @subpackage Voting_Plugin_Hrvoje/public
 * @author     Hrvoje Antunović <hrvoje1antunovic@gmail.com>
 */
class Voting_Plugin_Hrvoje_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        add_action('wp_ajax_nopriv_handle_vote',array(&$this,'handle_vote'));
        add_action('wp_ajax_handle_vote',array(&$this,'handle_vote'));

        add_filter('the_content', array(&$this,'add_voting_buttons_after_content'));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Voting_Plugin_Hrvoje_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Voting_Plugin_Hrvoje_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/voting-plugin-hrvoje-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Voting_Plugin_Hrvoje_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Voting_Plugin_Hrvoje_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/voting-plugin-hrvoje-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script($this->plugin_name, 'voting_ajax',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ajax-nonce')
            ));

	}


    public function add_voting_buttons_after_content($content) {
        // Check if it's a single post
        if (is_single()) {
            ob_start();
            include __DIR__ . '/partials/voting-plugin-hrvoje-public-display.php';
            $voting_buttons = ob_get_clean();
            $content .= $voting_buttons;
        }

        return $content;
    }

    public function handle_vote(){

        if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
            die();
        }

        $post_id = intval($_POST['post_id']);
        $vote_type = sanitize_text_field($_POST['vote_type']);

        if($vote_type !== 'yes' && $vote_type !== 'no'){
            wp_send_json_error('Permission denied');
        }


        $vote_value = get_post_meta($post_id,$vote_type.'_vote_count',true);

        if(intval($vote_value)){
            $vote_value++;
            update_post_meta($post_id, $vote_type.'_vote_count',$vote_value);
        }else{
            update_post_meta($post_id, $vote_type.'_vote_count', 1);
        }


        $yes_votes_count = get_post_meta($post_id,'yes_vote_count',true);
        $no_votes_count = get_post_meta($post_id,'no_vote_count',true);


        if(!intval($yes_votes_count)){
            update_post_meta($post_id,  'yes_vote_count', 0);
            $yes_votes_count = 0;
        }
        if(!intval($no_votes_count)){
            update_post_meta($post_id,  'no_vote_count', 0);
            $no_votes_count = 0;
        }
        $response = array(
            'success' => true,
            'voting_results' => $this->calculate_voting_percentage($yes_votes_count,$no_votes_count),
            'yes_vote_count' => $yes_votes_count,
            'no_vote_count' => $no_votes_count
        );

        echo json_encode($response);



        wp_die();
    }

    public function calculate_voting_percentage($yes_votes = 0,$no_votes = 0){
        $totalVotes = $yes_votes + $no_votes;

        if ($totalVotes > 0) {
            $positivePercentage = ($yes_votes / $totalVotes) * 100;
            $negativePercentage = ($no_votes / $totalVotes) * 100;

            return array(
                'yes_percentage' => round($positivePercentage, 0),
                'no_percentage' => round($negativePercentage, 0),
            );
        } else {
            return array(
                'yes_percentage' => 0,
                'no_percentage' => 0,
            );
        }
    }


}

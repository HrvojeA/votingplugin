<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://votingplugin.xyz
 * @since      1.0.0
 *
 * @package    Voting_Plugin_Hrvoje
 * @subpackage Voting_Plugin_Hrvoje/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Voting_Plugin_Hrvoje
 * @subpackage Voting_Plugin_Hrvoje/admin
 * @author     Hrvoje Antunović <hrvoje1antunovic@gmail.com>
 */
class Voting_Plugin_Hrvoje_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        add_action('add_meta_boxes', array(&$this,'add_voting_results_meta_box'));

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/voting-plugin-hrvoje-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/voting-plugin-hrvoje-admin.js', array( 'jquery' ), $this->version, false );

	}


// Callback function to add meta box
    function add_voting_results_meta_box() {
        add_meta_box(
            'voting_results_meta_box',
            'Voting Results',
            array(&$this,'display_voting_results_meta_box'),
            'post',  // Adjust to your custom post type if needed
            'side',  // Change the context to 'normal' or 'advanced' if needed
            'default'
        );
    }

    public function display_voting_results_meta_box($post) {
        // Retrieve positive and negative votes from post meta
        $positiveVotes = get_post_meta($post->ID, 'yes_vote_count', true);
        $negativeVotes = get_post_meta($post->ID, 'no_vote_count', true);

        $votingPercentages =  $this->calculate_voting_percentage($positiveVotes, $negativeVotes);

        // Display voting results
        echo "Positive Votes Percentage: " . $votingPercentages['yes_percentage'] . "%<br>";
        echo "Negative Votes Percentage: " . $votingPercentages['no_percentage'] . "%";
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

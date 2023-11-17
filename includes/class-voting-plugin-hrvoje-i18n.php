<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://votingplugin.xyz
 * @since      1.0.0
 *
 * @package    Voting_Plugin_Hrvoje
 * @subpackage Voting_Plugin_Hrvoje/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Voting_Plugin_Hrvoje
 * @subpackage Voting_Plugin_Hrvoje/includes
 * @author     Hrvoje Antunović <hrvoje1antunovic@gmail.com>
 */
class Voting_Plugin_Hrvoje_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'voting-plugin-hrvoje',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/willard
 * @since      1.0.0
 *
 * @package    Simple_Exit_Intent
 * @subpackage Simple_Exit_Intent/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Exit_Intent
 * @subpackage Simple_Exit_Intent/admin
 * @author     Willard Macay <willardmacay@gmail.com>
 */
class Simple_Exit_Intent_Admin {

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
		 * defined in Simple_Exit_Intent_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Exit_Intent_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-exit-intent-admin.css', array(), $this->version, 'all' );

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
		 * defined in Simple_Exit_Intent_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Exit_Intent_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-exit-intent-admin.js', array( 'jquery' ), $this->version, false );


		$settings = array(
			'codeEditor' => wp_enqueue_code_editor( array(
				'type' => 'text/html',
				'codemirror' => array(
					'indentUnit' => 2,
					'tabSize' => 2,
				), ))
		);

		wp_enqueue_script( 'custom-js' );
		// wp_add_inline_script( 'custom-css', sprintf( 'jQuery( function( $ ) { wp.codeEditor.init( $( "#exit_intent_page_css" ), %s ); } )', wp_json_encode( $settings ) ) );
		wp_add_inline_script( 'custom-js', 'alert("hello world")');


	}



}

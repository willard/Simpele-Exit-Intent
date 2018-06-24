<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/willard
 * @since      1.0.0
 *
 * @package    Simple_Exit_Intent
 * @subpackage Simple_Exit_Intent/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_Exit_Intent
 * @subpackage Simple_Exit_Intent/public
 * @author     Willard Macay <willardmacay@gmail.com>
 */
class Simple_Exit_Intent_Public {

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

	private $exit_intent_id;

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
		 * defined in Simple_Exit_Intent_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Exit_Intent_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-exit-intent-public.css', array(), $this->version, 'all' );

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
		 * defined in Simple_Exit_Intent_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Exit_Intent_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-exit-intent-public.js', array( 'jquery' ), $this->version, false );

	}


		public function simple_exit_intent_check_page(){

			global $post;
			global $exit_intent_id;
			$current_post_id = $post->ID;
			$args = array(
				'post_type'=>'exit-intent',
			);
			$exit_intents = new WP_Query($args);
			// The Loop
			if ( $exit_intents->have_posts() ) {
				while ( $exit_intents->have_posts() ) {
					$exit_intents->the_post();
					if($current_post_id == get_post_meta( get_the_id(), 'exit_intent_page_ids', true )){
						$this->exit_intent_id = get_the_id();
						add_action('wp_enqueue_scripts', array(__class__,'exit_intent_script'));
						add_action('wp_footer', array($this,'popup_embed'));
						return;
					}
				}
			}
		}

		function get_exit_intent_id(){
			return $this->exit_intent_id;
		}

		public static function exit_intent_script(){
			wp_enqueue_style( 'tingle-css', plugin_dir_url( __FILE__ ) . 'css/tingle.min.css', array(), 1 , 'all' );
			wp_enqueue_script( 'tingle-js', plugin_dir_url( __FILE__ ) . 'js/tingle.min.js', array(), 1 , false );
			wp_enqueue_script( 'exitintent-js', plugin_dir_url( __FILE__ ) . 'js/jquery.exitintent.min.js', array('jquery'), 1 , false );
			wp_enqueue_script( 'cookie-js', plugin_dir_url( __FILE__ ) . 'js/js.cookie.js', array(), 1 , false );
		}

		public function popup_embed(){
			$id = self::get_exit_intent_id();
			$content_post = get_post($id);
			$content = $content_post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
				?>
				<div class="exit-intent-content">
					<?php echo $content;?>
				</div>
				<style>
					.exit-intent-content{
						display: none;
					}
					<?php
					$css = get_post_meta( $id, 'exit_intent_page_css', true );
					echo $css;
					?>
				</style>
				<script type="text/javascript">

				// instanciate new modal
				var modal = new tingle.modal({
				    footer: false,
				    stickyFooter: false,
				    closeMethods: ['button', 'escape'],
				    closeLabel: "Close",
				    cssClass: ['exit-intent', 'exit-intent-id-<?php echo $id; ?>'],
				    onOpen: function() {
				        console.log('modal open');
				    },
				    onClose: function() {
				        console.log('modal closed');
				    },
				    beforeClose: function() {
				        // here's goes some logic
				        // e.g. save content before closing the modal
				        return true; // close the modal
				        return false; // nothing happens
				    }
				});

				// set content
				modal.setContent(document.querySelector('.exit-intent-content').innerHTML);

				// exit intent js
				jQuery(function($) {
					$.exitIntent('enable', { 'sensitivity': 100 });
					$(document).bind('exitintent',
					    function() {
								if(!Cookies.get('exit-intent-id-<?php echo $id; ?>')){
									modal.open();
									Cookies.set('exit-intent-id-<?php echo $id; ?>', true);
								}
					    }
					);
				});
				</script>
				<?php
		}

}

<?php

/**
 *
 */
class Simple_Exit_Intent_Post_Type
{

  /**
	 * Register post types
	 */
	public static function register_post_types() {
		if ( ! post_type_exists( 'exit-intent' ) ) {
			$labels = array(
				'name'                  => _x( 'Exit Intent', 'Post Type General Name', 'exit-intent' ),
				'singular_name'         => _x( 'Exit Intent', 'Post Type Singular Name', 'exit-intent' ),
				'menu_name'             => __( 'Exit Intent', 'exit-intent' ),
				'name_admin_bar'        => __( 'Exit Intent', 'exit-intent' ),
				'archives'              => __( 'Exit Intent Archives', 'exit-intent' ),
				'attributes'            => __( 'Exit Intent Attributes', 'exit-intent' ),
				'parent_item_colon'     => __( 'Parent Exit Intent:', 'exit-intent' ),
				'all_items'             => __( 'All Exit Intent', 'exit-intent' ),
				'add_new_item'          => __( 'Add New Exit Intent', 'exit-intent' ),
				'add_new'               => __( 'Add New', 'exit-intent' ),
				'new_item'              => __( 'New Exit Intent', 'exit-intent' ),
				'edit_item'             => __( 'Edit Exit Intent', 'exit-intent' ),
				'update_item'           => __( 'Update Exit Intent', 'exit-intent' ),
				'view_item'             => __( 'View Exit Intent', 'exit-intent' ),
				'view_items'            => __( 'View Exit Intent', 'exit-intent' ),
				'search_items'          => __( 'Search Exit Intent', 'exit-intent' ),
				'not_found'             => __( 'Not found', 'exit-intent' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'exit-intent' ),
				'items_list'            => __( 'Exit Intent list', 'exit-intent' ),
				'items_list_navigation' => __( 'Exit Intent list navigation', 'exit-intent' ),
				'filter_items_list'     => __( 'Filter Exit Intent list', 'exit-intent' ),
			);


			$args = array(
				'labels'              => $labels,
				'public'              => false,
				'publicly_queryable'  => false,
				'query_var'           => false,
				'exclude_from_search' => true,
				'show_in_nav_menus'   => false,
				'show_ui'             => true,
				//'menu_icon'           => POPMAKE_URL . '/assets/images/admin/dashboard-icon.png',
				'rewrite' => false,  // it shouldn't have rewrite rules
				'menu_position'       => 20.292892729,
				'supports'            =>  array(
												'title',
												'editor',
												'revisions',
												'author',
											),
			 );
			register_post_type( 'exit-intent', $args );
		}
	}

  function exit_intent_add_metaboxes() {
  	add_meta_box(
  		'exit_intent_page_ids',
  		'Page ID',
  		array(__class__,'exit_intent_page_ids'),
  		'exit-intent',
  		'side',
  		'default'
  	);
    add_meta_box(
  		'exit_intent_page_css',
  		'CSS',
  		array(__class__,'exit_intent_page_css'),
  		'exit-intent',
  		'normal',
  		'default'
  	);
  }

  static function exit_intent_page_ids() {
  	global $post;
  	// Nonce field to validate form request came from current site
  	wp_nonce_field( basename( __FILE__ ), 'exit_intent_fields' );
  	// Get the location data if it's already been entered
  	$exit_intent_page_ids = get_post_meta( $post->ID, 'exit_intent_page_ids', true );
  	// Output the field
  	echo '<input type="text" name="exit_intent_page_ids" value="' . esc_textarea( $exit_intent_page_ids )  . '" class="widefat">';
  }

  static function exit_intent_page_css() {
  	global $post;
  	// Nonce field to validate form request came from current site
  	wp_nonce_field( basename( __FILE__ ), 'exit_intent_fields' );
  	// Get the location data if it's already been entered
  	$exit_intent_page_css = get_post_meta( $post->ID, 'exit_intent_page_css', true );
  	// Output the field
  	echo '<textarea rows="4" cols="50" name="exit_intent_page_css" class="widefat" id="exit_intent_page_css">' . esc_textarea( $exit_intent_page_css )  . '</textarea>';
  }
    /**
   * Save the metabox data
   */
  function exit_intent_save_meta( $post_id, $post ) {
  	// Return if the user doesn't have edit permissions.
  	if ( ! current_user_can( 'edit_post', $post_id ) ) {
  		return $post_id;
  	}
  	// Verify this came from the our screen and with proper authorization,
  	// because save_post can be triggered at other times.
  	if ( ! isset( $_POST['exit_intent_page_ids'] ) || ! wp_verify_nonce( $_POST['exit_intent_fields'], basename(__FILE__) ) ) {
  		return $post_id;
  	}
  	// Now that we're authenticated, time to save the data.
  	// This sanitizes the data from the field and saves it into an array $events_meta.
  	$exit_intent_meta['exit_intent_page_ids'] = esc_textarea( $_POST['exit_intent_page_ids'] );
    $exit_intent_meta['exit_intent_page_css'] = esc_textarea( $_POST['exit_intent_page_css'] );
  	// Cycle through the $events_meta array.
  	// Note, in this example we just have one item, but this is helpful if you have multiple.
  	foreach ( $exit_intent_meta as $key => $value ) :
  		// Don't store custom data twice
  		if ( 'revision' === $post->post_type ) {
  			return;
  		}
  		if ( get_post_meta( $post_id, $key, false ) ) {
  			// If the custom field already has a value, update it.
  			update_post_meta( $post_id, $key, $value );
  		} else {
  			// If the custom field doesn't have a value, add it.
  			add_post_meta( $post_id, $key, $value);
  		}
  		if ( ! $value ) {
  			// Delete the meta key if there's no value
  			delete_post_meta( $post_id, $key );
  		}
  	endforeach;
  }


}

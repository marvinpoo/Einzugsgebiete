<?php

/**
 * Registers the TEST post type.
 */
function wpt_test_post_type() {
	$labels = array(
		'name'               => __( 'TEST' ),
		'singular_name'      => __( 'TEST' ),
		'add_new'            => __( 'Add New TEST' ),
		'add_new_item'       => __( 'Add New TEST' ),
		'edit_item'          => __( 'Edit TEST' ),
		'new_item'           => __( 'Add New TEST' ),
		'view_item'          => __( 'View TEST' ),
		'search_items'       => __( 'Search TEST' ),
		'not_found'          => __( 'No TEST found' ),
		'not_found_in_trash' => __( 'No TEST found in trash' )
	);
	$supports = array(
		'title',
		'editor',
		'thumbnail',
		'comments',
		'revisions',
	);
	$args = array(
		'labels'               => $labels,
		'supports'             => $supports,
		'public'               => true,
		'capability_type'      => 'post',
		'rewrite'              => array( 'slug' => 'test' ),
		'has_archive'          => true,
		'menu_position'        => 30,
		'menu_icon'            => 'dashicons-shield-alt',
    'show_in_rest'         => true,
		'register_meta_box_cb' => 'wpt_add_test_metaboxes',
	);
	register_post_type( 'test', $args );
}
add_action( 'init', 'wpt_test_post_type' );


/**
 * Adds a metabox to the right side of the screen under the â€œPublishâ€ box
 */
function wpt_add_test_metaboxes() {
	add_meta_box(
		'wpt_test_meta',
		'TEST META',
		'wpt_test_meta',
		'test',
		'side',
		'default'
	);
}


/**
 * Output the HTML for the metabox.
 */
function wpt_test_meta() {
	global $post;
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'test_fields' );
	// Get the location data if it's already been entered
	$testmeta = get_post_meta( $post->ID, 'testmeta', true );
	// Output the field
	echo '<input type="text" name="testmeta" value="' . esc_textarea( $testmeta )  . '" class="widefat">';
}


/**
 * Save the metabox data
 */
function wpt_save_test_meta( $post_id, $post ) {
	// Return if the user doesn't have edit permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}
	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	if ( ! isset( $_POST['testmeta'] ) || ! wp_verify_nonce( $_POST['test_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}
	// Now that we're authenticated, time to save the data.
	// This sanitizes the data from the field and saves it into an array $events_meta.
	$test_meta['testmeta'] = esc_textarea( $_POST['testmeta'] );
	// Cycle through the $events_meta array.
	// Note, in this example we just have one item, but this is helpful if you have multiple.
	foreach ( $test_meta as $key => $value ) :
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
add_action( 'save_post', 'wpt_save_test_meta', 1, 2 );

?>

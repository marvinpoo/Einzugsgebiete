<?php
  add_action( 'init', 'create_bezirk_taxonomy' );

  function create_bezirk_taxonomy() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'                        => _x( 'Bezirke', 'taxonomy general name', 'textdomain' ),
		'singular_name'               => _x( 'Bezirk', 'taxonomy singular name', 'textdomain' ),
		'search_items'                => __( 'Suche nach Bezirk', 'textdomain' ),
		'all_items'                   => __( 'Alle Bezirke', 'textdomain' ),
		'edit_item'                   => __( 'Bezirk bearbeiten', 'textdomain' ),
		'update_item'                 => __( 'Bezirk aktualisieren', 'textdomain' ),
		'add_new_item'                => __( 'Neuen Bezirk hinzufügen', 'textdomain' ),
		'new_item_name'               => __( 'Neuer Bezirk', 'textdomain' ),
    'choose_from_most_used'       => __( 'Aus meistgenutzten Bezirken wählen' ),
    'separate_items_with_commas'  => __( 'Mehrere Bezirke mit Komma trennen' ),
    'popular_items'               => __( 'Meistegnutzte Bezirke' ),
    'not_found'                   => __( 'Keine Bezirke gefunden' ),
		'menu_name'                   => __( 'Bezirke', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
    'show_in_menu'      => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'bezirke' ),
    'show_in_rest'      => [
      'prepare_callback' => function( $value ) {
        return wp_json_encode( $value );
      }
    ],
	);

  register_taxonomy( 'bezirk_tax', array( 'ot_type', 'bezirk_type', 'brw_type', 'ks_type' ), $args );
};
?>

<?php
  add_action( 'init', 'create_ot_taxonomy' );

  function create_ot_taxonomy() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'                        => _x( 'Ortsteile', 'taxonomy general name', 'textdomain' ),
		'singular_name'               => _x( 'Ortsteil', 'taxonomy singular name', 'textdomain' ),
		'search_items'                => __( 'Suche nach Ortsteil', 'textdomain' ),
		'all_items'                   => __( 'Alle Ortsteile', 'textdomain' ),
		'edit_item'                   => __( 'Ortsteil bearbeiten', 'textdomain' ),
		'update_item'                 => __( 'Ortsteil aktualisieren', 'textdomain' ),
		'add_new_item'                => __( 'Neuen Ortsteil hinzufügen', 'textdomain' ),
		'new_item_name'               => __( 'Neuer Ortsteil', 'textdomain' ),
    'choose_from_most_used'       => __( 'Aus meistgenutzten Ortsteilen wählen' ),
    'separate_items_with_commas'  => __( 'Mehrere Ortsteile mit Komma trennen' ),
    'popular_items'               => __( 'Meistegnutzte Ortsteile' ),
    'not_found'                   => __( 'Keine Ortsteile gefunden' ),
		'menu_name'                   => __( 'Ortsteile', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
    'show_in_menu'      => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'ortsteile' ),
    'show_in_rest'      => [
      'prepare_callback' => function( $value ) {
        return wp_json_encode( $value );
      }
    ],
	);

  register_taxonomy( 'ot_tax', array( 'ot_type', 'brw_type', 'bezirk_type', 'ks_type' ), $args );
};
?>

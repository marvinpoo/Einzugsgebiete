<?php
  add_action( 'init', 'create_plz_taxonomy' );

  function create_plz_taxonomy() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'                        => _x( 'Postleitzahlen', 'taxonomy general name', 'textdomain' ),
		'singular_name'               => _x( 'Postleitzahl', 'taxonomy singular name', 'textdomain' ),
		'search_items'                => __( 'Suche nach Postleitzahl', 'textdomain' ),
		'all_items'                   => __( 'Alle Postleitzahlen', 'textdomain' ),
		'edit_item'                   => __( 'Postleitzahl bearbeiten', 'textdomain' ),
		'update_item'                 => __( 'Postleitzahl aktualisieren', 'textdomain' ),
		'add_new_item'                => __( 'Neue Postleitzahl hinzufügen', 'textdomain' ),
		'new_item_name'               => __( 'Neue Postleitzahl', 'textdomain' ),
    'choose_from_most_used'       => __( 'Aus meistgenutzte Postleitzahlen wählen' ),
    'separate_items_with_commas'  => __( 'Mehrere Postleitzahlen mit Komma trennen' ),
    'popular_items'               => __( 'Meistegnutzte Postleitzahlen' ),
    'not_found'                   => __( 'Keine Postleitzahlen gefunden' ),
		'menu_name'                   => __( 'Postleitzahl', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
    'show_in_menu'      => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'plz' ),
    'show_in_rest'      => [
      'prepare_callback' => function( $value ) {
        return wp_json_encode( $value );
      }
    ],
	);

  register_taxonomy( 'plz', array( 'ot_type' ), $args );
};
?>

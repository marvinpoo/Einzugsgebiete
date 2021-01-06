<?php

function ot_areas_cpt() {

	$labels = array(
		'name'                  => _x( 'Ortsteile', 'Post Type General Name', 'cpt-ot' ),
		'singular_name'         => _x( 'Ortsteil', 'Post Type Singular Name', 'cpt-ot' ),
		'menu_name'             => __( 'Ortsteile', 'cpt-ot' ),
		'name_admin_bar'        => __( 'Ortsteile', 'cpt-ot' ),
		'archives'              => __( 'Ortsteilarchiv', 'cpt-ot' ),
		'attributes'            => __( 'Ortsteil Attribut', 'cpt-ot' ),
		'parent_item_colon'     => __( 'Ortsteil', 'cpt-ot' ),
		'all_items'             => __( 'Ortsteile', 'cpt-ot' ),
		'add_new_item'          => __( 'Neuer Ortsteil', 'cpt-ot' ),
		'add_new'               => __( 'Ortsteil hinzufügen', 'cpt-ot' ),
		'new_item'              => __( 'Neuer Ortsteil', 'cpt-ot' ),
		'edit_item'             => __( 'Ortsteil bearbeiten', 'cpt-ot' ),
		'update_item'           => __( 'Ortsteil updaten', 'cpt-ot' ),
		'view_item'             => __( 'Ortsteil betrachten', 'cpt-ot' ),
		'view_items'            => __( 'Ortsteil betrachten', 'cpt-ot' ),
		'search_items'          => __( 'Ortsteil suchen', 'cpt-ot' ),
		'not_found'             => __( 'Ortsteil nicht gefunden', 'cpt-ot' ),
		'not_found_in_trash'    => __( 'Ortsteil nicht im Papierkorb gefunden', 'cpt-ot' ),
		'featured_image'        => __( 'Ortsteilbild', 'cpt-ot' ),
		'set_featured_image'    => __( 'Ortsteilbild festlegen', 'cpt-ot' ),
		'remove_featured_image' => __( 'Ortsteilbild entfernen', 'cpt-ot' ),
		'use_featured_image'    => __( 'Als Ortsteilbild benutzen', 'cpt-ot' ),
		'insert_into_item'      => __( 'In Ortsteil einfügen', 'cpt-ot' ),
		'uploaded_to_this_item' => __( 'Zum Ortsteil hinzufügen', 'cpt-ot' ),
		'items_list'            => __( 'Liste der Ortsteile', 'cpt-ot' ),
		'items_list_navigation' => __( 'Ortsteil Navigation', 'cpt-ot' ),
		'filter_items_list'     => __( 'Ortsteile filtern', 'cpt-ot' ),
	);
	$args = array(
		'label'                 => __( 'Ortsteil', 'cpt-ot' ),
		'description'           => __( 'Ortsteile', 'cpt-ot' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail'),
		'taxonomies' 						=> array('plz'),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu' 					=> 'einzugsgebiet',
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-multisite',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite' => array('slug' => 'ortsteil'),
	);
	register_post_type( 'ot_type', $args );

}
add_action( 'init', 'ot_areas_cpt', 0 ); ?>

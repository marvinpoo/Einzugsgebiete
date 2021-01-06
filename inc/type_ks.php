<?php

function kiezstimmen_cpt() {

	$labels = array(
		'name'                  => _x( 'Kiezstimmen', 'Post Type General Name', 'cpt-ks' ),
		'singular_name'         => _x( 'Kiezstimme', 'Post Type Singular Name', 'cpt-ks' ),
		'menu_name'             => __( 'Kiezstimmen', 'cpt-ks' ),
		'name_admin_bar'        => __( 'Kiezstimmen', 'cpt-ks' ),
		'archives'              => __( 'Kiezstimmen Archiv', 'cpt-ks' ),
		'attributes'            => __( 'Kiezstimmen Attribut', 'cpt-ks' ),
		'parent_item_colon'     => __( 'Kiezstimme', 'cpt-ks' ),
		'all_items'             => __( 'Kiezstimmen', 'cpt-ks' ),
		'add_new_item'          => __( 'Neue Kiezstimme', 'cpt-ks' ),
		'add_new'               => __( 'Kiezstimme hinzufügen', 'cpt-ks' ),
		'new_item'              => __( 'Neue Kiezstimme', 'cpt-ks' ),
		'edit_item'             => __( 'Kiezstimme bearbeiten', 'cpt-ks' ),
		'update_item'           => __( 'Kiezstimme updaten', 'cpt-ks' ),
		'view_item'             => __( 'Kiezstimme betrachten', 'cpt-ks' ),
		'view_items'            => __( 'Kiezstimmen betrachten', 'cpt-ks' ),
		'search_items'          => __( 'Kiezstimme suchen', 'cpt-ks' ),
		'not_found'             => __( 'Kiezstimme nicht gefunden', 'cpt-ks' ),
		'not_found_in_trash'    => __( 'Kiezstimme nicht im Papierkorb gefunden', 'cpt-ks' ),
		'featured_image'        => __( 'Kiezstimmenbild', 'cpt-ks' ),
		'set_featured_image'    => __( 'Kiezstimmenbild festlegen', 'cpt-ks' ),
		'remove_featured_image' => __( 'Kiezstimmenbild entfernen', 'cpt-ks' ),
		'use_featured_image'    => __( 'Als Kiezstimmenbild benutzen', 'cpt-ks' ),
		'insert_into_item'      => __( 'In Kiezstimme einfügen', 'cpt-ks' ),
		'uploaded_to_this_item' => __( 'Zur Kiezstimme hinzufügen', 'cpt-ks' ),
		'items_list'            => __( 'Liste der Kiezstimmen', 'cpt-ks' ),
		'items_list_navigation' => __( 'Kiezstimmen Navigation', 'cpt-ks' ),
		'filter_items_list'     => __( 'Kiezstimmen filtern', 'cpt-ks' ),
	);
	$args = array(
		'label'                 => __( 'Kiezstimme', 'cpt-ks' ),
		'description'           => __( 'Kiezstimmen', 'cpt-ks' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu' 					=> 'einzugsgebiet',
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-chart-area',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite' => array('slug' => 'kiezstimme'),
	);
	register_post_type( 'ks_type', $args );

}
add_action( 'init', 'kiezstimmen_cpt', 0 ); ?>

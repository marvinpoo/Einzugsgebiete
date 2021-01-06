<?php

function bezirk_district_cpt() {

	$labels = array(
		'name'                  => _x( 'Bezirke', 'Post Type General Name', 'cpt-bezirk' ),
		'singular_name'         => _x( 'Bezirk', 'Post Type Singular Name', 'cpt-bezirk' ),
		'menu_name'             => __( 'Bezirke', 'cpt-bezirk' ),
		'name_admin_bar'        => __( 'Bezirke', 'cpt-bezirk' ),
		'archives'              => __( 'Bezirkarchiv', 'cpt-bezirk' ),
		'attributes'            => __( 'Bezirk Attribut', 'cpt-bezirk' ),
		'parent_item_colon'     => __( 'Bezirk', 'cpt-bezirk' ),
		'all_items'             => __( 'Bezirke', 'cpt-bezirk' ),
		'add_new_item'          => __( 'Neuer Bezirk', 'cpt-bezirk' ),
		'add_new'               => __( 'Bezirk hinzufügen', 'cpt-bezirk' ),
		'new_item'              => __( 'Neuer Bezirk', 'cpt-bezirk' ),
		'edit_item'             => __( 'Bezirk bearbeiten', 'cpt-bezirk' ),
		'update_item'           => __( 'Bezirk updaten', 'cpt-bezirk' ),
		'view_item'             => __( 'Bezirk betrachten', 'cpt-bezirk' ),
		'view_items'            => __( 'Bezirk betrachten', 'cpt-bezirk' ),
		'search_items'          => __( 'Bezirk suchen', 'cpt-bezirk' ),
		'not_found'             => __( 'Bezirk nicht gefunden', 'cpt-bezirk' ),
		'not_found_in_trash'    => __( 'Bezirk nicht im Papierkorb gefunden', 'cpt-bezirk' ),
		'featured_image'        => __( 'Bezirkbild', 'cpt-bezirk' ),
		'set_featured_image'    => __( 'Bezirkbild festlegen', 'cpt-bezirk' ),
		'remove_featured_image' => __( 'Bezirkbild entfernen', 'cpt-bezirk' ),
		'use_featured_image'    => __( 'Als Bezirkbild benutzen', 'cpt-bezirk' ),
		'insert_into_item'      => __( 'In Bezirk einfügen', 'cpt-bezirk' ),
		'uploaded_to_this_item' => __( 'Zum Bezirk hinzufügen', 'cpt-bezirk' ),
		'items_list'            => __( 'Liste der Bezirke', 'cpt-bezirk' ),
		'items_list_navigation' => __( 'Bezirk Navigation', 'cpt-bezirk' ),
		'filter_items_list'     => __( 'Bezirke filtern', 'cpt-bezirk' ),
	);
	$args = array(
		'label'                 => __( 'Bezirk', 'cpt-bezirk' ),
		'description'           => __( 'Bezirke', 'cpt-bezirk' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail'),
		'hierarchical'          => true,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu' 					=> 'einzugsgebiet',
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-admin-site-alt',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
		'rewrite' => array('slug' => 'bezirk'),
	);
	register_post_type( 'bezirk_type', $args );

}
add_action( 'init', 'bezirk_district_cpt', 0 ); ?>

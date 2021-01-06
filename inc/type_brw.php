<?php

function brw_zones_cpt() {

	$labels = array(
		'name'                  => _x( 'Bodenrichtwerte', 'Post Type General Name', 'cpt-brw' ),
		'singular_name'         => _x( 'BRW Zone', 'Post Type Singular Name', 'cpt-brw' ),
		'menu_name'             => __( 'Bodenrichtwerte', 'cpt-brw' ),
		'name_admin_bar'        => __( 'Bodenrichtwerte', 'cpt-brw' ),
		'archives'              => __( 'BRW Archiv', 'cpt-brw' ),
		'attributes'            => __( 'BRW Attribut', 'cpt-brw' ),
		'parent_item_colon'     => __( 'BRW Zone', 'cpt-brw' ),
		'all_items'             => __( 'Bodenrichtwerte', 'cpt-brw' ),
		'add_new_item'          => __( 'Neue BRW Zone', 'cpt-brw' ),
		'add_new'               => __( 'BRW Zone hinzufügen', 'cpt-brw' ),
		'new_item'              => __( 'Neue BRW Zone', 'cpt-brw' ),
		'edit_item'             => __( 'BRW Zone bearbeiten', 'cpt-brw' ),
		'update_item'           => __( 'BRW Zone updaten', 'cpt-brw' ),
		'view_item'             => __( 'BRW Zone betrachten', 'cpt-brw' ),
		'view_items'            => __( 'BRW Zonen betrachten', 'cpt-brw' ),
		'search_items'          => __( 'BRW Zone suchen', 'cpt-brw' ),
		'not_found'             => __( 'BRW Zone nicht gefunden', 'cpt-brw' ),
		'not_found_in_trash'    => __( 'BRW Zone nicht im Papierkorb gefunden', 'cpt-brw' ),
		'featured_image'        => __( 'BRW Zonenbild', 'cpt-brw' ),
		'set_featured_image'    => __( 'BRW Zonenbild festlegen', 'cpt-brw' ),
		'remove_featured_image' => __( 'BRW Zonenbild entfernen', 'cpt-brw' ),
		'use_featured_image'    => __( 'Als BRW Zonenbild benutzen', 'cpt-brw' ),
		'insert_into_item'      => __( 'In BRW Zone einfügen', 'cpt-brw' ),
		'uploaded_to_this_item' => __( 'Zur BRW Zone hinzufügen', 'cpt-brw' ),
		'items_list'            => __( 'Liste der BRW Zonen', 'cpt-brw' ),
		'items_list_navigation' => __( 'BRW Zonen Navigation', 'cpt-brw' ),
		'filter_items_list'     => __( 'BRW Zonen filtern', 'cpt-brw' ),
	);
	$args = array(
		'label'                 => __( 'Bodenrichtwert', 'cpt-brw' ),
		'description'           => __( 'Bodenrichtwerte', 'cpt-brw' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'brw' ),
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
		'rewrite' => array('slug' => 'bodenrichtwertzone'),
	);
	register_post_type( 'brw_type', $args );

}
add_action( 'init', 'brw_zones_cpt', 0 ); ?>

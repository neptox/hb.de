<?php

/**
 * AIT Theme Admin
 *
 * Copyright (c) 2011, AIT s.r.o (http://ait-themes.com)
 *
 */

function aitMenuPostType()
{
	register_post_type( 'ait-menu',
		array(
			'labels' => array(
				'name'			=> MENU_CT_NAME.'s',
				'singular_name' => MENU_CT_NAME,
				'add_new'		=> 'Add new',
				'add_new_item'	=> 'Add new '.strtolower(MENU_CT_NAME),
				'edit_item'		=> 'Edit '.strtolower(MENU_CT_NAME),
				'new_item'		=> 'New '.strtolower(MENU_CT_NAME),
				'not_found'		=> 'No '.strtolower(MENU_CT_NAME).'s found',
				'not_found_in_trash' => 'No '.strtolower(MENU_CT_NAME).'s found in Trash',
				'menu_name'		=> MENU_CT_NAME.'s',
			),
			'description' => 'Manipulating with '.strtolower(MENU_CT_NAME).'s',
			'public' => true,
			'show_in_nav_menus' => true,
			'supports' => array(
				'title',
				'thumbnail',
				'page-attributes',
				'tags',
			),
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_icon' => AIT_FRAMEWORK_URL . '/CustomTypes/menu/menu.png',
			'menu_position' => $GLOBALS['aitThemeCustomTypes']['menu'],
			'has_archive' => 'menus',
			'query_var' => 'menu',
			'rewrite' => array('slug' => 'menu'),
		)
	);
	aitMenuTaxonomies();

        flush_rewrite_rules(false);
}

function aitMenuDefaultBoxes(){
  register_taxonomy_for_object_type('post_tag','ait-menu');
}

function aitMenuTaxonomies()
{

	register_taxonomy( 'ait-menu-category', array( 'ait-menu' ), array(
		'hierarchical' => true,
		'labels' => array(
			'name'			=> MENU_CT_NAME.' Categories',
			'singular_name' => _x( 'Category', 'taxonomy singular name', 'ait'),
			'search_items'	=> __( 'Search Category', 'ait'),
			'all_items'		=> __( 'All Gategories', 'ait'),
			'parent_item'	=> __( 'Parent Category', 'ait'),
			'parent_item_colon' => __( 'Parent Category:', 'ait'),
			'edit_item'		=> __( 'Edit Category', 'ait'),
			'update_item'	=> __( 'Update Gategory', 'ait'),
			'add_new_item'	=> __( 'Add New Category', 'ait'),
			'new_item_name' => __( 'New Category Name', 'ait'),
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'menus' ),
		'query_var' => 'menus',
	));
	// add uncategorized term
	if(!term_exists( 'Uncategorized', 'ait-menu-category' )){
		wp_insert_term( 'Uncategorized', 'ait-menu-category' );
	}
}
add_action( 'init', 'aitMenuPostType');
add_action( 'init', 'aitMenuDefaultBoxes');


function aitMenuFeaturedImageMetabox()
{
	remove_meta_box( 'postimagediv', 'ait-menu', 'side' );
	add_meta_box('postimagediv', 'Image for '.strtolower(MENU_CT_NAME), 'post_thumbnail_meta_box', 'ait-menu', 'normal', 'high');
}
add_action('do_meta_boxes', 'aitMenuFeaturedImageMetabox');

$menuOptions = new WPAlchemy_MetaBox(array
(
	'id' => '_ait-menu',
	'title' => __('Options for menu', 'ait'),
	'types' => array('ait-menu'),
	'context' => 'normal',
	'priority' => 'core',
	'config' => dirname(__FILE__) . '/' . basename(__FILE__, '.php') . '.neon',
));



function aitMenuChangeColumns($cols)
{
	$cols = array(
		'cb'               => '<input type="checkbox" />',
		'title'            => __( 'Title', 'ait'),
		'menu_description' => __( 'Description', 'ait'),
		'menu_price'       => __( 'Price', 'ait'),
		'thumbnail'        => __( 'Image', 'ait'),
		'menu_order'       => __( 'Order', 'ait'),
		'category'         => __( 'Category', 'ait'),
	);

	return $cols;
}
add_filter( "manage_ait-menu_posts_columns", "aitMenuChangeColumns");



function aitMenuCustomColumns($column, $post_id)
{
	global $menuOptions;
	$options = $menuOptions->the_meta();

	switch ($column)
	{

		case "menu_description":

			if(isset($options['menuDescription'])){
				echo "<p>".$options['menuDescription']."</p>";
			}
			unset($options);
			break;

		case "menu_tags":

			if(isset($options['menuTags'])){
				echo "<p>".$options['menuTags']."</p>";
			}
			unset($options);
			break;

		case "menu_price":

			if(isset($options['menuPrice'])){
				echo "<p>".$options['menuPrice']."</p>";
			}
			unset($options);
			break;

	}
}
add_action( "manage_posts_custom_column", "aitMenuCustomColumns", 10, 2);


function aitMenuSortableColumns()
{
	return array(
		'menu_price' => 'menu_price',
		'menu_order' => 'order',
		'category' => 'category',
	);
}
add_filter("manage_edit-ait-menu_sortable_columns", "aitMenuSortableColumns");

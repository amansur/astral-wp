<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'astralweb_flush_rewrite_rules' );

// Flush your rewrite rules
function astralweb_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// let's create the function for the custom type
function projectType() { 
	// creating (registering) the custom type 
	register_post_type( 'project', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => __( 'Projects', 'astralweb' ), /* This is the Title of the Group */
			'singular_name' => __( 'Project', 'astralweb' ), /* This is the individual type */
			'all_items' => __( 'All Projects', 'astralweb' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'astralweb' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Project', 'astralweb' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'astralweb' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Projects', 'astralweb' ), /* Edit Display Title */
			'new_item' => __( 'New Project', 'astralweb' ), /* New Display Title */
			'view_item' => __( 'View Project', 'astralweb' ), /* View Display Title */
			'search_items' => __( 'Search Project', 'astralweb' ), /* Search Custom Type Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'astralweb' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'astralweb' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the example project type', 'astralweb' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'project', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'project', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_rest' => true, /* enable in REST API */
			//'rest_controller_class' => 'AstralController',
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	//register_taxonomy_for_object_type( 'project_cat', 'project' );
	/* this adds your post tags to your custom post type */
	register_taxonomy_for_object_type( 'project_tag', 'project' );
	
}

	// adding the function to the Wordpress init
	add_action( 'init', 'projectType');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
	// register_taxonomy( 'project_cat', 
	// 	array('project'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
	// 	array('hierarchical' => true,     /* if this is true, it acts like categories */
	// 		'labels' => array(
	// 			'name' => __( 'Project Categories', 'astralweb' ), /* name of the custom taxonomy */
	// 			'singular_name' => __( 'Project Category', 'astralweb' ), /* single taxonomy name */
	// 			'search_items' =>  __( 'Search Projects', 'astralweb' ), /* search title for taxomony */
	// 			'all_items' => __( 'All Projects', 'astralweb' ), /* all title for taxonomies */
	// 			'parent_item' => __( 'Parent Project', 'astralweb' ), /* parent title for taxonomy */
	// 			'parent_item_colon' => __( 'Parent Project:', 'astralweb' ), /* parent taxonomy title */
	// 			'edit_item' => __( 'Edit Project', 'astralweb' ), /* edit custom taxonomy title */
	// 			'update_item' => __( 'Update Project', 'astralweb' ), /* update title for taxonomy */
	// 			'add_new_item' => __( 'Add New Project', 'astralweb' ), /* add new title for taxonomy */
	// 			'new_item_name' => __( 'New Project Name', 'astralweb' ) /* name title for taxonomy */
	// 		),
	// 		'show_admin_column' => true, 
	// 		'show_ui' => true,
	// 		'query_var' => true,
	// 		'rewrite' => array( 'slug' => 'project-slug' ),
	// 	)
	// );
	
	// now let's add custom tags (these act like categories)
	register_taxonomy( 'project_tag', 
		array('project'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		array('hierarchical' => false,    /* if this is false, it acts like tags */
			'labels' => array(
				'name' => __( 'Project Tags', 'astralweb' ), /* name of the custom taxonomy */
				'singular_name' => __( 'Project Tag', 'astralweb' ), /* single taxonomy name */
				'search_items' =>  __( 'Search Project Tags', 'astralweb' ), /* search title for taxomony */
				'all_items' => __( 'All Project Tags', 'astralweb' ), /* all title for taxonomies */
				'parent_item' => __( 'Parent Project Tag', 'astralweb' ), /* parent title for taxonomy */
				'parent_item_colon' => __( 'Parent Project Tag:', 'astralweb' ), /* parent taxonomy title */
				'edit_item' => __( 'Edit Project Tag', 'astralweb' ), /* edit custom taxonomy title */
				'update_item' => __( 'Update Project Tag', 'astralweb' ), /* update title for taxonomy */
				'add_new_item' => __( 'Add New Project Tag', 'astralweb' ), /* add new title for taxonomy */
				'new_item_name' => __( 'New Project Tag Name', 'astralweb' ) /* name title for taxonomy */
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
            'show_in_rest' => true,
			//'rest_controller_class' => 'AstralController'
		)
	);
	
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/
	

?>

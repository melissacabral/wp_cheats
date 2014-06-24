<?php 
/**
* Set up theme
*/
add_action( 'init', 'mmc_theme_setup' );

function mmc_theme_setup() {
	/**
	 * Post type - Snippets
	 */
	$labels = array(
		'name'                =>  'Snippets',
		'singular_name'       =>  'Snippet',
		'add_new'             =>  'Add New Snippet', 
		'add_new_item'        =>  'Add New Snippet',
		'edit_item'           =>  'Edit Snippet',
		'new_item'            =>  'New Snippet',
		'view_item'           =>  'View Snippet',
		'search_items'        =>  'Search Snippets',
		'not_found'           =>  'No Snippets found',
		'not_found_in_trash'  =>  'No Snippets found in Trash',
		'parent_item_colon'   =>  'Parent Snippet:',
		'menu_name'           =>  'Snippets',
		);

	$args = array(
		'labels'              => $labels,
		'description'         => 'Code Snippets',
		'public'              => true,
		'menu_icon'           => 'dashicons-media-code',
		'menu_position'		  => 5,
		'has_archive'         => true,
		'supports'            => array(
			'title', 'editor', 'author', 'thumbnail',
			'custom-fields', 'revisions'
			)
		);

	register_post_type( 'snippet', $args );
	
	/**
	 * taxonomy - type
	 */		
	$labels = array(
		'name'					=>  'Snippet Types', 
		'singular_name'			=>  'Snippet Type', 
		'search_items'			=>  'Search Snippet Types', 
		'popular_items'			=>  'Popular Snippet Types', 
		'all_items'				=>  'All Snippet Types', 
		'parent_item'			=>  'Parent Snippet Type', 
		'parent_item_colon'		=>  'Parent Snippet Type', 
		'edit_item'				=>  'Edit Snippet Type', 
		'update_item'			=>  'Update Snippet Type', 
		'add_new_item'			=>  'Add New Snippet Type', 
		'new_item_name'			=>  'New Snippet Type Name', 
		'add_or_remove_items'	=>  'Add or remove Snippet Types', 
		'choose_from_most_used'	=>  'Choose from most used text-domain', 
	);

	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
	);

	register_taxonomy( 'type', array( 'snippet' ), $args );		
	/**
	 * taxonomy - keywords
	 */		
	$labels = array(
		'name'                  =>  'Keywords', 
		'singular_name'         =>  'Keyword', 
		'search_items'          =>  'Search keywords', 
		'popular_items'         =>  'Popular keywords', 
		'all_items'             =>  'All keywords', 
		'parent_item'           =>  'Parent keyword', 
		'parent_item_colon'     =>  'Parent keyword', 
		'edit_item'             =>  'Edit keyword', 
		'update_item'           =>  'Update keyword', 
		'add_new_item'          =>  'Add New keyword', 
		'new_item_name'         =>  'New keyword Name', 
		'add_or_remove_items'   =>  'Add or remove keywords', 
		'choose_from_most_used' =>  'Choose from most used text-domain', 
	);
	$args = array(
		'labels'            => $labels,
		'public'            => true,
		'show_admin_column' => true,
		'hierarchical'      => false,
	);
	register_taxonomy( 'keyword', array( 'snippet' ), $args );		


	/**
	 * Register Menus
	 */
	register_nav_menus(array(
		'top_menu'     => 'Top Menu',
		'sidebar_menu' => 'Sidebar Menu',
		'footer_menu'  => 'Footer Menu',
	) );
}//end theme setup

/**
 * Show snippets on home page
 */
add_filter( 'pre_get_posts', 'my_get_posts' );

function my_get_posts( $query ) {

	if ( is_home() && $query->is_main_query() )
		$query->set( 'post_type', array( 'snippet' ) );

	return $query;
}
/**
 * Gets other posts in the same taxonomy term as current post
 * @param  int $post_id  current post id
 * @param  string $taxonomy taxonomy to relate to
 * @param  array  $args     arguments for the query
 * @return object           results
 */
function get_posts_related_by_taxonomy($post_id,$taxonomy,$args=array()) {
  $query = new WP_Query();
  $terms = wp_get_object_terms($post_id,$taxonomy);
  if (count($terms)) {
    // Assumes only one term for per post in this taxonomy
    $post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
    $post = get_post($post_id);
    $args = wp_parse_args($args,array(
		'post_type'    => $post->post_type, // The assumes the post types match
		'post__in'     => $post_ids,
		'post__not_in' => $post->ID,
		'taxonomy'     => $taxonomy,
		'term'         => $terms[0]->slug,
    ));
    $query = new WP_Query($args);
  }
  return $query;
}
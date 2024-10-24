<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Surgeons;

use \Inc\Base\BaseController;

class SurgeonsCustomPostTypesController extends BaseController
{    

    public function register()
    {
        add_action('init', array($this, 'register_post_type'));
    }

    public function register_post_type()
    {
        $labels = array(
            'name' => _x('Main surgeons', 'textdomain'),
            'singular_name' => _x('surgeons', 'textdomain'),
            'menu_name' => _x('surgeons', 'textdomain'),
            'name_admin_bar' =>  _x('Admin bar', 'textdomain'),
            'add_new' =>  _x('Add New surgeon', 'textdomain'),
            'add_new_item' =>  _x('Add new surgeon', 'textdomain'),
            'new_item' =>  _x('New surgeon', 'textdomain'),
            'edit_item' =>  _x('Edit surgeon', 'textdomain'),
            'view_item' =>  _x('View surgeon', 'textdomain'),
            'all_items' =>  _x('Surgeons', 'textdomain'),
            'search_items' =>  _x('Search surgeon', 'textdomain'),
            'parent_item_colon' =>  _x('Parent item colon', 'textdomain'),
            'not_found' =>  _x('surgeon not found', 'textdomain'),
            'not_found_in_trash' => _x('surgeon not found in trash', 'textdomain'),
            'featured_image' => __( 'Featured Image', 'textdomain' ),
            'set_featured_image' => __( 'Set featured image', 'textdomain' ),
            'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
            'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
            'insert_into_item' => __( 'Insert into item', 'textdomain' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'textdomain' ),
            'items_list' => __( 'Items list', 'textdomain' ),
            'items_list_navigation' => __( 'Items list navigation', 'textdomain' ),
            'filter_items_list' => __( 'Filter items list', 'textdomain' ),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'description' => __('Post images types', 'textdomain'),
            'show_in_menu' => 'cosmetic-gallery', 
            'rewrite' => array('slug' => 'surgeon'),
            'has_archive' => true,
            'menu_position' => 5,
            'supports' => array(
                'title',
                'thumbnail',
            ),
            'can_export' => true,
            'menu_icon' => 'dashicons-format-gallery',
        );
        register_post_type('surgeon', $args);
    }
}

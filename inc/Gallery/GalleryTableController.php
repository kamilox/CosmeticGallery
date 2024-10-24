<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Gallery;

use \Inc\Base\BaseController;

class GalleryTableController extends BaseController
{    

    public function register() {
        add_filter('manage_patients_posts_columns', [$this, 'add_custom_columns']);
        add_action('manage_patients_posts_custom_column', [$this, 'fill_custom_columns'], 10, 2);
        add_filter('manage_edit-patients_sortable_columns', [$this, 'make_columns_sortable']);
    }

    // 1. Add new columns
    public function add_custom_columns($columns) {
        // Insert the columns in the right place
        $columns['name'] = __('Name', 'CosmeticGallery'); 
        $columns['last_name'] = __('Last Name', 'CosmeticGallery'); 
        $columns['surgeon'] = __('Surgeon', 'CosmeticGallery'); 
        $columns['procedures'] = __('Procedures', 'CosmeticGallery'); 
        return $columns;
    }

    // 2. Populate columns with custom values
    public function fill_custom_columns($column, $post_id) {
        switch ($column) {
            case 'name':
    
                $patient_name = get_post_meta($post_id, 'name', true);
                echo esc_html($patient_name ? $patient_name : __('No data', 'CosmeticGallery'));
                break;

            case 'last_name':
    
                $patient_last_name = get_post_meta($post_id, 'last_name', true);
                echo esc_html($patient_last_name ? $patient_last_name : __('No data', 'CosmeticGallery'));
                break;
            case 'surgeon':
    
                $patient_surgeon = get_post_meta($post_id, 'surgeon', true);
                echo esc_html($patient_surgeon ? $patient_surgeon : __('No data', 'CosmeticGallery'));
                break;
            case 'procedures':
    
                $terms = get_the_terms($post_id, 'procedures');
                if (!empty($terms)) {
                    $term_names = wp_list_pluck($terms, 'name'); // Get names of terms
                    echo implode(', ', $term_names); // Display as comma separated list
                } else {
                    echo __('No procedures', 'CosmeticGallery');
                }
                break;
        }
    }

    // 3. Make columns sortable (optional)
    public function make_columns_sortable($columns) {
        $columns['procedures'] = 'procedures'; 
        $columns['name'] = 'name'; 
        $columns['last_name'] = 'last_name'; 
        $columns['surgeon'] = 'surgeon'; 
        return $columns;
    }
} 

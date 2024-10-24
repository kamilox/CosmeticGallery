<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Procedures;

use \Inc\Base\BaseController;

class ProceduresController extends BaseController
{    

    public function register()
    {
        add_action('init', [$this, 'register_taxomonies']);
        add_action('init', [$this, 'add_procedures']);
    }

    public static function register_taxomonies(){

        $procedures = array(
          'labels' => array(
            'name'              => _x('Procedures', 'taxonomy general name', 'Cosmetic Gallery'),
            'singular_name'     => _x('Procedure', 'taxonomy singular name', 'Cosmetic Gallery'),
            'search_items'      => __('Search Procedures', 'Cosmetic Gallery'),
            'all_items'         => __('All Procedures', 'Cosmetic Gallery'),
            'parent_item'       => __('Parent Procedure', 'Cosmetic Gallery'),
            'parent_item_colon' => __('Parent Procedure:', 'Cosmetic Gallery'),
            'edit_item'         => __('Edit Procedure', 'Cosmetic Gallery'),
            'update_item'       => __('Update Procedure', 'Cosmetic Gallery'),
            'add_new_item'      => __('Add New Procedure', 'Cosmetic Gallery'),
            'new_item_name'     => __('New Procedure Name', 'Cosmetic Gallery'),
            'menu_name'         => __('Procedures', 'Cosmetic Gallery'),
            ),
          'public' => true,
          'hierarchical' => true, // Enable subcategories
          'show_ui' => true,
          'show_in_menu' => true,
          'show_in_nav_menus' => true,
          'supports' => array( 'description' ), // Optional: Allow descriptions for terms
          'rewrite' => array( 'slug' =>  'procedures'  ), // Optional: Set slug for URLs
        );
    
        register_taxonomy(  'procedures' , 'patients', $procedures );

    }


    public function add_procedures(){
      $taxonomy = 'procedures';
        $terms = [
            'Face procedures' => [
              'Eyelid Surgery (Blepharoplasty)',
              'Earlobe Repair Procedure',
              'Rhinoplasty Procedure',
              'Facelift and Necklift Procedures',
              'Facial Rejuvenation Procedure',
              'Chin Augmentation (Genioplasty)',
              'NeckSculpt™ (Submental) Liposuction',
              'Fat Transfer Procedure',
              'Asian Eyelid Lift Procedures',
              'Buccal Fat Removal Procedures'
            ],
            'Body Contouring' => [
              'Skinny Mini-Tuck™ | Mini-Tummy Tuck',
              'Mommy Makeover Procedures',
              'Full Tummy Tuck Procedure',
              'SmartLipo Procedures',
              'Brazilian Butt Lift Procedures',
              'Liposuction 360 Procedures',
              'Arm Lift (Brachioplasty)',
              'VASER Hi-Definition Liposuction',
              'Skinny BBL | Country Club BBL™',
              'Renuvion J Plasma Treatment',
              'Hip Augmentation Procedure',
              'Lower Body Liposuction',
              'Plus Size Tummy Tuck',
              'ArmSculpt™ - Arm Liposuction',
              'Lower Body Lift (Belt Lipectomy)',
              'Brazilian Butt Lift Revision',
              'Tummy Tuck with Liposuction - Lipoabdominoplasty'
            ],
            'Breast' => [
              'Breast Augmentation Procedures',
              'Breast Lift Mastopexy',
              'Breast Augmentation Revision',
              'Breast Reduction (Mammaplasty)',
              'Breast Implant Removal',
              'Breast Lift with Implant'
            ],
            'Cosmetic Gynecology' => [
              'Labiaplasty (Lithotomy View)',
              'Mons Pubis Reduction',
              'Labial Puff - Labia Majora Augmentation',
              'Labia Minora Reduction (Standing View)'
            ],
            'Injectables' => [
              'Dermal Fillers Procedure',
              'Neuromodulators',
              'Lip Fillers Injection'
            ],
            'Men’s Procedures' => [
              'Gynecomastia Procedures',
              'Male Lipo Procedures',
              'Male Tummy Tuck Procedure'
            ],
            'Non-Invasive Procedures' => [
              'SculpSure Procedures',
              'EmSculpt - Non-invasive Device',
              'Aveli Cellulite Reduction'
            ],
            'Tattoo Removal' => [
                'Laser Tattoo Removal'
            ],
        ];

        foreach ($terms as $parent => $children) {
            // Insert parent category
            $parent_term = term_exists($parent, $taxonomy);
            if (!$parent_term) {
              $parent_term = wp_insert_term($parent, $taxonomy);
            }
            // If the main category was inserted correctly
            if (!is_wp_error($parent_term)) {
              $parent_id = is_array($parent_term) ? $parent_term['term_id'] : $parent_term; // Get the ID

              // Insert subcategories if they do not exist
              foreach ($children as $child) {
                  if (!term_exists($child, $taxonomy, $parent_id)) {
                      wp_insert_term($child, $taxonomy, [
                          'parent' => $parent_id // Assign the subcategory to the parent category ID
                      ]);
                  }
              }
          }
        }
    }
} 

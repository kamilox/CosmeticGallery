<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Surgeons;

use \Inc\Base\BaseController;

class SurgeonsCustomFieldsController extends BaseController
{    

    public function register()
    {
        add_action( 'add_meta_boxes', [$this,'add_custom_fields'] );
    }
    
    function add_custom_fields() {
        $page = 'surgeon';
        $context = 'normal';
        $priority = 'high';

        add_meta_box( 'surgeon-biography', 'Surgeon Biography', [$this,'surgeon_biography'],$page, $context, $priority );

        add_meta_box( 'surgeon-social', 'Social media', [$this,'surgeon_details'],$page, $context, $priority );
       
    }
   
    public function surgeon_biography($post) {
        global $wpdb;
        $id = get_the_ID();
        $biography = get_post_meta($id, 'surgeon-biography', true);
       
        $case = '<div class="surgeon-item-container">';
            $case .= '<div class="surgeon-item-title">';
                $case .= '<label for="surgeon-biography">Biography:</label>';
            $case .= '</div>';

            $case .= '<div class="custom-fields-input">';
                
            $case .= '<textarea rows="10" cols="100" name="surgeon-biography" id="surgeon-biography">';
                if($biography){
                    $case .= $biography;
                }
            $case .= '</textarea>';

            $case .= '</div>';
        $case .= '</div>';
        echo $case;
    
        
        wp_nonce_field('_namespace_form_metabox_surgeons', '_namespace_form_metabox_surgeons_fields');
    }

    public function surgeon_details($post) {
        global $wpdb;
        $id = get_the_ID();


        foreach ($this->social_media as $key => $social_media_item) {
            $item[$key] = get_post_meta($id, $key, true);
            $case = '<div class="surgeon-item-container">';
                $case .= '<div class="surgeon-item-title">';
                    $case .= '<label for="'.$key.'">'.$social_media_item.':</label>';
                $case .= '</div>';

                $case .= '<div class="custom-fields-input">';
                    
                $case .= '<input type="text" name="'.$key.'" id="'.$key.'" value="'.$item[$key].'">';

                $case .= '</div>';
            $case .= '</div>';
            echo $case;
        }
        
        wp_nonce_field('_namespace_form_metabox_surgeons', '_namespace_form_metabox_surgeons_fields');
    }

    
    
}

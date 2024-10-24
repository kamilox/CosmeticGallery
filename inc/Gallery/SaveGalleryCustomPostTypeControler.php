<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Gallery;

use \Inc\Base\BaseController;

class SaveGalleryCustomPostTypeControler extends BaseController
{    

    public function register()
    {
        add_action('save_post', [$this, 'save_gallery_custom_fields'], 10, 2);
    }

    public function save_gallery_custom_fields($post_id, $post){
        // Check if it is a review or an automatic save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions to edit the post
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Check the nonce for security
        if (!isset($_POST['_namespace_form_metabox_patients_fields']) || 
            !wp_verify_nonce($_POST['_namespace_form_metabox_patients_fields'], '_namespace_form_metabox_patients')) {
            return;
        }

        // Make sure the post type is correct
        if ($post->post_type !== 'patients') {
            return;
        }

         // Now save each field from the 'Case Details' metabox
         $fields = $this->cases_details;
        
         foreach ($fields as $key => $field) {
            
             if (isset($_POST[$key])) {
                if($_POST[$key] == 'diagnosis' || $_POST[$key] == 'treatment' ){
                    update_post_meta($post_id, $_POST[$key], sanitize_textarea_field($_POST[$key]));
                }else{
                    update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
                }
                
             }
         }
 
         // Save the 'surgeon' field
         if (isset($_POST['surgeon'])) {
             update_post_meta($post_id, 'surgeon', sanitize_text_field($_POST['surgeon']));
         }

         if (isset($_POST['images'])) {
            $image_ids = sanitize_text_field($_POST['images']);
            $image_ids_array = explode(',', $image_ids); // Convertir la lista de IDs en un array
            update_post_meta($post_id, 'images', $image_ids_array); // Guardar en el meta field
        }
        
    }
}

<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Surgeons;

use \Inc\Base\BaseController;

class SaveSurgeonsCustomPostTypeControler extends BaseController
{    

    public function register()
    {
        add_action('save_post', [$this, 'save_surgeon_custom_fields'], 10, 2);
    }

    public function save_surgeon_custom_fields($post_id, $post){
       
        // Check if it is a review or an automatic save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions to edit the post
        if (!current_user_can('edit_post', $post_id)) {
            return;
            
        }

        // Check the nonce for security
        if (!isset($_POST['_namespace_form_metabox_surgeons_fields']) || 
            !wp_verify_nonce($_POST['_namespace_form_metabox_surgeons_fields'], '_namespace_form_metabox_surgeons')) {
            return;
        }

        // Make sure the post type is correct
        if ($post->post_type !== 'surgeon') {
            return;
        }
        
         // Save the 'surgeon-biography' field
         if (isset($_POST['surgeon-biography'])) {
            update_post_meta($post_id, 'surgeon-biography', sanitize_textarea_field($_POST['surgeon-biography']));
        }
        // Now save each field from the 'Social media' metabox
         $fields = $this->social_media;
        
         foreach ($fields as $key => $field) {
            
             if (isset($_POST[$key])) {
                 update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
             }
         }
 

    }
}

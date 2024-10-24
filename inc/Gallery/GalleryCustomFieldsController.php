<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Gallery;

use \Inc\Base\BaseController;

class GalleryCustomFieldsController extends BaseController
{    

    public function register()
    {
        add_action( 'add_meta_boxes', [$this,'add_custom_fields'] );
    }
    
    function add_custom_fields() {
        $page = 'patients';
        $context = 'normal';
        $priority = 'high';

        add_meta_box( 'case-details', 'Case Details', [$this,'case_details'],$page, $context, $priority );
        add_meta_box( 'surgeon', 'Surgeon', [$this,'surgeon'], $page, $context, $priority );
        add_meta_box('gallery-box', 'Gallery', [$this,'gallery_meta_box_callback'],$page, $context, $priority );
    }
   

    public function case_details($post) {
        global $wpdb;
        $id = get_the_ID();

        foreach ($this->cases_details as $key => $case_detail) {
            $item[$key] = get_post_meta($id, $key, true);
            $case = '<div class="surgeon-item-container">';
                $case .= '<div class="surgeon-item-title">';
                    $case .= '<label for="'.$key.'">'.$case_detail.':</label>';
                $case .= '</div>';

                $case .= '<div class="custom-fields-input">';

                    if ($key == 'diagnosis' || $key == 'treatment' ) {
                        $case .= '<textarea rows="10" cols="100" name="'.$key.'" id="'.$key.'">';
                            $case .= $item[$key] ;
                        $case .= '</textarea>';
                    }else{
                        $case .= '<input type="text" name="'.$key.'" id="'.$key.'" value="'.$item[$key].'">';
                    }

                $case .= '</div>';
            $case .= '</div>';
            echo $case;
        }

       
        
        wp_nonce_field('_namespace_form_metabox_patients', '_namespace_form_metabox_patients_fields');
    }

    function surgeon($post){
        //recover data from db to edit
        global $wpdb, $post;
        $id = get_the_ID();
        
        $args = array(
            'post_type'      => 'surgeon', // Nombre del Custom Post Type
            'posts_per_page' => -1, // Número de posts a mostrar (-1 para obtener todos)
            'post_status'    => 'publish', // Solo los posts publicados
        );

        $surgeons = get_posts($args);

        $surgeon = get_post_meta($post->ID, 'surgeon', true);
      
    
        ?>
        <fieldset>
            <div class="custom-fields">
                <div class="custom-fields-title">
                    <label for="surgeon">Surgeon:</label>
                </div>
                <div class="custom-fields-input">
                    <select name="surgeon" id="surgeon">
                       
                        <?php 
                            if($surgeon){
                                echo '<option value="'.$surgeon.'">'.$surgeon.'</option>';
                            }else{
                                echo ' <option value="">Select the surgeon</option>';
                            }
                        ?>
                        <?php 
                            foreach($surgeons as $key => $surgeon_name){
                                echo '<option value="'.$surgeon_name->post_title.'">'.$surgeon_name->post_title.'</option>';
                            }
                        ?>
                    </select>
				
                
                </div>
            </div>    
        </fieldset>
        <?php
        wp_nonce_field( '_namespace_form_metabox_patients', '_namespace_form_metabox_patients_fields' );
    }

    function gallery_meta_box_callback($post){
        global $wpdb;
        $id = get_the_ID();	
         // Obtener las imágenes almacenadas
         $images = get_post_meta($post->ID, 'images', true);

        $case = '<div class="surgeon-item-container">';
            $case .= '<div class="surgeon-item-title">';
                $case .= '<label for="images">Images:</label>';
                $case .= '<H3>For best results please use images with 9:16 ratio, example: 350px x 622.22px</h3>';
            $case .= '</div>';

            $case .= '<div class="custom-fields-input">';
                $case .= '<ul id="gallery_preview" class="sortable">';
                    if (!empty($images)) {
                        foreach ($images as $image_id) {
                            $image_url = wp_get_attachment_image_src($image_id, 'thumbnail');
                            $case .= '<li data-id="' . esc_attr($image_id) . '">';
                                if((is_array($image_url) && !empty($image_url)) ){
                                    $case .= '<img src="' . esc_attr($image_url[0]) . '" />';
                                }else{
                                    $case .= '<img src="" />';
                                }
                               
                                $case .= '<button class="remove-image button">Remove</button>';
                            $case .= '</li>';
                        }
                    }
                $case .= '</ul>';
                $case .='<input type="button" class="button upload_gallery_button" value="Select Images">';
                if($images){
                    $case .= '<input type="hidden" id="images" name="images" value="'.(implode("," , $images)).'" />';
                }else{
                    $case .= '<input type="hidden" id="images" name="images" value="" />';
                }
               
            $case .= '</div>';
        $case .= '</div>';
        echo $case;
        wp_nonce_field( '_namespace_form_metabox_patients', '_namespace_form_metabox_patients_fields' );
    }
    
} 

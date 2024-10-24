<?php
/**
 * @package CosmeticGalleryPackage
 * Add CSS an JS Archives
 */

    namespace Inc\Base;

    use \Inc\Base\BaseController;

    class EnqueueController extends BaseController
    {
    public function register(){
        add_action( 'init', array($this, 'equeue_files') );
    }

    public function equeue_files(){
        $version = '1.0.0';
        //CSS
        wp_enqueue_style('cosmetic-gallery-styles-css', $this->plugin_url . 'assets/css/styles.css', [] ,$version, 'all');
        //BASE JS
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_media();
        //CUSTOM JS
        wp_enqueue_script('cosmetic-gallery-scripts-js', $this->plugin_url . 'assets/js/styles.js', ['jquery'], $version, true);
        wp_enqueue_script('taxonomy-image-js', $this->plugin_url . 'assets/js/taxonomy-image.js', ['jquery'], $version, true);
        wp_enqueue_script('carousel-js', $this->plugin_url . 'assets/js/carousel.js', ['jquery'], $version, true);
        // Localize script with AJAX URL y nonce for security
        wp_localize_script('cosmetic-gallery-scripts-js', 'ajaxCall', array( 
            'ajax_url' => admin_url('admin-ajax.php'), // change to 'ajax_url' for conssistence JavaScript
            'nonce'    => wp_create_nonce('get_posts_by_taxonomy_nonce') // Añadir un nonce for security
        ));
        
    }
}
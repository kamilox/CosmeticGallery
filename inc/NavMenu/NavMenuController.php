<?php
/**
 * @package CosmeticGalleryPackage
 * Add CSS an JS Archives
 */

    namespace Inc\NavMenu;

    use \Inc\Base\BaseController;

    class NavMenuController extends BaseController
    {
    public function register(){
        add_action( 'admin_menu', [$this, 'cosmetic_gallery_nav'] );
    }

    // Hook para añadir el menú

    function cosmetic_gallery_nav() {
        // Add main menu
        add_menu_page(
            'Cosmetic Gallery',      
            'Cosmetic Gallery',             
            'manage_options',        
            'cosmetic-gallery',             
            [$this, 'cosmetic_gallery_page'],      
            'dashicons-format-gallery', 
            6                        
        );
        
        // Add submenú
        
        add_submenu_page(
            'cosmetic-gallery',             
            'Settings',       
            'Settings',       
            'manage_options',        
            'cosmetic-gallery-config',      
            [$this, 'cosmetic_gallery_config_page']
        );
        add_submenu_page(
            'cosmetic-gallery',             
            'Procedures',       
            'Procedures',       
            'manage_options',        
            'edit-tags.php?taxonomy=procedures&post_type=patients',      
        );

    }

    // Show main menu content
    function cosmetic_gallery_page() {
        echo '<h1>Wellcome to Cosmetic´s Gallery</h1>';
    }

    // Show submenu content
    function cosmetic_gallery_config_page() {
        echo '<h1>Cosmetic Gallery Settings</h1>';
        echo '<p>Here you can set the buttons, logo and border styles.</p>';
    }

    
}

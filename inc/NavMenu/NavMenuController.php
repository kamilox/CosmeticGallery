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

    public function cosmetic_gallery_nav() {
        // Add main menu
        add_menu_page(
            __('Cosmetic Gallery', 'Cosmetic Gallery'),       
            __('Cosmetic Gallery', 'Cosmetic Gallery'),             
            'manage_options',        
            'cosmetic-gallery',             
            [$this, 'cosmetic_gallery_page'],      
            'dashicons-format-gallery', 
            6                        
        );
        
        // Add submenú
        
        add_submenu_page(
            'cosmetic-gallery',             
            __('Gallery Settings Styles', 'Cosmetic Gallery'),  
            __('Settings Styles', 'Cosmetic Gallery'),       
            'manage_options',        
            'gallery-settings',      
           [$this,'gallery_settings' ]
        );
        add_submenu_page(
            'cosmetic-gallery',             
            __('Procedures','Cosmetic Gallery'),        
            __('Procedures','Cosmetic Gallery'),      
            'manage_options',        
            'edit-tags.php?taxonomy=procedures&post_type=patients',      
        );

    }

    // Show main menu content
    public function cosmetic_gallery_page() {
        echo '<h1>Wellcome to Cosmetic´s Gallery</h1>';
    }

    // Show submenu content
    public function gallery_settings() {
       

        if (!current_user_can('manage_options')) {
            return;
        }

        $template_path = $this->plugin_path . 'inc/templates/gallery-settings.php';
    
        if (file_exists($template_path)) {
            include $template_path;
        } else {
           return;
        }
    }

    
}

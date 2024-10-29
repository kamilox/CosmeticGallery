<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Gallery;

use \Inc\Base\BaseController;
use WP_Query;

class GalleryController extends BaseController
{    

    public function register()
    {
        add_filter('template_include', [$this, 'gallery_template_loader'], 99);
        add_filter('wp_nav_menu_items', [$this,'add_custom_link_to_menu'], 10, 2);
        add_action('init', [$this, 'create_gallery_page']);
    }

    public function create_gallery_page(){
        $page_title = 'Gallery';

        $query = new WP_Query([
            'post_type'   => 'page',
            'title'       => $page_title,
            'post_status' => 'publish'
        ]);

        // Si no existe una página con ese título, se procede a crearla
        if (!$query->have_posts()) {
            $template_path = plugin_dir_path(__FILE__) . 'inc/templates/gallery-patients.php';
            $page_content = file_exists($template_path) ? file_get_contents($template_path) : '';

            // Crear la página con el contenido del archivo
            $page = array(
                'post_title'   => $page_title,
                'post_content' => $page_content,
                'post_status'  => 'publish',
                'post_type'    => 'page'
            );
            $page_id = wp_insert_post($page);
        } else {
            // La página ya existe
            $page_id = $query->posts[0]->ID;
        }
    }
 
    public function add_custom_link_to_menu($items, $args) {
        $location = get_post_meta('themer_location', true);
        if($location){
            if ($args->theme_location == $location) {
                // Crear el enlace personalizado
                $custom_link = '<li class="menu-item"><a href="'.home_url('gallery').'">Gallery</a></li>';
        
                // Agregar el enlace al final del menú
                $items .= $custom_link;
            }

        }else{
            if ($args->theme_location == 'primary') {
                // Crear el enlace personalizado
                $custom_link = '<li class="menu-item"><a href="'.home_url('gallery').'">Gallery</a></li>';
            
                // Agregar el enlace al final del menú
                $items .= $custom_link;
            }
        }
    
        return $items;
    }
    
    public function gallery_template_loader($template) {
        global $wp, $wpdb, $post;
        $urls = explode('/', $wp->request);
        foreach ($urls as $key => $url) {
            switch ($url) {
                case 'gallery':
                    $template = $this->plugin_path . 'inc/templates/gallery-patients.php'; 
                    break;
                case 'procedures':
                    $template = $this->plugin_path . 'inc/templates/procedures-patients.php'; 
                    break;
                case 'patients':
                    $template = $this->plugin_path . 'inc/templates/singular-patients.php'; 
                    break;
            }

        }  
        if ( !file_exists( $template ) ) {
            include $template;
        }
        return $template;
    }
} 

<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Templates;

use \Inc\Base\BaseController;
use WP_Query;

class TemplatesController extends BaseController
{    

    public function register()
    {
        add_filter( 'template_include', [$this, 'procedures_template' ], 99 );
    }

    public function procedures_template($template){
        global $wp;
        $current_url = home_url($wp->request);
        $main_url = explode('/', $current_url);
        foreach ( $main_url as $key => $url) {
            if($url == 'procedures'){
                $template = $this->plugin_path .'inc/Templates/procedures-patients.php';

            }elseif ($url == 'patients') {
                $template = $this->plugin_path .'inc/Templates/singular-patients.php';
            }      
        }
        if ( !file_exists( $template ) ) {
            include $template;
        }
        return $template;
    }


}
<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Base;

class BaseController{
    public $plugin_path;
    public $plugin_url;
    public $plugin_name;
    public $cases_details;
    public $social_media;
    public $surgical_taxonomy;
    public $site_logo_url;

    public function __construct(){
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->plugin_name = plugin_basename(dirname(__FILE__, 3));

        $this->cases_details = [
            'name'=> 'Name',
            'last_name' => 'Last name',
            'age' => 'Age',
            'gender' => 'Gender',
            'height' => 'Height',
            'weight' => 'Weight',
            'diagnosis' => 'Diagnosis', 
            'treatment' => 'Treatment'
        ];

        $this->social_media = [
            'instagram' => 'Instagram',
            'facebook' => 'Facebook',
            'x' => 'X',
            'tiktok' => 'Tiktok',
            'youtube' => 'Youtube',
            'pinterest' => 'Pinterest',
            'threads' => 'Threads',
        ];

        $this->surgical_taxonomy = 'procedures';

        $this->site_logo_url = get_site_icon_url();
    }
    
    public function get_site_logo_url() {
        return $this->site_logo_url;
    }
	
}

<?php
/*
 * Plugin Name:       Cosmetic Gallery
 * @package           CosmeticGalleryPackage
 * @author            Intelindev Team
 * @copyright         2024 Intelindev
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin URI:        https://intelindev.com/products/
 * Description:       Cosmetic Gallery allows you to create contact forms that avoid the use of bots that generate spam and affect your web business. 100% customizable and adaptable to different devices.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Intelindev Team
 * Author URI:        https://intelindev.com/our-team/
 * Text Domain:       smart-email
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
*/

if ( ! defined( 'ABSPATH' ) ) { die( 'Invalid request.' ); }

if(file_exists(dirname(__FILE__).'/vendor/autoload.php')){
    require_once dirname(__FILE__).'/vendor/autoload.php';
}


use Inc\Base\Activate;
use Inc\Base\Deactivate;

function activate_cosmetic_gallery(){
    Activate::activate();
}

function deactivate_cosmetic_gallery(){
    Deactivate::deactivate();
}

register_activation_hook(__FILE__, 'activate_cosmetic_gallery' );
register_deactivation_hook(__FILE__, 'deactivate_cosmetic_gallery' );



if(class_exists('Inc\\Init')){
    Inc\Init::register_services();
}
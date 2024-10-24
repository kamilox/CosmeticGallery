<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * DEACTIVATION HOOKS
 */

 namespace Inc\Base;

 class Deactivate
 {
    public static function deactivate(){
        flush_rewrite_rules();
    }

 }
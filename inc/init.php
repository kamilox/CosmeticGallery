<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * Init plugin
 */

namespace Inc;

final class Init{

    public static function get_services(){
        return [
            Base\EnqueueController::class,
            NavMenu\NavMenuController::class,

            Gallery\GalleryController::class,
            Gallery\GalleryCustomPostTypeControler::class,
            Gallery\GalleryCustomFieldsController::class,
            Gallery\SaveGalleryCustomPostTypeControler::class,
            Gallery\GalleryTableController::class,
            
            GallerySettings\GallerySettingsController::class,

            Procedures\ProceduresController::class,
            Procedures\TaxonomyImageController::class,

            Surgeons\SurgeonsCustomPostTypesController::class,
            Surgeons\SurgeonsCustomFieldsController::class,
            Surgeons\SaveSurgeonsCustomPostTypeControler::class

        ];
    }

    public static function register_services(){
        foreach (self::get_services() as $class){
            $service = self::instantiate($class);
            if(method_exists($service, 'register')){
                $service->register();
            }
        }
    }

    private static function instantiate($class){
        $service = new $class;
        return $service;
    }

}
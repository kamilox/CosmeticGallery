<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\GallerySettings;

use \Inc\Base\BaseController;
use WP_Query;

class GallerySettingsController extends BaseController
{
    /*




titles[
    font-size
    font-color
    font-weight
]
gallery-item[
    border-color
    border-weight
    border-radius
    title[
        font[
            color,
            size,
            weight
        ]
    ]
    image[
        logo
    ]
    button[
        border-color
        border-weight
        border-radius
        background_color
        hover[
            border-color
            border-weight
            border-radius
            background_color
        ]
        font[
            color,
            size,
            weight
        ]
    ]
]
patient[
    top-buttons[
        border-color
        border-weight
        border-radius
        background_color
        hover[
            border-color
            border-weight
            border-radius
            background_color
        ]
        font[
            color,
            size,
            weight
        ]
    ]
]
*/
    private $fields = [
        
        'border_color' => [
            'label' => 'Border Color',
            'type'  => 'text',
        ],
        'border_radius' => [
            'label' => 'Border Radius',
            'type'  => 'text',
        ]
    ];

    public function register()
    {
        add_action('admin_init', [$this, 'registerCustomPostFields']);
        add_action('wp_head', [$this, 'gallery_custom_gallery_styles']);
    }

    public function registerCustomPostFields()
    {
        register_setting('gallery_settings_group', 'gallery_settings');

        add_settings_section(
            'gallery_settings_section',
            __('Colors styles', 'Cosmetic Gallery'),
            [$this, 'gallery_settings_section_callback'],
            'gallery-settings'
        );

        add_settings_section(
            'gallery_settings_section',
            __('Site logo', 'Cosmetic Gallery'),
            [$this, 'gallery_settings_section_callback'],
            'gallery-settings'
        );

        foreach ($this->fields as $field_id => $field) {
            add_settings_field(
                $field_id,
                $field['label'],
                [$this, 'renderField'],
                'gallery-settings',
                'gallery_settings_section',
                [
                    'id'   => $field_id,
                    'type' => $field['type'],
                ]
            );
        }
    }

    public function gallery_settings_section_callback()
    {
        echo '<p>' . __('Configure gallery options.', 'Cosmetic Gallery') . '</p>';
    }

    public function renderField($args)
    {
        $options = get_option('gallery_settings');
        $field_id = $args['id'];
        $type = $args['type'];
        $value = $options[$field_id] ?? '';

        echo "<input type='{$type}' id='gallery_settings[{$field_id}]' name='gallery_settings[{$field_id}]' value='" . esc_attr($value) . "' />";
    }

    function gallery_custom_gallery_styles() {
        $gallery_settings = get_option('gallery_settings');

        $border_color = isset($gallery_settings['border_color']) ? esc_attr($gallery_settings['border_color']) : '#000000';
        $border_radius = isset($gallery_settings['border_radius']) ? esc_attr($gallery_settings['border_radius']) : '0px';

        echo "<style>
            .custom-gallery {
                border-color: {$border_color};
                border-radius: {$border_radius};
            }
        </style>";
    }
}
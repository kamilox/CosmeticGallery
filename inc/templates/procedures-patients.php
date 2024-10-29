<?php
/*
Template Name: Single Patients
*/
get_header();

require_once plugin_dir_path(__FILE__) . '../Base/BaseController.php';

// Crear una instancia de la clase
$base_controller = new \Inc\Base\BaseController();

// Obtener la URL del logo del sitio
$site_logo_url = $base_controller->get_site_logo_url();

$category = get_queried_object();
$category_slug = '';

if ($category && isset($category->slug)) {
    $category_name = $category->name;  // Nombre de la categoría
    $category_id = $category->term_id;  // ID de la categoría
    $category_slug = $category->slug;  // Slug de la categoría
}

$args = array(
    'post_type' => 'patients',            // Custom post type "patients"
    'posts_per_page' => -1,               // Obtener todos los posts (sin límite)
    'post_status' => 'publish',           // Incluir solo posts publicados
    'orderby' => 'ID',                    // Ordenar por ID del post
    'order' => 'ASC',                     // Orden ascendente (cambiar a DESC para descendente)
    'tax_query' => array(                 // Consultar por la taxonomía asociada (categoría)
        array(
            'taxonomy' => 'procedures',   // La taxonomía a usar (cambiar si es diferente)
            'field' => 'slug',            // Usar el slug para filtrar
            'terms' => $category_slug,    // El slug de la categoría
        ),
    ),
);

$posts = get_posts($args);
?>
<main id="content" class="site-main">
    <div class="gallery-container">
        <h1><?php echo esc_html($category_name); ?></h1>
        <div class="gallery-content">
<?php
if ($posts) {
    echo '<div class="procedure-categories-wrapper">';
    foreach ($posts as $post) {
        echo '<div class="procedure-category">';
        $title = get_the_title($post->ID);
        $images = get_post_meta($post->ID, 'images', true);
        $link = get_permalink($post->ID);
        $logo = get_post_meta($post->ID, 'logo', true);

        // Check if $images is an array and contains at least two elements
        if (is_array($images) && count($images) >= 2) {
            for ($i = 0; $i < 2; $i++) {
                $image_url = wp_get_attachment_image_src($images[$i], 'full');

                // Check if the image URL is valid
                if ($image_url) {
                    echo '<div class="procedure-category-image" style="background-image:url(' . $image_url[0] . ')">';
                    if ($i == 0) {
                        echo '<span>Before</span>';
                        echo '<div class="procedure-category-image-post-link">';
                        echo '<a href="' . add_query_arg('procedure', $category_name, $link) . '">';
                        echo '<span class="dashicons dashicons-visibility"></span>';
                        echo 'Open Case Details';
                        echo '</a>';
                        echo '</div>';
                    } else {
                        echo '<span>After</span>';
                    }

                    echo '<div class="procedure-category-image-site-logo">';
                    if ($logo) {
                        switch ($variable) {
                            case '0':
                                echo 'no logo ';
                                break;
                            case '1':
                                echo 'site logo';
                                break;
                            case '2':
                                echo 'user logo';
                                break;
                        }
                    }
                    echo '</div>'; // Close .procedure-category-image-site-logo
                    echo '</div>'; // Close .procedure-category-image
                }
            }
        } else {
            echo '<div class="procedure-category-image" style="background-image:url(' . $site_logo_url . ')">';
            echo '<span>Before</span>';
            echo '<div class="procedure-category-image-post-link">';
            echo '<a href="' . $link . '">';
            echo '<span class="dashicons dashicons-visibility"></span>';
            echo 'Open Case Details';
            echo '</a>';
            echo '</div>';
            echo '</div>';
            echo '<div class="procedure-category-image" style="background-image:url(' . $site_logo_url . ')">';
            echo '<span>After</span>';
            echo '</div>';
        }

        echo '</div>'; // Close .procedure-category
    }
    echo '</div>'; // Close .procedure-categories-wrapper
}
?>
        </div><!-- gallery-content-->
    </div><!-- gallery-container-->
</main>
<?php

get_footer();
?>

<?php
/*
Template Name: Procedures Patients
*/
get_header();

require_once plugin_dir_path(__FILE__) . '../Base/BaseController.php';

// Crear una instancia de la clase
$base_controller = new \Inc\Base\BaseController();

// Obtener la URL del logo del sitio
$site_logo_url = $base_controller->get_site_logo_url();

$category_slug = '';
$category_name = '';

// Obtener el segmento de la URL después de "procedures/"
$url_parts = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
$key = array_search('procedures', $url_parts);

if ($key !== false && isset($url_parts[$key + 1])) {
    $category_slug = sanitize_title($url_parts[$key + 1]); // Slug de la categoría
    $term = get_term_by('slug', $category_slug, 'procedures'); // Buscar el término
    if ($term) {
        $category_name = $term->name; // Nombre de la categoría
    }
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
        <h1>Procedures <?php echo esc_html($category_name); ?></h1>
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

                    foreach (explode(',', $images) as $key => $image) {
                       if($key < 2){
                        echo '<div class="procedure-category-image" style="background-image:url(' . $image . ')">';
                        if ($key == 0) {
                            echo '<span>Before</span>';
                            echo '<div class="procedure-category-image-post-link">';
                            echo '<a href="' .  $link . '">';
                            echo '<span class="dashicons dashicons-visibility"></span>';
                            echo 'Open Case Details #: '.$title ;
                            echo '</a>';
                            echo '</div>';
                        } else {
                            echo '<span>After</span>';
                        }

                        echo '<div class="procedure-category-image-site-logo">';
                        if ($logo) {
                            echo 'Logo: ' . esc_html($logo);
                        }
                        echo '</div>'; // Close .procedure-category-image-site-logo
                        echo '</div>'; // Close .procedure-category-image
                       }
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

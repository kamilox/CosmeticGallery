<?php
/*
Template Name: Single Patients
*/
get_header();

$category = get_queried_object();
$category_name = $category->name;  // Nombre de la categoría
$category_id = $category->term_id;  // ID de la categoría
$category_slug = $category->slug;  // Slug de la categoría

$args = array(
    'post_type' => 'patients',            // Custom post type "patients"
    'posts_per_page' => -1,               // Obtener todos los posts (sin límite)
    'post_status' => 'publish',           // Incluir solo posts publicados
    'orderby' => 'ID',                    // Ordenar por ID del post
    'order' => 'ASC',                     // Orden ascendente (cambiar a DESC para descendente)
    'tax_query' => array(                 // Consultar por la taxonomía asociada (categoría)
        array(
            'taxonomy' => 'procedures',     // La taxonomía a usar (cambiar si es diferente)
            'field' => 'slug',            // Usar el slug para filtrar
            'terms' => $category_slug,    // El slug de la categoría
        ),
    ),
);

$posts = get_posts($args);

?>
<main id="content" class="site-main">
    <div class="gallery-container">
        <h1><?php echo esc_html__( $category->name); ?></h1>
        <div class="gallery-content">
<?php
if($posts){
    echo '<div class="procedure-categories-wrapper">';
        foreach($posts as $post){
            echo '<div class="procedure-category">';
                $title = get_the_title($post->ID);
                $images = get_post_meta( $post->ID , 'images', true );
                $link = get_permalink($post->ID );
                $logo = get_post_meta( $post->ID , 'logo', true );
                
                for ($i = 0; $i < 2; $i++) {
                    $image_url = wp_get_attachment_image_src( $images[$i] , 'full' );
                    echo '<div class="procedure-category-image" style="background-image:url('.$image_url[0].')" >';
                        if($i == 0){
                            echo '<span>Before</span>';
                            echo '<div class="procedure-category-image-post-link">';
                                echo '<a href="'.$link.'">';
                                    echo '<span class="dashicons dashicons-visibility"></span>';
                                    echo 'Open Case Details';
                                echo '</a>';
                            echo '</div>';
                        }else{
                            echo '<span>After</span>';
                        }
                        echo '<div class="procedure-category-image-site-logo">';
                            if($logo){
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
                            
                        echo '</div>';
                        
                    echo '</div>';
                }
            echo '</div>';
        }
    echo '</div>';
}
?>
        </div><!-- gallery-content-->
    </div><!-- gallery-container-->
</main>
<?php

get_footer();

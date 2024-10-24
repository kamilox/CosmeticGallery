<?php
/*
Template Name: Gallery
*/
get_header();
$taxomony = 'procedures';

$parent_categories = get_terms(array(
    'taxonomy'   => $taxomony,
    'hide_empty' => false,
    'parent'     => 0, // Solo categorías padre
));
?>
<main id="content" class="site-main">
    <div class="gallery-container">
        <h1>Gallery</h1>
        <div class="gallery-content">
            <?php

                if (!empty($parent_categories) && !is_wp_error($parent_categories)) {
                    echo '<div class="parent-categories-wrapper">';

                    foreach ($parent_categories as $parent_category) {
                        // Obtener la imagen destacada (si la tiene)
                        $image_id = get_term_meta($parent_category->term_id, 'category_image', true);
                        $image_url = wp_get_attachment_url($image_id);

                        echo '<div class="parent-category">';

                        // Mostrar la imagen de la categoría padre
                        if ($image_url) {
                            echo '<div class="parent-category-image" style="background-image:url('.$image_url.')" >';
                            echo '</div>';
                        }else{
                            if ( has_custom_logo() ) {
                                $custom_logo_id = get_custom_logo();
                                $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                                echo '<div class="parent-category-image" style="background-image:url('.esc_url( $image[0] ) .')" >';
                                echo '</div>';
                            }else{
                                echo '<div class="parent-category-image parent-category-image-default"  style="background-image:url('.home_url().'/wp-content/plugins/CosmeticGallery/assets/images/basic-category.webp)">';
                                    
                                echo '</div>';
                            }

                            
                        }

                        // Mostrar el nombre de la categoría padre
                        echo '<h2>' . esc_html($parent_category->name) . '</h2>';

                        // Obtener las categorías hijo
                        $child_categories = get_terms(array(
                            'taxonomy'   => $taxomony,
                            'hide_empty' => false,
                            'parent'     => $parent_category->term_id,
                        ));

                        // Si hay categorías hijo, iteramos sobre ellas
                        if (!empty($child_categories) && !is_wp_error($child_categories)) {
                            echo '<ul class="child-categories">';
                    
                            foreach ($child_categories as $child_category) {
                                // Verificar si la categoría hijo tiene posts
                                $posts_in_category = get_posts(array(
                                    'post_type'   => 'patients', // Tu CPT
                                    'tax_query'   => array(
                                        array(
                                            'taxonomy' => $taxomony,
                                            'field'    => 'term_id',
                                            'terms'    => $child_category->term_id,
                                        ),
                                    ),
                                    'posts_per_page' => 1, // Solo necesitamos saber si tiene al menos un post
                                ));

                                if (!empty($posts_in_category)) {
                                    // Mostrar el enlace a la plantilla personalizada filtrada por la categoría hijo
                                    echo '<li>';
                                    echo '<a href="' . esc_url(get_term_link($child_category)) . '">' . esc_html($child_category->name) . '</a>';
                                    echo '</li>';
                                }
                            }

                            echo '</ul>';
                        }

                        echo '</div>'; // Cerrar categoría padre
                    }

                    echo '</div>'; // Cerrar el contenedor principal
                } else {
                    echo '<p>' . __('No categories found', 'your-plugin') . '</p>';
                }
            
            
            ?>
            <!-- Aquí puedes incluir el código que necesites para mostrar la galería -->
        </div>
    </div>
</main>
<?php
get_footer();
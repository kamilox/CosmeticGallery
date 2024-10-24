<?php
/*
Template Name: Single Patients
*/
get_header();
global $wp, $post;
$post_id = $post->ID;

$name = get_post_meta($post_id, 'name', true);
$last_name = get_post_meta($post_id, 'last_name', true);
$age = get_post_meta($post_id, 'age', true);
$gender = get_post_meta($post_id, 'gender', true);
$height = get_post_meta($post_id, 'height', true);
$weight = get_post_meta($post_id, 'weight', true);
$diagnosis = get_post_meta($post_id, 'diagnosis', true);
$treatment = get_post_meta($post_id, 'treatment', true);
$surgeon = get_post_meta($post_id, 'surgeon', true);
$images = get_post_meta($post_id, 'images', true);
$contact_us = get_post_meta( 'contact_us', true);
$taxonomy = 'procedures';
$terms = wp_get_post_terms($post_id, $taxonomy);
$term_id = get_queried_object_id();
function JoinImages($images) {
    $imagesJoined = [];
    for ($i = 0; $i < count($images); $i += 2) {
        $imagesJoined[] = [
            $images[$i],
            isset($images[$i + 1]) ? $images[$i + 1] : null
        ];
    }
    return $imagesJoined;
}

function get_term_ancestors_with_links($term_id) {
    $taxonomy = 'procedures';
    $ancestors = get_ancestors($term_id, $taxonomy);
    $ancestor_links = array();
    foreach ($ancestors as $ancestor) {
        $ancestor_term = get_term($ancestor);
        $ancestor_links[] = '<a href="' . get_term_link($ancestor_term) . '">' . $ancestor_term->name . '</a>';
    }
    return implode(', ', $ancestor_links);
}

// Array para almacenar los IDs de las categorías

?>

<div class="gallery-container">
    <h1> Case #<?php the_title(); ?></h1>
    <div class="gallery-content">
        <div class="gallery-images">
            <div class="gallery-images-top">
                <?php
                    if(!empty($images)){
                        foreach ($images as $key => $image) {
                            $image_url = wp_get_attachment_url($image);
                            if($key < 2){
                                echo '<div class="gallery-images-item-top">';
                                    echo '<div class="gallery-images-top-item">';
                                        echo '<img src="'.$image_url.'">';
                                    echo '</div>';
                                    if($key  == 0){
                                        echo '<div><h2>'. esc_html__( 'Before').'</h2></div>';
                                    }
                                    if($key  == 1){
                                        echo '<div><h2>'. esc_html__( 'After').'</h2></div>';
                                    }
                                echo '</div>';
                            }
                            
                        }
                    }
                ?>
            </div>
            <div class="gallery-images-carousel">
                <div class="carousel">
                    <button class="prev">&#10094;</button>
                        <div class="carousel-inner">
                            <?php
                            $imagesJoined = JoinImages($images);
                            $groupedImages = array_chunk($imagesJoined , 4);
                            foreach ($groupedImages as $key => $imagesPar) {
                                foreach ($imagesPar as $key => $imagesParItem) {
                                        echo '<div class="carousel-item">';
                                        foreach ($imagesParItem as $key => $item) {
                                            $image_url = wp_get_attachment_url( $item);
                                            if ($image_url) {
                                                echo '<div class="gallery-images-carousel-par-item">';
                                                    echo ' <img src="' . esc_url($image_url) . '" alt="">';
                                                echo '</div>';
                                            }
                                        }
                                        echo '</div>';
                                }  
                            }
                            ?>
                        </div>
                    <button class="next">&#10095;</button>
                </div>
            </div>
        </div>
        <div class="gallery-info">
            <div class="gallery-info-patient">
                <div><h2>Case Details</h2></div>
                <?php

                if($age){
                    echo '<div class="gallery-info-patient-item">';
                        echo '<label>Age: </label>';
                        echo '<div class="gallery-info-patient-details">'.$age.'</div>';
                    echo '</div>';
                }
                if($gender){
                    echo '<div class="gallery-info-patient-item">';
                        echo '<label>Gender: </label>';
                        echo '<div class="gallery-info-patient-details">'.$gender.'</div>';
                    echo '</div>';
                }
                if($height){
                    echo '<div class="gallery-info-patient-item">';
                        echo '<label>Height:</label>';
                        echo '<div class="gallery-info-patient-details">'.$height.'</div>';
                    echo '</div>';
                }
                if($weight){
                    echo '<div class="gallery-info-patient-item">';
                        echo '<label>Weight: </label>';
                        echo '<div class="gallery-info-patient-details">'.$weight.'</div>';
                    echo '</div>';
                }
                if($diagnosis){
                    echo '<div class="gallery-info-patient-item">';
                        echo '<label>Diagnosis: </label>';
                        echo '<div class="gallery-info-patient-details">'.$diagnosis.'</div>';
                    echo '</div>';
                }
                if($treatment){
                    echo '<div class="gallery-info-patient-item">';
                        echo '<label>Treatment</label>';
                        echo '<div class="gallery-info-patient-details">'.$treatment.'</div>';
                    echo '</div>';
                }
                if($surgeon){
                    echo '<div class="gallery-info-patient-item">';
                        echo '<label>Surgeon: </label>';
                        echo '<div class="gallery-info-patient-details">'.$surgeon.'</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <div class="gallery-info-procedure">
                <div><h2>Procedures</h2></div>
                <?php
                // Mostrar los términos y sus enlaces
                foreach ($terms as $term) {
                    echo '<div class="gallery-info-patient-item">';
                    echo '<label><a href="'.get_term_link($term->term_id).'">' . $term->name . '<span class="dashicons dashicons-admin-links"></span></a></label>';
                
                    
                    $child_terms = get_terms(array(
                        'parent' => $term->term_id,
                        'taxonomy' => $taxonomy
                    ));

                    if (!empty($child_terms)) {
                        foreach ($child_terms as $child_term) {
                            echo '<a href="' . get_term_link($child_term) . '">' . $child_term->name . '</a>, ';
                        }
                    }
                
                    echo '</div>';
                }
                ?>
                <div>Interested in a similar procedure?</div>
                <div class="contact-us">
                    <?php
                        if($contact_us){
                            echo '<a ahref="'.$contact_us.'">Contact us <span class="dashicons dashicons-email-alt"></span> </a>';
                        }else{
                            echo '<a ahref="'.home_url().'">Contact us <span class="dashicons dashicons-email-alt"></span> </a>';
                        }
                    
                    ?>
                </div>
            </div>
        </div>
        <div class="gallery-related">
            <div class="gallery-related-items">
                <?php
                $terms = wp_get_post_terms($post_id, $taxonomy);
                if ( !empty($terms) && !is_wp_error($terms) ) {
                    foreach ($terms as $key => $term) {
                        if($key < 1){

                       
                            // Si el término tiene un término padre (parent != 0)
                            if ($term->parent != 0) {
                                $parent_term = get_term($term->parent, $taxonomy); // Obtener el término padre

                                echo '<h3>Other ' . $parent_term->name . ' Procedures</h3>';
                
                                // Obtener los términos hermanos (otros hijos del mismo padre)
                                $sibling_terms = get_terms(array(
                                    'taxonomy' => $taxonomy,
                                    'parent' => $parent_term->term_id,
                                    'exclude' => array($term->term_id), // Excluir el término actual
                                    'hide_empty' => false, // Mostrar términos vacíos si es necesario
                                ));
                                
                                if ( !empty($sibling_terms) && !is_wp_error($sibling_terms) ) {
                    
                                    foreach ($sibling_terms as $key => $sibling) {
                                        if($key < 4){

                                            // Obtener el primer post del término hermano
                                            $args = array(
                                                'post_type' => 'patients', // Reemplaza 'custom_post_type' por tu custom post type
                                                'posts_per_page' => 1, // Obtener solo el primer post
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => $taxonomy,
                                                        'field' => 'term_id',
                                                        'terms' => $sibling->term_id,
                                                    ),
                                                ),
                                            );
                                            $sibling_posts = get_posts($args);

                                            if ( !empty($sibling_posts) ) {
                                                $first_post = $sibling_posts[0];
                                                $images_post = get_post_meta($first_post->ID, 'images', true);
                                            
                                                echo '<div class="related-patients">';
                                                    echo '<a href="'.get_the_permalink($first_post->ID).'">';
                                                        for ($i=0; $i < 2; $i++) { 
                                                            $image_url = wp_get_attachment_image_src( $images_post[$i] , 'full' );
                                                            echo '<div class="related-patients-image">';
                                                                echo '<img src="'.$image_url[0].'">';
                                                            echo '</div>';
                                                        }
                                                        echo '<span>'.$sibling->name.'</span>';
                                                    echo '</a>';
                                                echo '</div>';
                                                //echo '<p>Primer post del término hermano: <a href="' . get_permalink() . '">' . get_the_title($first_post->ID) . '</a></p>';
                                            } 
                                        }
                                    }
                            
                                }
                                
                            } else {
                                echo '<p>Este término no tiene un padre, por lo tanto, no tiene hermanos.</p>';
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
    
</div>

<?php
get_footer();

<?php
/**
 * @package CosmeticGalleryPackage
 * 
 * 
 * ACTIVATION HOOKS
 */

namespace Inc\Procedures;

use \Inc\Base\BaseController;

class TaxonomyImageController extends BaseController
{    

  public function register() {
    add_action('procedures_add_form_fields', [$this, 'add_category_image_field']);
    add_action('procedures_edit_form_fields', [$this, 'edit_category_image_field']);
    add_action('created_procedures', [$this, 'save_category_image']);
    add_action('edited_procedures', [$this, 'save_category_image']);
  }

  // Campo para añadir imagen en el formulario de agregar categoría
  public function add_category_image_field($taxonomy) {
      ?>
      <div class="form-field term-group">
          <label for="category-image"><?php _e('Image', 'CosmeticGallery'); ?></label>
          <input type="button" class="button upload_image_button" id="upload_image_button" value="Upload Image" />
            
          <input type="hidden" id="category_image" name="category_image" value="" />
          <div id="category_image_preview"></div>
      </div>
      <?php
  }

  // Campo para editar imagen en el formulario de editar categoría
  public function edit_category_image_field($term) {
      $image_id = get_term_meta($term->term_id, 'category_image', true);
      ?>
      <tr class="form-field term-group-wrap">
          <th scope="row">
              <label for="category-image"><?php _e('Image', 'CosmeticGallery'); ?></label>
              
          </th>
          <td>
              <input type="button" class="button upload_image_button" id="upload_image_button" value="Upload Image" />
              <p class="image-category-description">For best results, please make sure to use images that are 342px width x 192px height, or alternatively keep a 16:9 ratio, preferably using .webp format.</p> 
              <input type="hidden" id="category_image" name="category_image" value="<?php echo esc_attr($image_id); ?>" />
              <div id="category_image_preview">
                  <?php if ($image_id) : ?>
                      <img src="<?php echo wp_get_attachment_url($image_id); ?>" style="max-width: 150px;" />
                  <?php endif; ?>
              </div>
          </td>
      </tr>
      <?php
  }

  // Guardar la imagen seleccionada en los metadatos de la categoría
  public function save_category_image($term_id) {
      if (isset($_POST['category_image']) && !empty($_POST['category_image'])) {
          update_term_meta($term_id, 'category_image', absint($_POST['category_image']));
      } else {
          delete_term_meta($term_id, 'category_image');
      }
  }
} 

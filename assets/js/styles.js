jQuery(document).ready(function($){
    var frame;

    // Habilitar Sortable para el reordenamiento
    $('#gallery_preview').sortable({
        update: function(event, ui) {
            updateGalleryInput();
        }
    });

    // Abrir el Media Uploader
    $('.upload_gallery_button').on('click', function(e) {
        e.preventDefault();
            
        // Si ya existe el frame, lo reutilizamos.
        if (frame) {
            frame.open();
            return;
        }
            
        // Crear el media frame
        frame = wp.media({
            title: 'Selecciona las imágenes para la galería',
            button: {
                text: 'Usar estas imágenes'
            },
            multiple: true // Seleccionar múltiples imágenes
        });
            
        // Cuando se seleccionen las imágenes
        frame.on('select', function() {
            var attachments = frame.state().get('selection').toJSON();
            var preview = $('#gallery_preview');
                
            // Recorremos los archivos seleccionados y añadimos al preview
            attachments.forEach(function(attachment) {
                var imageHTML = '<li data-id="' + attachment.id + '"><img src="' + attachment.sizes.thumbnail.url + '" /><button class="remove-image button">Eliminar</button></li>';
                preview.append(imageHTML);
            });
                
            // Actualizar el campo oculto
            updateGalleryInput();
        });
            
        // Abrir el frame
        frame.open();
    });

    // Funcionalidad para eliminar una imagen
    $('#gallery_preview').on('click', '.remove-image', function(e) {
        e.preventDefault();
        $(this).closest('li').remove(); // Elimina el elemento <li>
        updateGalleryInput(); // Actualiza el campo oculto
    });

    // Función para actualizar el campo oculto con los IDs de las imágenes
    function updateGalleryInput() {
        var image_ids = [];
        $('#gallery_preview li').each(function(){
            image_ids.push($(this).data('id')); // Recoge los IDs de las imágenes
        });
        $('#images').val(image_ids.join(',')); // Actualiza el campo oculto con los nuevos IDs
    }
});
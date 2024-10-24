jQuery(document).ready(function($) {
    var mediaUploader;

    // Evento de botón para abrir el Media Uploader
    $('.upload_image_button').click(function(e) {
        e.preventDefault();
        
        // Abrir la ventana del Media Uploader
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#category_image').val(attachment.id);
            $('#category_image_preview').html('<img src="' + attachment.url + '" style="max-width: 150px;" />');
        });

        mediaUploader.open();
    });
});

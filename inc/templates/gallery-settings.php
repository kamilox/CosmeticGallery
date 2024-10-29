<div class="wrap">
    <h1><?php echo __('Gallery Settings', 'Cosmetic Gallery') ?></h1>
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php
            settings_fields('gallery_settings_group'); // Grupo de ajustes
            do_settings_sections('gallery-settings');  // Sección de ajustes
            submit_button(); // Botón para guardar los cambios
        ?>
    </form>
</div>
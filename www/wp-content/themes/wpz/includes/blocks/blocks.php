<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

define('BLOCKS_PLUGIN', str_replace("\\", "/", get_template_directory()) . '/includes/blocks/');
define('BLOCKS_DIR', str_replace("\\", "/", get_template_directory()) . '/blocks/');
define('BLOCKS_URL', get_template_directory_uri() . '/blocks/');
define('BLOCKS_PLUGIN_URL', get_template_directory_uri() . '/includes/blocks/');

function blocks_warning() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p>WPZ Blocks requiert que les plugins <strong>ACF PRO</strong> et <strong>Timber</strong> soient installés.</p>
    </div>
    <?php
}

if (class_exists('ACF') && class_exists('Timber')) {
    require BLOCKS_PLUGIN . 'class/WPZ_Block_Post.php';
    require BLOCKS_PLUGIN . 'class/WPZ_Block.php';
    require BLOCKS_PLUGIN . 'class/WPZ_Blocks.php';
    require BLOCKS_PLUGIN . 'class/WPZ_Blocks_Admin.php';
    require BLOCKS_PLUGIN . 'class/WPZ_Block_Generator.php';
    require BLOCKS_PLUGIN . 'class/WPZ_Blocks_Modal.php';

    new WPZ_Blocks();
}
else {
    add_action('admin_notices', 'blocks_warning');
}

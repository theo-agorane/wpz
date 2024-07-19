<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

define('BLOCKS_VERSION', '1.0.0');
define('BLOCKS_PLUGIN', str_replace("\\", "/", get_template_directory()) . '/includes/blocks/');
define('BLOCKS_DIR', str_replace("\\", "/", get_template_directory()) . '/blocks/');
define('BLOCKS_URL', get_template_directory_uri() . '/blocks/');
define('BLOCKS_PLUGIN_URL', get_template_directory_uri() . '/includes/blocks/');

function blocks_warning() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p> Blocks requiert que les plugins <strong>ACF PRO</strong> et <strong>Timber</strong> soient installés.</p>
    </div>
    <?php
}

if (class_exists('ACF') && class_exists('Timber')) {
    require BLOCKS_PLUGIN . 'class/BlockPost.php';
    require BLOCKS_PLUGIN . 'class/Block.php';
    require BLOCKS_PLUGIN . 'class/Blocks.php';
    require BLOCKS_PLUGIN . 'class/BlocksAdmin.php';
    require BLOCKS_PLUGIN . 'class/BlockGenerator.php';
    require BLOCKS_PLUGIN . 'class/BlocksModal.php';

    new Blocks();
}
else {
    add_action('admin_notices', 'blocks_warning');
}

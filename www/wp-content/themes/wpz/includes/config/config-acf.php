<?php

/**
 * @filter acf/settings/load_json
 * @function wpz_acf_load_json
 */
add_filter('acf/settings/load_json', 'wpz_acf_load_json', 100);
function wpz_acf_load_json($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf';
    return $paths;
}

/**
 * @filter acf/settings/save_json
 * @function wpz_acf_save_json
 */
add_filter('acf/settings/save_json', 'wpz_acf_save_json', 100);
function wpz_acf_save_json($path) {
    if (!empty($_POST['acf_field_group']['key'])) {
        $key = $_POST['acf_field_group']['key'];

        if (strpos($key, 'group_block') === false and strpos($key, 'group_blocks') === false) {
            $path = get_stylesheet_directory() . '/acf';
        }
    }

    return $path;
}

/**
 * @filter acf/load_field
 * @function wpz_acf_populate_colors
 */
add_filter('acf/load_field', 'wpz_acf_populate_colors');
function wpz_acf_populate_colors($field) {
    if (get_current_screen() != null && get_current_screen()->id == 'acf-field-group') {
        if ($field['name'] == 'gallery_display') {
            $field['choices'] = [];

            for ($i=1; $i<=11; $i++) {
                $field['choices'][$i] = $i;
            }
        }
        return $field;
    }

    if (str_starts_with($field['name'], 'theme')) {
        $field['choices'] = [
            'white' => '<div class="acf-wpz-color" style="background: #FFFFFF; border: solid 1px #ebebeb;"></div> Blanc',
            'black' => '<div class="acf-wpz-color" style="background: #000000;"></div> Noir',
        ];
    }
    elseif ($field['name'] == 'gallery_display') {
        $field['choices'] = [];

        for ($i=1; $i<=11; $i++) {
            $field['choices'][$i] = '<div class="acf-wpz-gallery-display" style="background-image: url('.BLOCKS_URL.'/blocks/Gallery/displays/display_'.$i.'.svg)"></div>';
        }
    }

    return $field;
}

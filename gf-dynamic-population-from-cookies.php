<?php
/**
 * Plugin Name:     Dynamically Populate Gravity Form Fields From Cookies
 * Description:     Adds support for dynamically populating Gravity Form fields from cookies. Cache-friendly.
 * Author:          Ethan Clevenger
 * Author URI:      https://sternerstuff.dev
 * Text Domain:     gf-dynamic-population-from-cookies
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Gf_Dynamic_Population_From_Cookies
 */

/**
 * Big thanks to https://github.com/mmirus/gravity-forms-javascript-dynamic-population for logic to start with.
 */

// add data-prefill attribute to fields
add_filter('gform_field_content', function ($field_content, $field) {
    if (!$field->allowsPrepopulate) return $field_content;
    return str_replace('name=', "data-prefill='{$field->inputName}' name=", $field_content);
}, 10, 2);

// fill values from query params for fields where dynamic population is enabled
add_action('gform_register_init_scripts', function ($form) {
    $script = "
    function getCookie(name) {
        let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? match[2] : null;
    }

    const fields = [].slice.call(document.querySelectorAll('[data-prefill]'));
    fields.forEach(function(field) {
        const value = getCookie(field.dataset.prefill);
        if (value === null || value === '') return;

        const fieldType = (field.tagName === 'INPUT') ? field.type : field.tagName.toLowerCase();
        switch (fieldType) {
            case 'checkbox':
            case 'radio':
                // Radio/checkbox field support to come.
                // field.checked = (value.split(',').indexOf(field.value) !== -1);
                break;
            case 'select':
				const selected = value.split(',');
                Array.from(field.options).forEach(function (option) {
					// If the option's value is in the selected array, select it
					// Otherwise, deselect it
					option.selected = selected.includes(option.value);

				});
                break;
            default:
                field.value = value;
        }
    });
    ";

    GFFormDisplay::add_init_script($form['id'], 'populate_fields', GFFormDisplay::ON_PAGE_RENDER, $script);
}, 10);

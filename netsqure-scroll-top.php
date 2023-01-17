<?php
/**
 * Plugin Name: Simple Scroll to Top
 * Plugin URI: https://netsqure.com
 * Description: A simple plugin to add a scroll to top button to your website.
 * Version: 1.0
 * Author: Jahid A
 * Author URI: https://jahid.dev
 * License: GPL2
 */

// Add option to change the color of the button in the admin panel
add_action('admin_menu', 'scroll_top_menu');
function scroll_top_menu() {
    add_options_page('Scroll Top Options', 'Scroll Top', 'manage_options', 'scroll-top-options', 'scroll_top_options');
}

function scroll_top_options() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    echo '<div class="wrap">';
    echo '<h2>Scroll Top Options</h2>';
    echo '<form method="post" action="options.php">';
    settings_fields('scroll-top-options');
    do_settings_sections('scroll-top-options');
    echo '<table class="form-table">';

    echo '<tr valign="top">';
    echo '<th scope="row">Button Color</th>';
    echo '<td><input type="color" name="scroll_top_color" value="' . get_option('scroll_top_color') . '" /></td>';
    echo '</tr>';

    echo '<tr valign="top">';
    echo '<th scope="row">Button Background</th>';
    echo '<td><input type="color" name="scroll_top_color_bg" value="' . get_option('scroll_top_color_bg') . '" /></td>';
    echo '</tr>';

    // Position of the button
    echo '<tr valign="top">';
    echo '<th scope="row">Button Position</th>';
    echo '<td>
        <select name="scroll_top_position">
            <option value="bottom-right">Bottom Right</option>
            <option value="bottom-left">Bottom Left</option>
            <option value="top-right">Top Right</option>
            <option value="top-left">Top Left</option>
        </select>
    </td>';
    echo '</tr>';

    echo '</table>';
    submit_button();
    echo '</form>';
    echo '</div>';
}

add_action('admin_init', 'scroll_top_settings');

function scroll_top_settings() {
    register_setting('scroll-top-options', 'scroll_top_color');
    register_setting('scroll-top-options', 'scroll_top_color_bg');
    register_setting('scroll-top-options', 'scroll_top_position');
}

// Add the button to the footer
add_action('wp_footer', 'scroll_top_button');

function scroll_top_button() {
    $color = get_option('scroll_top_color');
    $colorBg = get_option('scroll_top_color_bg');
    $position = get_option('scroll_top_position');

    if (empty($color)) {
        $color = '#000';
    }
    if (empty($colorBg)) {
        $colorBg = '#fff';
    }

    if (empty($position)) {
        $position = 'bottom-right';
    }

    switch ($position) {
        case 'bottom-right':
            $position = 'bottom: 20px; right: 20px;';
            break;
        case 'bottom-left':
            $position = 'bottom: 20px; left: 20px;';
            break;
        case 'top-right':
            $position = 'top: 20px; right: 20px;';
            break;
        case 'top-left':
            $position = 'top: 20px; left: 20px;';
            break;
    }

    echo '<style>
    .netsqure-scroll-top {
        position: fixed;
        ' . $position . '
        width: 40px;
        height: 40px;
        background: ' . $colorBg . ';
        border-radius: 50%;
        text-align: center;
        line-height: 50px;
        color: ' . $color . ';
        font-size: 30px;
        cursor: pointer;
        z-index: 9999;
        display: grid;
        place-content: center;
        border: 0;
        outline: 0;
        transition: all 0.3s ease;
        display: none;
        padding: 0;
        margin: 0;
    }
    .netsqure-scroll-top.show {
        display: grid;
    }
    </style>';
    echo '<button class="netsqure-scroll-top">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20px" height="20px">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19.5v-15m0 0l-6.75 6.75M12 4.5l6.75 6.75" />
        </svg>  
    </button>';
}

add_action('wp_enqueue_scripts', 'scroll_top_script');
function scroll_top_script() {
    wp_enqueue_script('netsqure-scroll-top', plugins_url('assets/js/netsqure-scroll-top.js', __FILE__), array(), '1.0', true);
}


?>
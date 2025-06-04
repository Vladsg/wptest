<?php
function _scripts_and_styles()
{
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(),
        filemtime(get_template_directory() . '/style.css'));
    wp_enqueue_script('scripts', get_template_directory_uri() . '/scripts.js', array(),
        filemtime(get_template_directory() . '/scripts.js'));
}

add_action('wp_enqueue_scripts', '_scripts_and_styles');
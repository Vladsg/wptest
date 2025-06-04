<?php

add_action('after_switch_theme', 'theme_activation');
function theme_activation()
{
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta("CREATE TABLE {$wpdb->prefix}contacts_form_data (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `message` varchar(500) NOT NULL,
             `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
            PRIMARY KEY  (id)
          ) ENGINE=InnoDB");
    $post = wp_insert_post([
        'post_title' => 'Главная страница',
        'post_type' => 'page',
        'post_status' => 'publish',
    ]);
    update_option('show_on_front', 'page');
    update_option('page_on_front', $post);
    $json = file_get_contents(get_template_directory() . '/acf-json/group_683f53ee87a25.json');
    $json = json_decode($json, true);
    $json['location'] = [
        [
            [
                'param' => 'page',
                'operator' => '==',
                'value' => (string)$post,
            ]
        ]
    ];
    file_put_contents(get_template_directory() . '/acf-json/group_683f53ee87a25.json', json_encode($json));
}

require_once 'includes/scripts-styles.php';
require_once 'includes/post-types.php';
require_once 'includes/shortcodes.php';
require_once 'includes/ajax.php';
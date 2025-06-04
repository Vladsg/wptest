<?php
add_action( 'init', 'my_posttypes', 0 );
function my_posttypes() {

    register_post_type( 'messages',
        array(
            'labels' => array(
                'name' => 'Сообщения',
                'singular_name' =>'Сообщение',
                'add_new' =>'Добавить новое',
                'add_new_item' => 'Добавить сообщение'
            ),
            'public' => true,
            'menu_position' => 20,
            'supports' => array( 'title', 'editor', 'custom-fields', 'revisions', 'page-attributes' ),
            'hierarchical' => true,
            'has_archive' => false,
            'capability_type' => 'page',
            'exclude_from_search' => true,
        )
    );
}
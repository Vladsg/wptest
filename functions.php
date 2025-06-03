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

//add_filter('acf/settings/save_json', 'acf_json_save_point');

function acf_json_save_point($path)
{
    // update path
    $path = get_template_directory() . '/acf-json';

    // return
    return $path;
}

function _scripts_and_styles()
{
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(),
        filemtime(get_template_directory() . '/style.css'));
    wp_enqueue_script('scripts', get_template_directory_uri() . '/scripts.js', array(),
        filemtime(get_template_directory() . '/scripts.js'));
}

add_action('wp_enqueue_scripts', '_scripts_and_styles');

add_shortcode('latest-news', 'latestNews');

function latestNews()
{
    $paged = 1;
    if (defined('DOING_AJAX') && DOING_AJAX) {
        ob_start();
        $paged = $_POST['paged'] ?? 1;
    }
    ?>
    <section class='posts'>
        <h2 class='posts__title'>
            Latest News
        </h2>
        <div class='posts__list'>
            <?php
            $args = [
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 5,
                'paged' => $paged,
            ];
            $posts = new WP_Query($args);

            if ($posts->have_posts()) {
                while ($posts->have_posts()) {
                    $posts->the_post();
                    require get_template_directory() . '/templates/post.php';
                }
            }
            ?>
        </div>
        <?php
        wp_reset_postdata();
        if ($posts->max_num_pages > 1):
            ?>
            <div class="posts__pagination">
                <?php
                echo paginate_links([
                    'current' => $paged,
                    'total' => $posts->max_num_pages,
                    'prev_next' => false,
                ]);
                ?>
            </div>
        <?php
        endif;
        ?>
    </section>
    <?php
    if (defined('DOING_AJAX') && DOING_AJAX) {
        die(json_encode(['status' => 'success', 'data' => ob_get_clean()]));
    }
}

add_action('wp_ajax_latestNews', 'latestNews');
add_action('wp_ajax_nopriv_latestNews', 'latestNews');
add_action('wp_ajax_formSend', 'formSend', 10, 1);
add_action('wp_ajax_nopriv_formSend', 'formSend', 10, 1);
function formSend()
{
    $fields = get_fields(20);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    if (empty($email) || !is_email($email)) {
        die(json_encode(['status' => 'error', 'message' => 'Email некорректен!']));
    }
    if (empty($message)) {
        die(json_encode(['status' => 'error', 'message' => 'Вы не ввели сообщение!']));
    }
    global $wpdb;
    $insert = $wpdb->insert($wpdb->prefix . 'contacts_form_data',
        ['name' => $name, 'email' => $email, 'message' => $message]);
    $headers = 'From: ' . $_SERVER['HTTP_HOST'] . ' <no-reply@' . $_SERVER['HTTP_HOST'] . '>' . "\r\n"; // Раскомментировать после переноса на домен
    $send = wp_mail($fields['contacts_email'], '', $message, $headers);
    if (!$send) {
        die(json_encode(['status' => 'error', 'message' => 'Сообщение не было отправлено!']));
    }
    die(json_encode(['status' => 'success']));
}
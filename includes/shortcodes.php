<?php
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


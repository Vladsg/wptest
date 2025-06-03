<div class='post__card'>
    <div class='post__date'><?= get_post_datetime()->format('d:m:Y'); ?></div>
    <h3 class="post__title"><?php
        the_title(); ?></h3>
    <?php
    the_excerpt();
    ?>
    <a href="<?php
    the_permalink(); ?>">Read more</a>
</div>
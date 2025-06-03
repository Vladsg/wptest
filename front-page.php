<?php
get_header();
$fields = get_fields();
?>
<main>
<h2 class="page__title">
    Headline
</h2>
    <p class="page__desc">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis dignissimos id molestiae odio vitae! Ad et molestiae quidem tempora ut.
    </p>
    <div class="page__content">
        <h2>
            <?=$fields['section_title'];?>
        </h2>
            <?=$fields['section_text'];?>

    </div>
    <?php
    do_shortcode('[latest-news]')
    ?>

</main>
<?php
get_footer();
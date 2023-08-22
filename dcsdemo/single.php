<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package codecrewz_DCS
 */
get_header();
?>

<main id="primary" class="site-main">

    <?php
    while (have_posts()) :
        the_post();

        get_template_part('template-parts/content', get_post_type());

        the_post_navigation(
            array(
                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'codecrewz_DCS') . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'codecrewz_DCS') . '</span> <span class="nav-title">%title</span>',
            )
        );

    endwhile; // End of the loop.
    ?>

</main><!-- #main -->

<?php
// get_sidebar();
get_footer();

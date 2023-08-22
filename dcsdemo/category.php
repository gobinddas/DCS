<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package codecrewz_DCS
 */
get_header();
$work_bg_img = get_theme_mod('work_bg_img');

?>
<main id="primary" class="page-services">

    <div class="page page-service section" style="background-image:url(<?= $work_bg_img; ?>)">
        <div class="container">
            <?php
            $category = get_queried_object();
            $thumbnail_id = get_option('taxonomy_image_plugin');
            global $cat_id;
            $cat_id = get_query_var('cat');
            global $category;
            $category = get_category($cat_id);
            if (!$category->parent) {
                include get_template_directory() . '/pages/services.php';
            } else {
            ?>




            <div class="service-wrapper">

                <div class="service-image">
                    <?php if (isset($thumbnail_id[$category->term_id])) { ?>
                    <figure class='figure'>
                        <img src="<?= $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id[$category->term_id], 'full') : 'https://via.placeholder.com/340X232/000/fff?text=' . $category->name ?>"
                            alt="<?= $category->name ?>">
                    </figure>
                    <?php } ?>
                </div>
                <div class="service-content">
                    <h6 class="sub-heading"><span><?= $category->name ?></span></h6>

                    <p> <?= $category->description ?> </p>
                </div>
            </div>

            <?php
            }
            ?>
        </div>
    </div>
    <?php include get_template_directory() . '/includes/gallery.php'; ?>
</main><!-- #main -->

<?php
get_footer();
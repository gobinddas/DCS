<?php

/**
 * Template Name: Common Page
 *
 * The template for displaying all pages
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package codecrewz_DCS
 */
get_header();
?>
<?php
while (have_posts()) :
    the_post();
    $imageUrl = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>
    <!--Breadcrumb-->
    <div class="breadcrumb-wrapper" style="background: url(<?php echo $imageUrl; ?>) no-repeat center /cover;">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo get_home_url(); ?>">Home</a>
                </li>

                <li class="active"><?php the_title(); ?></li>
            </ol>
        </div>
    </div>
<?php endwhile; // End of the loop.
?>

<div class="code-page page-services inner_service">

    <div class="code-page page-about">
        <section class="section about">
            <div class="container">
                <div class="about-block">
                    <div class="row">

                        <div class="col-sm-12">
                            <?php the_content(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <?php include_once('section-parts/why.php'); ?>
    <?php include('section-parts/testimonials.php'); ?>
</div>


<?php get_footer(); ?>
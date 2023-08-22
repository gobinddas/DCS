<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package codecrewz_DCS
 */
?>
<!doctype html>
<html <?php language_attributes() ?>>

<?php
$meta_keywords = get_theme_mod('meta_keywords', '');
$meta_description = get_theme_mod('meta_description', '');
?>

<?php

global $image_url;
if ($logo) {
    $image = wp_get_attachment_image_src($logo, 'full');
    $image_url = $image[0];
}

$phone = get_theme_mod('phone', "");
$email = get_theme_mod('email', "");


?>

<head>
    <meta charset="<?= bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name="keywords" content="<?= join(',', array_slice(explode("\n", $meta_keywords), 0, 10)) ?>">
    <?php wp_head() ?>
</head>

<body <?php body_class() ?>>
    <?php wp_body_open() ?>

    <header class="header">
        <div class="header-top">
            <div class="container">
                <div class="top-profile">
                    <div class="greet">
                        <h5>Welcome to DCS Funding Partners</h5>
                    </div>
                    <div class="details">
                        <h6 class="email"><i class="fa-solid fa-envelope"></i><?= $email ?></h6>
                        <h6><i class="fa-solid fa-phone"></i><?= $phone ?></h6>
                    </div>
                    <div class="social-icons">
                        <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    </div>

                </div>

            </div>

        </div>
        <div class="header-bottom">
            <div class="container">
                <nav class="navbar navbar-expand-lg ">
                    <a class="navbar-brand" href="./">DCS<span>.</span> </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i class="fas fa-grip-lines"></i></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <?php bootstrap_nav('Main', 'navbar-nav  nav-item nav-link') ?>

                    </div>
                    <div class="btn">
                        <a href="">Call Now</a>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <?php
    the_breadcrumb()
    ?>
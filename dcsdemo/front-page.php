<?php

/**
 *
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package codecrewz_DCS
 */

$thank = isset($_GET['message']);
get_header();

$phone = get_theme_mod('phone', "");
$email = get_theme_mod('email', "");


?>
<main class='home_page'>
    <h1 class='d-none'>
        <?= get_bloginfo('title') ?></h1>
    <?php include 'includes/banner.php'; ?>
    <?php include 'includes/aboutus.php'; ?>
    <?php include 'includes/services.php'; ?>
    <?php include 'includes/requirement.php'; ?>
    <?php include 'includes/testimonials.php'; ?>

    <?php include 'includes/whyus.php'; ?>
    <?php include 'includes/firststep.php'; ?>

    <?php
    if ($thank) {
    ?>
    <div id="thanks" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thank You</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>The form has been submitted successfully.</p>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href='<?= get_home_url() ?>'>Return to home</a>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    jQuery(window).on('load', function() {
        jQuery('#thanks').modal('show');
    });
    </script>
</main>
<?php
    }
    get_footer();
<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package codecrewz_DCS
 */



$co = get_bloginfo('title', "SA Diamond Construction");
$phone = get_theme_mod('phone', "0415 810 573");
$phone1 = get_theme_mod('phone1', "0438 825 900");
$email = get_theme_mod('email', "info@DCScon.com.au");
$address = get_theme_mod('address', "Adeliade SA");
$abn = get_theme_mod('abn', "");
$map = get_theme_mod('map', "");
$owner = get_theme_mod('owner', "");

global $image_url;
$contacts = [
    'phone' => [
        'value' => $phone,
        'icon' => '<i class="fas fa-phone-alt"></i>',
        'type' => 'tel:',
    ],
    'email' => [
        'value' => $email,
        'icon' => '<i class="fas fa-envelope"></i>',
        'type' => 'emailto:',
    ],
    'address' => [
        'value' => $address,
        'icon' => '<i class="fas fa-map-marker-alt"></i>',
        'type' => 'https://www.google.com/maps/place/',
    ],
    'abn' => [
        'value' => $abn,
        'icon' => 'ABN : ',
        'type' => 'https://abr.business.gov.au/ABN/View?id=',
    ],
];

$social = [
    'facebook' => get_theme_mod('facebook'),
    'instagram' => get_theme_mod('instagram'),
    'twitter' => get_theme_mod('twitter'),
    'youtube' => get_theme_mod('youtube'),
];

$service_locations = get_theme_mod('service_locations', false);

?>

<footer class="section">
    <div class="container">

        <div class="footer-top ">
            <div class="brand-des ">
                <a class="navbar-brand" href="./">DCS<span>.</span> </a>
                <p class="des">We are here to provide the funding solutions you need to fuel your growth and reach your
                    goals.</p>
                <h3 class="number"><?= $phone ?></h3>
                <h5 class="email"><?= $email ?></h5>
            </div>


            <div class="footer-item">
                <h3 class="item-heading">Navigation</h3>
                <?php bootstrap_nav('Main', 'navbar-nav  nav-item nav-link') ?>

            </div>
            <div class="footer-item">
                <h3 class="item-heading">Our Load Options</h3>
                <ul class="list-item">
                    <li class="item"> <a href="">MCA Loans</a></li>
                    <li class="item"> <a href="">Card Money</a></li>
                    <li class="item"> <a href="">Lines of Credit</a></li>
                    <li class="item"> <a href="">SBA Loans</a></li>
                    <li class="item"> <a href="">Bridge Loans</a></li>
                </ul>
            </div>
            <div class="footer-item last-item">
                <h3 class="item-heading">Subscribe newsletter</h3>
                <ul class="list-item">
                    <li class="item"> <a href="">Subscribe our newsletter to get updates about our services and
                            offers.</a></li>

                </ul>

                <div class="emailsection">
                    <input type="email" name="" id="" placeholder="Email Address">
                    <a href="" class="blue-sm-btn">Submit</a>
                </div>
            </div>
        </div>

    </div>
</footer>
<div class="footer-bottom">
    <div class="container">
        <div class="footer-double">
            <p class="copyright">© 2023 All Right Reserved. DCS Funding Partners. Designed by <a href="">Uptech
                    Solutions</a></p>
            <div class="icons">
                <div class="item"><i class="fa-brands fa-facebook-f"></i></div>
                <div class="item"><i class="fa-brands fa-instagram"></i></div>
                <div class="item"><i class="fa-brands fa-twitter"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-call-button">
    <a href="tel:<?php echo $phone; ?>"><i class="fa-solid fa-phone fa-shake"></i></a>
</div>

<div class="scrollevent"><a class="scrollToTop" href="#">
        <button class="btn btn-scroll-up"><i class="fa fa-chevron-up"></i></button></a>
</div>

<?php wp_footer(); ?>
</body>

</html>
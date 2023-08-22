<?php
$category = get_queried_object();
$categories = get_categories(array(
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => 0,
    'parent' => get_category_by_slug('services')->term_id,

));
$count = 0;
?>

<div class="services section">
    <div class="container">
        <div class="section-header">
            <h4 class="large-info-content">Our loan products</h4>
            <p class="small-info-content">Turn Your Business Dreams into Reality with Simple Requirements</p>
        </div>
        <div class="loan-product-collection">
            <?php
            foreach ($categories as $sub_category) {
                $thumbnail_id = get_option('taxonomy_image_plugin')[$sub_category->term_id];
            ?>

            <div class="product">
                <div class="lottie-animation"></div>
                <div class="product-name">
                    <h5 class="name"><?= $sub_category->name ?></h5>
                </div>
                <div class="product-description">
                    <p><?= $sub_category->description ?></p>
                </div>
                <div class="blue-btn">
                    <a href="">Apply Now</a>
                </div>


            </div>
            <?php }
            wp_reset_query(); ?>

        </div>
    </div>
</div>
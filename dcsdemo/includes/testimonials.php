<div class="testimonial section">
    <div class="container">
        <div class="section-header">
            <h4 class="large-info-content">Our Reviews</h4>
            <p class="small-info-content">Some reviews from business owners</p>
        </div>
        <div class="review-collection">

            <?php
            $args = array(
                'post_type' => 'testimonials',
                'posts_per_page' => 6,
                'order_type' => 'Date',
                'Order' => 'ASC',
            );
            $the_query = new WP_Query($args);
            ?>
            <?php if ($the_query->have_posts()) : ?>
            <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <?php
                    $customer_address = get_field('customer_address');
                    $customer_name = get_field('customer_name');
                    ?>

            <div class="review-item">
                <div class="profile-img">
                    <?php the_post_thumbnail() ?>
                </div>
                <div class="rating">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half"></i>
                </div>
                <p class="message"><?php the_title() ?></p>
                <h3 class="messanger-name"><?php the_excerpt() ?></h3>
                <h6 class="messanger-position">Managing Director</h6>
            </div>
            <?php endwhile;
                wp_reset_postdata(); ?>
            <?php else : ?>
            <p>
                <? php_e('Sorry, no posts matched your criteria.'); ?>
            </p>
            <?php endif; ?>

        </div>
    </div>
</div>
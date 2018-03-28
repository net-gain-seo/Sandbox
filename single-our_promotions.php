<?php
//Our Promotions
    get_header();
?>
<?php
    $postId = get_the_post_id();
    $primaryTitle = get_post_meta( $postId, 'mast_page_title', true );
    $sectionTitle = get_post_meta( $postId, 'mast_section_title', true );
?>
<div id="featured-image"><img width="100%" src="<?php echo esc_url( home_url( '/' ) ); ?>/wp-content/uploads/2017/12/WaterFrontBanner.png" ></div>
<div class="post_title"><h1><?php the_title(); ?></h1></div>

<div class="container our-promotions">
    <div class="row paddingtop0">
        <div class="col col-12 col-lg-12">
            <?php while ( have_posts() ) : the_post(); ?>

                <article>
                    <div class="blog-article">
                        <?php the_content(); ?>
                    </div>
                </article>

            <?php endwhile; // End of the loop. ?>

            <div class="next-prev">
                <div class="prev"><?php previous_post_link('%link', '<img src="https://www.chapmanmcalpine.com/wp-content/uploads/2018/01/left-arrow.jpg" class="dirarrow"> <span>Previous Post</span>', FALSE); ?></div>
                <div class="next"><?php next_post_link('%link', '<span>Next Post</span> <img src="https://www.chapmanmcalpine.com/wp-content/uploads/2018/01/right-arrow.jpg" class="dirarrow">', FALSE); ?></div>
            </div>
        </div>
    </div>

</div>
<?php echo do_shortcode( '[container background_color="#102C3F" fluid="true" class="border-tb" inner_class="container"]

[row]

[col size="lg-12"]
<h3 class="whiteText margin0">SCHEDULE A LEGAL CONSULTATION</h3>
<hr class="whitebar margin0"/>
[/col]

[/row]

[row class="paddingtop0"]

[contact-form-7 id="149" title="Home Contact"]

[/row]

[/container]

[container ]' ); ?>
<?php
    get_footer();

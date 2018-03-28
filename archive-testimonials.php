<?php
//testimonials
    get_header();
?>

    <div id="featured-image">
        <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/12/TestimonialBanner.jpg" />
    </div>
    <div class="container padding60">
      <div class="row padding20">
        <div class="col-lg-12 col-md-12 introtitle">
          <h1 class="text-align-center">Testimonials</h1>
          <h2 class="text-align-center"><em>What are our clients are saying</em></h2>
        </div>
      </div>
      <article>
        <?php
        while ( have_posts() ) : the_post(); ?>

          <div class="the-testimonial">
            <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/12/Quote.png" class="largequote" />
            <?php the_content(); ?>
            <div class="author">
              <span><?php the_title(); ?></span>
          </div>
        </div>
        <?php endwhile; // End of the loop. ?>

      </article>
      <div class="blogpagination">
        <?php
        global $wp_query;
        echo paginate_links( array(
          'base' => str_replace( 9999999, '%#%', esc_url( get_pagenum_link( 9999999 ) ) ),
          'format' => 'page/%#%/',
          'current' => max( 1, get_query_var('paged') ),
          'total' => $wp_query->max_num_pages,
          'prev_text'          => __('<'),
          'next_text'          => __('>'),
          'add_args'           => false
        ) );
        ?>
      </div>
    </div>
    <?php echo do_shortcode( '[container background_color="#102C3F" class="border-tb" fluid="true" inner_class="container"]

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

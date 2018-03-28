<?php
    // BLOG HOME
    get_header();
?>
<div id="featured-image"><img width="100%" src="<?php echo esc_url( home_url( '/' ) ); ?>/wp-content/uploads/2017/12/SunnyDayBanner.jpg" ></div>
<div class="post_title"><div><h1>Blog</h1></div></div>

<div class="container">
    <div class="row blog-content">
        <div class="col col-12 col-lg-8">

            <div class="blog-listing">
            <?php while ( have_posts() ) : the_post(); ?>
                <article>

                    <h2 class="post-title">
                        <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <?php echo '<div class="date py-1">';
                        echo '<span>'.get_the_time('F').' </span>';
                        echo '<span>'.get_the_time('d').', </span>';
                        echo '<span>'.get_the_time('Y').'</span>';
                        echo '</div>';
                      ?>
                      <hr class="dotted"/>

                    <?php the_excerpt(); ?> <a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">[Read more]</a>

                <hr class="bluebar"/>
                </article>
            <?php endwhile; // End of the loop. ?>
            </div>
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

        <div class="col col-12 col-lg-4">

            <div class="blog-sidebar">
                <?php dynamic_sidebar( 'blog_sidebar' ); ?>
            </div>

        </div>
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

<?php
/*
  * Template Name: Page No Title
  */
?>
<?php get_header(); ?>
<?php
if(has_post_thumbnail()) {
  echo '<div id="featured-image">'.get_the_post_thumbnail().'</div>';
}
?>

<div id="fullWidth">
<?php
while ( have_posts() ) : the_post();
    the_content();
endwhile;
?>
</div>
<?php get_footer(); ?>

<?php
/*
  * Template Name: Full Width
  */
?>
<?php get_header(); ?>
<div id="fullWidth">
<?php
while ( have_posts() ) : the_post();
    the_content();
endwhile;
?>
</div>
<?php get_footer(); ?>

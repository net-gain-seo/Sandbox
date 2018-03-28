<?php
/*
  * Template Name: Our Team
  */
?>
<?php get_header(); ?>
<div id="fullWidth">
<div class="container-fluid overflowhide ourteampage"><div class="container">
<div class="row padding0">
<div class="col col-lg-6 col-md-12 col-sm-12 col-xsm-12 alignsection">
<?php
while ( have_posts() ) : the_post();
    the_content();
endwhile;
?>
</div>
<div class="col col-lg-6 col-md-12 col-sm-12 col-xsm-12 teamimage">
  <div class="imageoverflow">
<?php
if(has_post_thumbnail()) {
  echo get_the_post_thumbnail();
}
?>
</div>
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
</div>
<?php get_footer(); ?>

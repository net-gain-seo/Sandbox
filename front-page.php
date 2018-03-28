<?php
    get_header();
    // $postId = get_the_post_id();
?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="mainbanner">
  <img src="<?php echo home_url(); ?>/wp-content/uploads/2018/01/SandBoxMainBanner.jpg" width="100%"/>
  <div class="whitefade">
    <h1>A HUB for ALL Entrepreneurs, Intrapreneurs
    and Innovators in Simcoe County!</h1>
  </div>
</div>
<div class="container bluesection">
  <div class="row padding0">
    <div class="bluebackground"></div>
      <h2>The Sandbox is unique to our amazing local economy, is open to all businesses
          and Entrepreneurs and promises to be bringing significant social and economic
          benefits both locally and regionally.</h2>
  </div>
</div>
<div class="page-content front-page-content">
    <?php the_content(); ?>
</div>

<?php endwhile; // End of the loop. ?>

<?php
    get_footer();

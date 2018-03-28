<?php

/**
 * SHORTCODES
 *
 */

// Remove empty paragraphs from beginning and end of [shortcode][/shortcode]
function noParagraphs($content){
    if ( '</p>' == substr( $content, 0, 4 ) && '<p>' == substr( $content, strlen( $content ) - 3 ) ){
        $content = substr( $content, 4, strlen( $content ) - 7 );
    }
    return $content;
}

function stripAllParagraphs($content) {
    return str_ireplace( array('<p>', '</p>'), '', $content );
}


function testimonials_wp_enqueue_scripts(){
    wp_register_style( 'slick-style', get_template_directory_uri().'/admin/post_types/slider/css/slick.css');
    wp_register_script( 'slick-script', get_template_directory_uri().'/admin/post_types/slider/js/slick.min.js',array('jquery'));
    wp_register_script( 'slick-slider', get_template_directory_uri().'/admin/post_types/slider/js/slick-slider.js',array('slick-script'));
}
add_action( 'wp_enqueue_scripts', 'testimonials_wp_enqueue_scripts' );


function carousel_slider($atts) {
    wp_enqueue_style( 'slick-style');
    wp_enqueue_script( 'slick-script');
    wp_enqueue_script( 'slick-slider');

    extract( shortcode_atts( array(
        'class' => ''
      ), $atts ) );
    // WP_Query arguments
    $args = array(
        'post_type'   => array( 'carousel' ),
        'posts_per_page' => -1,
        'orderby' => 'publish_date',
        'order' => 'ASC'
    );
    // The Query
    $query = new WP_Query( $args );

    $to = '';
    $to .= '<div class="carousel-wrap">';

    if($query->have_posts()) {
        while($query->have_posts()):$query->the_post();
            $to .= '<div class="carousel-slide">';
            $to .= '<div class="carousel-content">';
                $to .= wpautop(get_the_content());
                $to .= '<p class="carousel-title">'.get_the_title().'</p>';
              $to .= '</div>';
            $to .= '</div>';
        endwhile;
    }

    $to .= '</div>';
    return $to;
}
add_shortcode('carousel','carousel_slider');







function nga_accordion($atts,$content) {
    extract( shortcode_atts( array(
        'title' => '',
        'toggleicons' => '' //2 Font awesome classes, comma delimited, omitting the fa- (e.g: plus,minus) closedclass,openclass
    ), $atts ) );
    $content = do_shortcode( shortcode_unautop( $content ) );
    $content = noParagraphs( $content );
    $ao = '';
    $ao .= '<div class="accordion-item">';
    $icons = '';
    if( isset($toggleicons) && $toggleicons != '' ) {
        $toggleicons = explode(',',$toggleicons);
        $icons = '<i class="fa fa-'.$toggleicons[0].'" data-open="'.$toggleicons[1].'" data-closed="'.$toggleicons[0].'"></i> ';
    }
        $ao .= '<h3 class="accordion-title">'.$icons.$title.'</h3>';
        $ao .= '<div class="accordion-content">';
            $ao .= $content;
        $ao .= '</div>';
    $ao .= '</div>';
    return $ao;
}
add_shortcode('accordion_item','nga_accordion');




function nga_latestpost($atts,$content) {
  extract( shortcode_atts( array(
      'content' => '',
      'class' => ''
    ), $atts ) );
  $args = array(

      'posts_per_page' => 1
  );
  // The Query
  $query = new WP_Query( $args );

    $lp = '';

    $lp .= '<div class="container-fluid splitpage"><div class="container">';
    $lp .= '<div class="row padding0">';
    $lp .= '<div class="col col-lg-6 col-sm-12 col-xsm-12 greyhalf">';
    $lp .= '<h2 class="whiteText">Latest Post</h2>';
    if($query->have_posts()) {
        while($query->have_posts()):$query->the_post();
        $lp .= '<article class="latestposts">';
        $lp .= '<h5 class="posttitle"><a title="'.get_the_title().'"  class="whiteText" href="'.get_permalink().'">'.get_the_title().'</a></h5>';
        $lp .= '<p class="whiteText">'.get_the_excerpt().'</p>';
        $lp .= '<a title="'.get_the_title().'" href="'.get_permalink().'" class="buttonlight">Read more</a>';
        $lp .= '</article>';
        endwhile;
    }
    $lp .= '</div>';
    $lp .= '<div class="col col-lg-6 col-sm-12 col-xsm-12 redhalf whiteText">';
    $lp .= '<h2 class="whiteText">Did You Know?</h2>';
    $lp .= '<p class="whiteText">'.$content.'</p>';
    $lp .= '<a href="https://docuvaultdv.com/services/electronic-data-destruction/" class="button">Learn more about electronic data destruction </a>';
    $lp .= '</div>';
    $lp .= '</div>';
    $lp .= '</div></div>';
    return $lp;
}
add_shortcode('latest_post','nga_latestpost');





function nga_ourpromotions($atts,$content) {
  extract( shortcode_atts( array(
      'class' => ''
    ), $atts ) );
  $args = array(
      'post_type'   => array( 'our_promotions' ),
      'posts_per_page' => -1
  );
  // The Query
  $query = new WP_Query( $args );

    $cj = '';
    if($query->have_posts()) {
      $cj .= '<div class="container-fluid ourpromotions"><div class="container">';
      $cj .= '<div class="row">';
      $cj .= '<div class="col col-lg-12 col-sm-12 col-xsm-12">';
        while($query->have_posts()):$query->the_post();
        $cj .= '<article class="ourpromotions">';
        $cj .= '<h5 class="post-title"><a title="'.get_the_title().'" href="'.get_permalink().'">'.get_the_title().'</a></h5>';
        $cj .= '<div class="date py-1">';
        $cj .= '<span>'.get_the_time('F').' </span>';
        $cj .= '<span>'.get_the_time('d').', </span>';
        $cj .= '<span>'.get_the_time('Y').'</span>';
        $cj .= '</div>';
        $cj .= '<hr class="dotted"/>';
        $cj .= '<p>'.get_the_excerpt().'</p>';
        $cj .= '</article>';
        endwhile;
        $cj .= '</div>';
        $cj .= '</div>';
        $cj .= '</div></div>';
    }else{
      $cj .= '<div class="container-fluid ourpromotions"><div class="container">';
      $cj .= '<div class="row">';
      $cj .= '<div class="col col-lg-12 col-sm-12 col-xsm-12">';
      $cj .= '<h3>Our Promotions</h3>';
      $cj .= '<p>There are no Promotions at this time. We’ll post new Promotions as they become available. </p>';
      $cj .= '</div>';
      $cj .= '</div>';
      $cj .= '</div></div>';
    }

    return $cj;
}
add_shortcode('our_promotions','nga_ourpromotions');












function nga_services($atts,$content) {
  extract( shortcode_atts( array(
      'content' => '',
      'class' => ''
    ), $atts ) );
  $args = array(
  );
  // The Query
  $query = new WP_Query( $args );

    $lp = '';

    $lp .= '<div class="container-fluid servicesection dropshadow"><div class="container">';
    $lp .= '<div class="row">';
    $lp .= '<div class="col col-lg-12 col-sm-12 col-xsm-12">';
    $lp .= '<h2 class="text-align-center whiteText">Our Services</h2>';
    $lp .= '</div>';
    $lp .= '</div>';
    $lp .= '<div class="row firstrow d-flex justify-content-between padding0">';
    $lp .= '<div class="col col-lg-4 col-md-12 col-sm-12 col-xsm-12 whiteText">';
    $lp .= '<img src="https://209.126.119.193/~chapmanmcalpine/wp-content/uploads/2017/12/ChildCustodyAccess.png"/>
            <h6>Child Custody & Access</h6>
            <p>“Custody” refers to certain decision-making regarding children, while “access” refers to each parent’s physical time with the children.</p>
            <a href="#" class="button">LEARN MORE</a>
            <div class="border-right"><div></div></div>';
    $lp .= '</div>';

    $lp .= '<div class="col col-lg-4 col-md-12 col-sm-12 col-xsm-12 whiteText">';
    $lp .= '<img src="https://209.126.119.193/~chapmanmcalpine/wp-content/uploads/2017/12/ChildSupportSpousalSupport.png"/>
            <h6>Child Support & Spousal Support</h6>
            <p>Child support refers to the amount payable by one parent to the other for the support of a child, while spousal support refers to the amount payable from one spouse to the other for the support of the recipient spouse.  </p>
            <a href="#" class="button">LEARN MORE</a>
            <div class="border-right"><div></div></div>
            <div class="border-left"><div></div></div>';
    $lp .= '</div>';
    $lp .= '<div class="col col-lg-4 col-md-12 col-sm-12 col-xsm-12 whiteText">';
    $lp .= '<img src="https://209.126.119.193/~chapmanmcalpine/wp-content/uploads/2017/12/Matrimonial-Home.png"/>
            <h6>Matrimonial Home</h6>
            <p>The matrimonial home is given special treatment in the area of family law.  A matrimonial home is the property that two married spouses lived in which, at the time of separation, a spouse had an interest in and was ordinarily occupied by the spouses as their family residence.</p>
            <a href="#" class="button">LEARN MORE</a>
            <div class="border-left"><div></div></div>';
    $lp .= '</div>';
    $lp .= '</div>';
    $lp .= '<div class="row secondrow d-flex justify-content-between padding0">';
    $lp .= '<div class="col col-lg-4 col-md-12 col-sm-12 col-xsm-12 whiteText">';
    $lp .= '<img src="https://209.126.119.193/~chapmanmcalpine/wp-content/uploads/2017/12/SeparationAgreementsParentingAgreements.png"/>
            <h6>Separation Agreements & Parenting Agreements</h6>
            <p>Our lawyers are experienced in negotiating and drafting legal Separation and Parenting Agreements for our clients dealing with all issues in a family law case.  </p>
            <a href="#" class="button">LEARN MORE</a>
            <div class="border-right"><div></div></div>
            <div class="border-top"><div></div></div>';
    $lp .= '</div>';

    $lp .= '<div class="col col-lg-4 col-md-12 col-sm-12 col-xsm-12 whiteText">';
    $lp .= '<img src="https://209.126.119.193/~chapmanmcalpine/wp-content/uploads/2017/12/RepresentationinCourt.png"/>
            <h6>Representation in Court</h6>
            <p>Our lawyers are experienced in representing clients at each stage of the court process in a family law case.  There are multiple stages in a typical family law case.</p>
            <a href="#" class="button">LEARN MORE</a>
            <div class="border-right"><div></div></div>
            <div class="border-left"><div></div></div>
            <div class="border-top"><div></div></div>';
    $lp .= '</div>';
    $lp .= '<div class="col col-lg-4 col-md-12 col-sm-12 col-xsm-12 whiteText">';
    $lp .= '<img src="https://209.126.119.193/~chapmanmcalpine/wp-content/uploads/2017/12/LimitedScopeRetainers.png"/>
            <h6>Limited Scope Retainers</h6>
            <p>Limited Scope Retainers refer to a cost-effective alternative to full representation by a lawyer.  This is an “a la carte” type of legal representation where you choose which aspects of your case you would like your lawyer to represent you on or provide you with advice for. </p>
            <a href="#" class="button">LEARN MORE</a>
            <div class="border-left"><div></div></div>
            <div class="border-top"><div></div></div>';
    $lp .= '</div>';
    $lp .= '</div>';
    $lp .= '<div class="row thirdrow d-flex justify-content-between padding0">';
    $lp .= '<div class="col col-lg-4 col-md-12 col-sm-12 col-xsm-12 whiteText">';
    $lp .= '<img src="https://209.126.119.193/~chapmanmcalpine/wp-content/uploads/2017/12/Divorce.png"/>
            <h6>Divorce</h6>
            <p>Divorce refers to the legal dissolution of a marriage.  At Chapman McAlpine Law, we handle divorce-only cases on a competitive flat-fee basis.  Obtaining a Divorce is relatively straight forward if all of the other issues have been dealt with in a separation agreement (e.g., custody/access, support and property issues).</p>
            <a href="#" class="button">LEARN MORE</a>
            <div class="border-right"><div></div></div>
            <div class="border-top"><div></div></div>';
    $lp .= '</div>';

    $lp .= '<div class="col col-lg-4 col-md-12 col-sm-12 col-xsm-12 whiteText">';
    $lp .= '<img src="https://209.126.119.193/~chapmanmcalpine/wp-content/uploads/2017/12/PropertyDivisionIcon.png"/>
            <h6>Property Division</h6>
            <p>The laws differ for property division for married spouses (equalization) and common-law spouses. The law for equalization is governed by statute, whereas the law for common-law spouses is based on equitable claims made by case-law (judge-made law).</p>
            <a href="#" class="button">LEARN MORE</a>
            <div class="border-right"><div></div></div>
            <div class="border-left"><div></div></div>
            <div class="border-top"><div></div></div>';
    $lp .= '</div>';
    $lp .= '<div class="col col-lg-4 col-md-12 col-sm-12 col-xsm-12 whiteText">';
    $lp .= '<img src="https://209.126.119.193/~chapmanmcalpine/wp-content/uploads/2017/12/ResolutionsOptions.png"/>
            <h6>Resolutions Options</h6>
            <p>There are various options in family law to resolve your case.    The legal costs differ with each option as each option requires more or less involvement from your lawyer than the other options.  Whichever option you choose your lawyer can assist you in finalizing your case with a court order or agreement.</p>
            <a href="#" class="button">LEARN MORE</a>
            <div class="border-left"><div></div></div>
            <div class="border-top"><div></div></div>';
    $lp .= '</div>';
    $lp .= '</div>';


    $lp .= '</div></div>';
    return $lp;
}
add_shortcode('service_section','nga_services');

<?php

add_action( 'init', 'create_custom_testimonial_post_types' );

//CUSTOM POST TYPE
function create_custom_testimonial_post_types() {
    register_post_type( 'testimonials',
        array(
            'labels' => array(
                'name' => 'Testimonial',
                'singular_name' => 'Testimonial',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Testimonial Slide',
                'edit' => 'Edit',
                'edit_item' => 'Edit Testimonial Slide',
                'new_item' => 'New Testimonial Slide',
                'view' => 'View',
                'view_item' => 'View Testimonial Slide',
                'search_items' => 'Search Testimonial Slide',
                'not_found' => 'No Testimonial Slide found',
                'not_found_in_trash' => 'No Testimonial Slide found in Trash'
            ),

            'public' => true,
            'menu_position' => 5,
            'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
            'taxonomies' => array( '' ),
            'menu_icon' => '',
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'testimonials', 'with_front' => false ),
        )
    );
}

// CUSTOM POST TYPE ICON
add_action( 'admin_head', 'testimonial_icons' );
function testimonial_icons() { ?>
    <style type="text/css" media="screen">
        /****testimonial****/
        #menu-posts-testimonial .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/admin/post_types/testimonials/testimonials-spritesheet.png) no-repeat 6px 6px !important;
        }
        #menu-posts-testimonial:hover .wp-menu-image {
            background-position: 6px -34px !important;
        }

        #menu-posts-testimonial.wp-has-current-submenu .wp-menu-image {
            background-position: 6px -73px !important;
        }
    </style>
<?php
}

//Testimonial META BOX
function my_testimonial_admin() {
    add_meta_box( 'testimonial_meta_box',
        'Testimonial Author Info',
        'display_testimonial_meta_box',
        'testimonials', 'advanced', 'high'
    );
}

add_action( 'admin_init', 'my_testimonial_admin' );

function display_testimonial_meta_box( $test ) {
    global $post;

    $auth = esc_html( get_post_meta( $test->ID, 'testimonial_author', true ) );
    $comp = esc_html( get_post_meta( $test->ID, 'testimonial_company', true ) );
    ?>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%">Testimonial Author</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="testimonial_author" value="<?php echo $auth; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Testimonial Company</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="testimonial_company" value="<?php echo $comp; ?>" /></td>
        </tr>
        <input type="hidden" name="testimonial_flag" value="true" />
    </table>
<?php
}

function custom_fields_testimonial_update($post_id, $post ){
    if ( $post->post_type == 'testimonials' ) {
        if (isset($_POST['testimonial_flag'])) {
            if ( isset( $_POST['testimonial_author'] ) && $_POST['testimonial_author'] != '' ) {
                update_post_meta( $post_id, 'testimonial_author', $_POST['testimonial_author'] );
            }else{
                update_post_meta( $post_id, 'testimonial_author', '');
            }

            if ( isset( $_POST['testimonial_company'] ) && $_POST['testimonial_company'] != '' ) {
                update_post_meta( $post_id, 'testimonial_company', $_POST['testimonial_company'] );
            }else{
                update_post_meta( $post_id, 'testimonial_company', '');
            }
        }
    }
}

add_action( 'save_post', 'custom_fields_testimonial_update', 10, 2 );


function testimonials_func($atts) {
    extract( shortcode_atts( array(
        'offset' => 0,
        'carousel' => 'no',
        'id' => '',
        'ids' => '',
        'class' => '',
        'posts_per_page' => -1,
        'title' => '',
        'direction' => 'left'
    ), $atts ));

    global $post;

    $testimonials = '';

    $testimonials .= '<div '.(($id != '')? 'id="'.$id.'"':'').' class="testouter '.(($class != '')? $class:"").'">';
        $testimonials .= '<div>';
          $testimonials .= '<h2 class="text-align-center">Testimonials</h2>';
            $testimonials .= '<div id="testimonials-'.$offset.'" class="testimonials '.(($carousel == 'yes')?"testimonials-carousel":"").'" data-offset="'.$offset.'" data-howmany="1" data-timeout="400" data-direction="'.$direction.'">';
                $testimonials .= '<div class="carousel-list">';
                    wp_reset_query();
                    if($ids == ''){
                        $args = array(
                            'post_type' => 'testimonials',
                            'posts_per_page' => $posts_per_page,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                    }else{
                        $idarray = explode(',', $ids);

                        $args = array(
                            'post_type' => 'testimonials',
                            'posts_per_page' => $posts_per_page,
                            'post__in' => $idarray,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                    }

                    $the_query = new WP_Query( $args );
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        $auth = get_post_meta($post->ID, 'testimonial_author', true);
                        $comp = get_post_meta($post->ID, 'testimonial_company', true);

                        $testimonials .= '<div>';
                            if (has_post_thumbnail()) {
                                $testimonials .= '<div class="testImg">';
                                    $testimonials .= get_the_post_thumbnail($post->ID, array(120,120));
                                $testimonials .= '</div>';
                            }

                            $testimonials .= '<div class="testContent">';

                                $testimonials .= apply_filters('the_content', get_the_content());

                                if($auth != '' || $comp != ''){
                                    $testimonials .= '<div class="author">';
                                    if($auth != ''){
                                        $testimonials .= '<span>'.$auth.'</span>';
                                    }

                                    if($comp != ''){
                                        $testimonials .= '<span>'.$comp.'</span>';
                                    }
                                    $testimonials .= '</div>';
                                }
                            $testimonials .= '</div>';
                        $testimonials .= '</div>';
                    endwhile;
                    wp_reset_query();
                $testimonials .= '</div>';
            $testimonials .= '</div>';

            if($carousel == 'yes'){
                $testimonials .= '<div id="testimonial-pr-nx-'.$offset.'" class="testimonial-pr-nx">';
                    $testimonials .= '<div id="testimonial-prev-'.$offset.'" class="testimonial-prev"><div><img src="'.get_stylesheet_directory_uri().'/img/arrow-left.png"/></div></div>';
                    $testimonials .= '<div id="testimonial-next-'.$offset.'" class="testimonial-next"><div><img src="'.get_stylesheet_directory_uri().'/img/arrow-right.png"/></div></div>';
                $testimonials .= '</div>';
            }

        $testimonials .= '</div>';

        if($carousel == 'yes'){
            wp_enqueue_script( 'modular-wp-testimonials', get_template_directory_uri() . '/admin/post_types/testimonials/testimonials.js', array('jquery'), '1.0.0', true );

        }
    $testimonials .= '</div>';

    return $testimonials;
}

add_shortcode( 'testimonials_slide', 'testimonials_func' );;


?>

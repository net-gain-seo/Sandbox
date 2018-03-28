<?php
add_action( 'init', 'create_custom_our_promotions_post_types' );

//CUSTOM POST TYPE
function create_custom_our_promotions_post_types() {
    register_post_type( 'our_promotions',
        array(
            'labels' => array(
                'name' => 'Our Promotions',
                'singular_name' => 'Our Promotions',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Our Promotions Slide',
                'edit' => 'Edit',
                'edit_item' => 'Edit Our Promotions Slide',
                'new_item' => 'New Our Promotions Slide',
                'view' => 'View',
                'view_item' => 'View Our Promotions Slide',
                'search_items' => 'Search Our Promotions Slide',
                'not_found' => 'No Our Promotions Slide found',
                'not_found_in_trash' => 'No Our Promotions Slide found in Trash'
            ),

            'public' => true,
            'menu_position' => 5,
            'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
            'taxonomies' => array( '' ),
            'menu_icon' => '',
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'our_promotions', 'with_front' => false ),
        )
    );
}

// CUSTOM POST TYPE ICON
add_action( 'admin_head', 'our_promotions_icons' );
function our_promotions_icons() { ?>
    <style type="text/css" media="screen">
        /****our_promotions****/
        #menu-posts-our_promotions .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/admin/post_types/our_promotions/testimonials-spritesheet.png) no-repeat 6px 6px !important;
        }
        #menu-posts-our_promotions:hover .wp-menu-image {
            background-position: 6px -34px !important;
        }

        #menu-posts-our_promotions.wp-has-current-submenu .wp-menu-image {
            background-position: 6px -73px !important;
        }
    </style>
<?php
}

//our_promotions META BOX
function my_our_promotions_admin() {
    add_meta_box( 'our_promotions_meta_box',
        'Author Info',
        'display_our_promotions_meta_box',
        'our_promotions', 'advanced', 'high'
    );
}

add_action( 'admin_init', 'my_our_promotions_admin' );

function display_our_promotions_meta_box( $test ) {
    global $post;
    $custom = get_post_custom($post->ID);

    $authtext = esc_html( get_post_meta( $test->ID, 'our_promotions_text', true ) );
    $complink = esc_html( get_post_meta( $test->ID, 'our_promotions_link', true ) );
    ?>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%">Download Case Study Text</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="our_promotions_text" value="<?php echo $authtext; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Download Case Study Link</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="our_promotions_link" value="<?php echo $complink; ?>" /></td>
        </tr>
        <tr><td style="width: 100%">&nbsp;</td></tr>
        <input type="hidden" name="our_promotions_flag" value="true" />
    </table>
<?php
}

function custom_fields_our_promotions_update($post_id, $post ){
    if ( $post->post_type == 'our_promotions' ) {
        if (isset($_POST['our_promotions_flag'])) {
            update_post_meta($post_id, "num_stars", $_POST['num_stars']);

            if ( isset( $_POST['our_promotions_text'] ) && $_POST['our_promotions_text'] != '' ) {
                update_post_meta( $post_id, 'our_promotions_text', $_POST['our_promotions_text'] );
            }else{
                update_post_meta( $post_id, 'our_promotions_text', '');
            }

            if ( isset( $_POST['our_promotions_link'] ) && $_POST['our_promotions_link'] != '' ) {
                update_post_meta( $post_id, 'our_promotions_link', $_POST['our_promotions_link'] );
            }else{
                update_post_meta( $post_id, 'our_promotions_link', '');
            }
        }
    }
}

add_action( 'save_post', 'custom_fields_our_promotions_update', 10, 2 );


function our_promotions_func($atts) {
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

    $our_promotions = '';

    $our_promotions .= '<div '.(($id != '')? 'id="'.$id.'"':'').' class="testouter '.(($class != '')? $class:"").'">';
        if($title != ''){
            $our_promotions .= '<h2>'.$title.'</h2>';
        }

        $our_promotions .= '<div>';
            $our_promotions .= '<div id="our_promotions-'.$offset.'" class="our_promotions '.(($carousel == 'yes')?"our_promotions-carousel":"").'" data-offset="'.$offset.'" data-howmany="1" data-timeout="400" data-direction="'.$direction.'">';
                $our_promotions .= '<div class="carousel-list">';
                    wp_reset_query();
                    if($ids == ''){
                        $args = array(
                            'post_type' => 'our_promotions',
                            'posts_per_page' => $posts_per_page,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                    }else{
                        $idarray = explode(',', $ids);

                        $args = array(
                            'post_type' => 'our_promotions',
                            'posts_per_page' => $posts_per_page,
                            'post__in' => $idarray,
                            'orderby' => 'menu_order',
                            'order' => 'ASC'
                        );
                    }

                    $the_query = new WP_Query( $args );
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        $authtext = get_post_meta($post->ID, 'our_promotions_text', true);
                        $complink = get_post_meta($post->ID, 'our_promotions_link', true);
                        $stars = get_post_meta($post->ID, 'num_stars', true);

                        $our_promotions .= '<div class="row">';

                            $our_promotions .= '<div class="CaseContent">';
                            $our_promotions .= '<h3>'.get_the_title().'</h3>';
                                //$our_promotions .= '<h3>'.get_the_title().'</h3>';

                                $our_promotions .= apply_filters('the_content', get_the_excerpt());
                                $our_promotions .= '<a href="'.$complink.'" class="readmoretest orangeText">'.$authtext.'</a>';
                                //$our_promotions .= '<a href="'.get_permalink().'" class="readmoretest orangeText">'.$authtext.'</a>';

                            $our_promotions .= '</div>';
                        $our_promotions .= '</div>';
                    endwhile;
                    wp_reset_query();
                $our_promotions .= '</div>';
            $our_promotions .= '</div>';

            if($carousel == 'yes'){
                $our_promotions .= '<div id="our_promotions-pr-nx-'.$offset.'" class="our_promotions-pr-nx">';
                    $our_promotions .= '<div id="our_promotions-prev-'.$offset.'" class="our_promotions-prev"><div>Prev</div></div>';
                    $our_promotions .= '<div id="our_promotions-next-'.$offset.'" class="our_promotions-next"><div>Next</div></div>';
                $our_promotions .= '</div>';
            }

        $our_promotions .= '</div>';

        if($carousel == 'yes'){
            wp_enqueue_script( 'modular-wp-student-success', get_template_directory_uri() . '/admin/post_types/our_promotions/testimonials.js', array('jquery'), '1.0.0', true );

        }
    $our_promotions .= '</div>';

    return $our_promotions;
}

add_shortcode( 'our_promotionsold', 'our_promotions_func' );;

?>

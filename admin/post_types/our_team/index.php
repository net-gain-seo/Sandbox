<?php
add_action( 'init', 'create_custom_our_team_post_types' );

//CUSTOM POST TYPE
function create_custom_our_team_post_types() {
    register_post_type( 'our_team',
        array(
            'labels' => array(
                'name' => 'Our Team',
                'singular_name' => 'Our Team',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Our Team Employee',
                'edit' => 'Edit',
                'edit_item' => 'Edit Our Team Employee',
                'new_item' => 'New Our Team Employee',
                'view' => 'View',
                'view_item' => 'View Our Team Employee',
                'search_items' => 'Search Our Team Employee',
                'not_found' => 'No Our Team Employee found',
                'not_found_in_trash' => 'No Our Team Employee found in Trash'
            ),

            'public' => true,
            'menu_position' => 5,
            'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes'),
            'taxonomies' => array( '' ),
            'menu_icon' => '',
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'our_team_section', 'with_front' => false ),
        )
    );
}

// CUSTOM POST TYPE ICON
add_action( 'admin_head', 'our_team_icons' );
function our_team_icons() { ?>
    <style type="text/css" media="screen">
        /****our_team****/
        #menu-posts-our_team .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/admin/post_types/our_team/testimonials-spritesheet.png) no-repeat 6px 6px !important;
        }
        #menu-posts-our_team:hover .wp-menu-image {
            background-position: 6px -34px !important;
        }

        #menu-posts-our_team.wp-has-current-submenu .wp-menu-image {
            background-position: 6px -73px !important;
        }
    </style>
<?php
}

//our_team META BOX
function our_team_admin() {
    add_meta_box( 'our_team_meta_box',
        'Author Info',
        'display_our_team_meta_box',
        'our_team', 'advanced', 'high'
    );
}

add_action( 'admin_init', 'our_team_admin' );

function display_our_team_meta_box( $test ) {
    global $post;
    $custom = get_post_custom($post->ID);

    $position = esc_html( get_post_meta( $test->ID, 'position', true ) );
    $phone = esc_html( get_post_meta( $test->ID, 'phone_number', true ) );
    $email = esc_html( get_post_meta( $test->ID, 'email_address', true ) );
    ?>
    <table style="width: 100%;">
      <tr>
          <td style="width: 100%">Position:</td>
      </tr>
      <tr>
          <td><input type="text" style="width: 100%" name="position" value="<?php echo $position; ?>" /></td>
      </tr>
        <tr>
            <td style="width: 100%">Phone Number:</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="phone_number" value="<?php echo $phone; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Email Address:</td>
        </tr>
        <tr>
            <td><input type="text" style="width: 100%" name="email_address" value="<?php echo $email; ?>" /></td>
        </tr>
        <tr><td style="width: 100%">&nbsp;</td></tr>
        <input type="hidden" name="our_team_flag" value="true" />
    </table>
<?php
}

function custom_fields_our_team_update($post_id, $post ){
    if ( $post->post_type == 'our_team' ) {
        if (isset($_POST['our_team_flag'])) {
            update_post_meta($post_id, "num_stars", $_POST['num_stars']);

            if ( isset( $_POST['phone_number'] ) && $_POST['phone_number'] != '' ) {
                update_post_meta( $post_id, 'phone_number', $_POST['phone_number'] );
            }else{
                update_post_meta( $post_id, 'phone_number', '');
            }

            if ( isset( $_POST['email_address'] ) && $_POST['email_address'] != '' ) {
                update_post_meta( $post_id, 'email_address', $_POST['email_address'] );
            }else{
                update_post_meta( $post_id, 'email_address', '');
            }

            if ( isset( $_POST['position'] ) && $_POST['position'] != '' ) {
                update_post_meta( $post_id, 'position', $_POST['position'] );
            }else{
                update_post_meta( $post_id, 'position', '');
            }
        }
    }
}

add_action( 'save_post', 'custom_fields_our_team_update', 10, 2 );


function our_team_func($atts) {
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
                    $args = array(
                        'post_type' => 'our_team',
                        'posts_per_page' => $posts_per_page,
                        'post__in' => $idarray,
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    );
                    $our_team .= '<div class="container ourteam" >';
                    $our_team .= '<div class="row">';
                    $the_query = new WP_Query( $args );
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        $phone = get_post_meta($post->ID, 'phone_number', true);
                        $email = get_post_meta($post->ID, 'email_address', true);
                        $position = get_post_meta($post->ID, 'position', true);
                        $stars = get_post_meta($post->ID, 'num_stars', true);
                        $phonenum = preg_replace("/[^a-zA-Z0-9]/", "", $phone);
                    $our_team .= '<div class="col col-lg-6 col-md-6 col-sm-12 col-xsm-12">';
                            $our_team .= '<div class="OurTeamMember">';
                            $our_team .= '<a href="'.get_post_permalink().'"><div class="picture">'.get_the_post_thumbnail().'</div></a>';
                            $our_team .= '<div class="introsection"><h3>'.get_the_title().'</h3>';
                            $our_team .= '<h4><em>'.$position.'</em></h4></div>';
                                $our_team .= '<div class="infosection">';
                                $our_team .= '<p><em>P.</em> <a href="tel:+'.$phonenum.'">'.$phone.'</a></p>';
                                $our_team .= '<hr class="ourteamline"/>';
                                $our_team .= '<p><em>E.</em> <a href="mailto:'.$email.'">'.$email.'</a></p>';
                                $our_team .= '</div>';
                        $our_team .= '</div>';
                        $our_team .= '</div>';
                    endwhile;
                    wp_reset_query();
            $our_team .= '</div>';
        $our_team .= '</div>';
    return $our_team;
}

add_shortcode( 'our_team', 'our_team_func' );;

?>

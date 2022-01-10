<?php
/*This file is part of varia-child, varia child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

if ( ! function_exists( 'suffice_child_enqueue_child_styles' ) ) {
    function varia_child_enqueue_child_styles() {
        // loading parent style
        wp_register_style(
            'parente2-style',
            get_template_directory_uri() . '/style.css'
        );

        wp_enqueue_style( 'parente2-style' );
        // loading child style
        wp_register_style(
            'childe2-style',
            get_stylesheet_directory_uri() . '/style.css'
        );
        wp_enqueue_style( 'childe2-style');

        wp_enqueue_style('Raleway-font','https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;700&display=swap');
    }
}
add_action( 'wp_enqueue_scripts', 'varia_child_enqueue_child_styles' );

/*Write here your own functions */
add_action( 'wp_enqueue_scripts', 'enqueue_custom_css' );
function enqueue_custom_css() {
   if (is_page('ltn-consultation-responses') || is_page('ev-charging')) {
        /*wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );*/
       // wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
       wp_enqueue_style('leaflet.css','https://unpkg.com/leaflet@1.5.1/dist/leaflet.css');
       wp_enqueue_style('MarkerCluster-Default','https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css');
       wp_enqueue_style('MarkerCluster','https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css');

   }
}
add_action('wp_enqueue_scripts', 'tutsplus_enqueue_custom_js');
function tutsplus_enqueue_custom_js() {
    if (is_page('ltn-consultation-responses') || is_page('ev-charging')) {
        wp_enqueue_script('leaflet.js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), false, true);
        wp_enqueue_script('markercluster.js', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js', array(), false, true);
        wp_enqueue_script('jquery','https://code.jquery.com/jquery-3.5.1.min.js', array(), null, true);
        wp_enqueue_script('map', get_stylesheet_directory_uri().'/scripts/map.js', array('jquery'), null, true);
        // In order for this stylesheet to work (and not be overridden by
        // external CSS) it needs to be excluded in Jetpack from those scripts
        // that are concatenated together
        wp_enqueue_style('style-map',get_stylesheet_directory_uri().'/style-map.css', array('MarkerCluster'));
    }
}

function varia_widgets2_init() {

        register_sidebar(
                array(
                        'name'          => __( 'Footer2', 'varia' ),
                        'id'            => 'sidebar-2',
                        'description'   => __( 'Add widgets here to appear in your footer.', 'varia' ),
                        'before_widget' => '<section id="%1$s" class="widget %2$s">',
                        'after_widget'  => '</section>',
                        'before_title'  => '<h2 class="widget-title">',
                        'after_title'   => '</h2>',
                )
        );

}
add_action( 'widgets_init', 'varia_widgets2_init' );



function varia_widgets3_init() {

        register_sidebar(
                array(
                        'name'          => __( 'Footer3', 'varia' ),
                        'id'            => 'sidebar-3',
                        'description'   => __( 'Add widgets here to appear in your footer.', 'varia' ),
                        'before_widget' => '<section id="%1$s" class="widget %2$s">',
                        'after_widget'  => '</section>',
                        'before_title'  => '<h2 class="widget-title">',
                        'after_title'   => '</h2>',
                )
        );

}
add_action( 'widgets_init', 'varia_widgets3_init' );

/**
 * Modify the "must_log_in" string of the comment form.
 *
 * @see http://wordpress.stackexchange.com/a/170492/26350
 */
/* Removed: this seems to be overridden by Jetpack
add_filter( 'comment_form_defaults', function( $fields ) {
    $fields['must_log_in'] = sprintf(
        __( '<p class="must-log-in">
                 You must <a href="%s">Register</a> or
                 <a href="%s">Login</a> to post a comment.</p>'
        ),
        wp_registration_url(),
        wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
    );
    return $fields;
});
 */

// define the jetpack_must_log_in_to_comment callback
function filter_jetpack_must_log_in_to_comment( $var ) {
    // make filter magic happen here...
    $var = 'To post a comment please <a href="%s">log in</a> using your HyPER membership username'
        .' and password. If you have not yet joined HyPER please do so by going to the'
        .' <a href="/join/">membership</a> page.';
    return $var;
};

// add the filter
add_filter( 'jetpack_must_log_in_to_comment', 'filter_jetpack_must_log_in_to_comment', 10, 1 );

// Allow SVG uploads
function allow_svgimg_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'allow_svgimg_types');

// Allow WEBP uploads
function allow_webpimg_types($mimes) {
  $mimes['webp'] = 'image/webp';
  return $mimes;
}
add_filter('upload_mimes', 'allow_webpimg_types');

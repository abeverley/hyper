<?php
/*This file is part of varia-child, varia child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/

add_filter( 'jetpack_sharing_counts', '__return_false', 99 );
add_filter( 'jetpack_implode_frontend_css', '__return_false', 99 );

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
         }
}
add_action( 'wp_enqueue_scripts', 'varia_child_enqueue_child_styles' );

/*Write here your own functions */
add_action( 'wp_enqueue_scripts', 'enqueue_custom_css' );
function enqueue_custom_css() {
   if (is_page('ltn-consultation-responses')) {
        /*wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );*/
       wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
       wp_enqueue_style('leaflet.css','https://unpkg.com/leaflet@1.5.1/dist/leaflet.css');
       wp_enqueue_style('MarkerCluster-Default','https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css');
       wp_enqueue_style('MarkerCluster','https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css');

       wp_enqueue_style('style-map',get_stylesheet_directory_uri().'/style-map.css', array('MarkerCluster'));
   }
}
add_action('wp_enqueue_scripts', 'tutsplus_enqueue_custom_js');
function tutsplus_enqueue_custom_js() {
    if (is_page('ltn-consultation-responses')) {
        wp_enqueue_script('leaflet.js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), false, true);
        wp_enqueue_script('markercluster.js', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js', array(), false, true);
        wp_enqueue_script('jquery','https://code.jquery.com/jquery-3.5.1.min.js', array('jquery'), '3.5.1', true);
        wp_enqueue_script('map', get_stylesheet_directory_uri().'/scripts/map.js', array('jquery'), '3.5.1', true);
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

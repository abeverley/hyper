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
   if (is_page('ltn-consultation-responses')) {
        /*wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );*/
       wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
       wp_enqueue_style('leaflet.css','https://unpkg.com/leaflet@1.5.1/dist/leaflet.css');
       wp_enqueue_style('MarkerCluster-Default','https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css');
       wp_enqueue_style('MarkerCluster','https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css');

   }
}
add_action('wp_enqueue_scripts', 'tutsplus_enqueue_custom_js');
function tutsplus_enqueue_custom_js() {
    if (is_page('ltn-consultation-responses')) {
        wp_enqueue_script('leaflet.js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js', array(), false, true);
        wp_enqueue_script('markercluster.js', 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js', array(), false, true);
        wp_enqueue_script('jquery','https://code.jquery.com/jquery-3.5.1.min.js', array('jquery'), '3.5.1', true);
        wp_enqueue_script('map', get_stylesheet_directory_uri().'/scripts/map.js', array('jquery'), '3.5.1', true);
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

function my_pmprorh_init()
{
    //don't break if Register Helper is not loaded
    if(!function_exists("pmprorh_add_registration_field"))
    {
        return false;
    }
    //define the fields
    $fields = array();

    $fields[] = new PMProRH_Field(
        "First name(s)",
        "text"
    );
    $fields[] = new PMProRH_Field(
        "Surname",
        "text"
    );
    $fields[] = new PMProRH_Field(
        "Address",
        "text"
    );
    $fields[] = new PMProRH_Field(
        "Postcode",
        "text"
    );
    $fields[] = new PMProRH_Field(
        "I would like to volunteer to be a HyPER rep for my street/area",
        "checkbox"
        //array(
        //    "text" => "Yes, I would like to be a rep"
        //)
    );

    foreach($fields as $field)
        pmprorh_add_registration_field(
            "checkout_boxes", // location on checkout page
            $field
        );
}
add_action("init", "my_pmprorh_init");
// This should hide billing information fields but does not seem to work
apply_filters( 'pmpro_hide_billing_address_fields', true);

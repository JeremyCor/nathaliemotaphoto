<?php
/*Pour les anciennes versions*/
if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
            do_action( 'wp_body_open' );
    }
}

// Chargement des styles persos
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('motaphoto-contact-style', get_stylesheet_directory_uri() . '/assets/css/contact.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/contact.css'));
    wp_enqueue_style('motaphoto-single-photo-style', get_stylesheet_directory_uri() . '/assets/css/single-photo.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/single-photo.css'));
    wp_enqueue_style('motaphoto-lightbox-style', get_stylesheet_directory_uri() . '/assets/css/lightbox.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/lightbox.css'));

    if (is_front_page()) {
        wp_enqueue_style('swiper-style', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css');
        wp_enqueue_script('swiper-script', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array(), '9.2.0', true);

    }

//chargement du script perso
    wp_enqueue_script( 'motaphoto-scripts', get_theme_file_uri( '/assets/js/scripts.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/scripts.js'), true );

}

// Script JS chargé pour tout le monde sauf avec front_page 
if (!is_front_page()) {
    wp_enqueue_script( 'motaphoto-scripts-lightbox-ajax', get_theme_file_uri( '/assets/js/lightbox-ajax.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox-ajax.js'), true );
};

//Scripts chargés sur la front-page


function my_enqueue_scripts() {
    if (is_front_page()) {
        error_log('Front page detected');  // Pour vérifier dans les logs PHP
        wp_enqueue_script('motaphoto-scripts-filtres', get_theme_file_uri('/assets/js/filtres.js'), array('jquery', 'swiper-script'), filemtime(get_stylesheet_directory() . '/assets/js/filtres.js'), true);
        wp_enqueue_script('motaphoto-scripts-publication-ajax', get_theme_file_uri('/assets/js/publication-ajax.js'), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/publication-ajax.js'), true);
        wp_enqueue_script('motaphoto-scripts-lightbox-ajax', get_theme_file_uri('/assets/js/lightbox-front-page-ajax.js'), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox-front-page-ajax.js'), true);
    };

    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');





// Ajouter la prise en charge des images mises en avant
add_theme_support('post-thumbnails');
set_post_thumbnail_size(600, 0, false);
add_image_size('hero', 1450, 960, true);
add_image_size('desktop-home', 600, 520, true);
add_image_size('lightbox', 1300, 900, true);

add_theme_support('title-tag');

// Shortcode permettant d'afficher le bouton de contact
function contact_btn() {
    return '<a href="#" id="contact_btn" class="contact">Contact</a>';
}
add_shortcode('contact', 'contact_btn');

function add_contact_button_to_menu($items, $args) {
    if ($args->theme_location == 'main') {
        $contact_btn = do_shortcode('[contact]');
        $items .= '<li class="menu-item">' . $contact_btn . '</li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_contact_button_to_menu', 10, 2);

// Récupération de la valeur champs personnalisé ACF
function my_acf_load_value($variable, $field) {
    $return = "";
    if (is_array($field)) {
        foreach ($field as $key => $value) {
            if ($key === $variable) {
                $return = $value;
                break;
            }
        }
    } else {
        error_log('my_acf_load_value: $field is not an array');
    }
    return $return;
}


// Enregistrement des menus
function register_my_menu() {
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
}
add_action('after_setup_theme', 'register_my_menu');

?>

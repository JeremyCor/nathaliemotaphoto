<?php

// Chargement des styles
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('motaphoto-contact-style', get_stylesheet_directory_uri() . '/assets/css/contact.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/contact.css'));
    wp_enqueue_style('motaphoto-single-photo-style', get_stylesheet_directory_uri() . '/assets/css/single-photo.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/single-photo.css'));
    wp_enqueue_style('motaphoto-lightbox-style', get_stylesheet_directory_uri() . '/assets/css/lightbox.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/lightbox.css'));

    if (is_front_page()) {
        wp_enqueue_style('swiper-style', get_stylesheet_directory_uri() . '/assets/css/swiper-bundle.min.css');
    }

    wp_enqueue_style('dashicons');
}

// Ajouter le hook pour enqueuer les scripts séparément
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-ajax', get_stylesheet_directory_uri() . '/assets/js/publication-ajax.js', array('jquery'), null, true );
    wp_localize_script('custom-ajax', 'motaphoto_params', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('motaphoto_nonce')
    ));

    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0', true);

    if (is_front_page()) {
        wp_enqueue_script('swiper-script', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array(), '9.2.0', true);
        wp_enqueue_script('motaphoto-scripts-filtres', get_theme_file_uri('/assets/js/filtres.js'), array('jquery', 'swiper-script'), filemtime(get_stylesheet_directory() . '/assets/js/filtres.js'), true);
        wp_enqueue_script('motaphoto-scripts-publication-ajax', get_theme_file_uri('/assets/js/publication-ajax.js'), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/publication-ajax.js'), true);
        wp_enqueue_script('motaphoto-scripts-lightbox-ajax', get_theme_file_uri('/assets/js/lightbox-front-page-ajax.js'), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox-front-page-ajax.js'), true);
    } else {
        wp_enqueue_script('motaphoto-scripts-lightbox-ajax', get_theme_file_uri('/assets/js/lightbox-ajax.js'), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox-ajax.js'), true);
    }
}

// GESTION DES ARTICLES
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

// AJAX pour charger les photos
function motaphoto_load() {
    check_ajax_referer('motaphoto_nonce', 'nonce');

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $categorie_id = isset($_POST['categorie_id']) ? sanitize_text_field($_POST['categorie_id']) : '';
    $format_id = isset($_POST['format_id']) ? sanitize_text_field($_POST['format_id']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'date';
    $posts_per_page = 8;

    error_log("Categorie ID: $categorie_id");
    error_log("Format ID: $format_id");
    error_log("Order: $order");

    $tax_query = array('relation' => 'AND');
    if (!empty($categorie_id)) {
        $tax_query[] = array(
            'taxonomy' => 'categorie-acf',
            'field' => 'term_id',
            'terms' => $categorie_id,
        );
    }
    if (!empty($format_id)) {
        $tax_query[] = array(
            'taxonomy' => 'format-acf',
            'field' => 'term_id',
            'terms' => $format_id,
        );
    }

    error_log("Tax Query: " . print_r($tax_query, true));

    $custom_args = array(
        'post_type' => 'photographie',
        'posts_per_page' => $posts_per_page,
        'order' => $order,
        'orderby' => $orderby,
        'paged' => $paged,
        'tax_query' => $tax_query,
    );

    error_log("Custom Args: " . print_r($custom_args, true));

    $query = new WP_Query($custom_args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/post/publication');
        }
    } else {
        error_log("Aucun article ne correspond à cette demande.");
        echo '<p>Désolé. Aucun article ne correspond à cette demande.</p>';
    }

    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_motaphoto_load', 'motaphoto_load');
add_action('wp_ajax_nopriv_motaphoto_load', 'motaphoto_load');

// Enregistrement des menus
function register_my_menu() {
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
}
add_action('after_setup_theme', 'register_my_menu');

?>

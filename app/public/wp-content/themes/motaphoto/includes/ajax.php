<?php
/**
 * Complément de fonction.php
 * fonctions pour AJAX 
 *
 * @package WordPress
 */


/**
*  Génération de l'affichage des photos
*/  
function motaphoto_load() { 
  // Vérification de sécurité
  if( 
    ! isset( $_REQUEST['nonce'] ) or 
          ! wp_verify_nonce( $_REQUEST['nonce'], 'motaphoto_nonce' ) 
    ) {
      wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action.", 403 );
      exit;
    }

  // Récupération des données pour le filtre et on les nettoie
  // pour éviter toute injection SQL 
  $categorie_id = sanitize_text_field($_POST['categorie_id']);
  $format_id = sanitize_text_field($_POST['format_id']);
  $orderby = sanitize_text_field($_POST['orderby']);
  $order = sanitize_text_field($_POST['order']);
  $paged = intval($_POST['paged']);

  // Configuration du filtre
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

  $custom_args = array(
    'post_type' => 'photographie',
        // 'posts_per_page' => 8,
      'posts_per_page' => get_option( 'posts_per_page'), // Valeur par défaut
      'orderby' => $orderby,
      'order' => $order,
      'paged' => $paged, 
        'tax_query' => $tax_query,
        'nopaging' => false,
        );  

    $query_more = new WP_Query( $custom_args ); 

    $total_posts = get_posts( $custom_args );
    // echo $query->found_posts . " articles trouvés"; 
    $nb_total_posts  = $query_more->found_posts;
    $max_pages = $query_more->max_num_pages;   

    $custom_args2 = array_replace($custom_args, array( 'posts_per_page' => -1, 'nopaging' => true,));
    $total_posts = get_posts( $custom_args2 );
    $nb_total_posts = count($total_posts);

    $response = '';

    if ($paged === 1) :
    ?>
    <form>  
      <!-- Mise à disposition de JS du tableau contenant toutes les données de la requette et le nombre -->                 
      <input type="hidden" name="total_posts" id="total_posts" value="<?php print_r( $total_posts); ?>">     
      <input type='hidden' name='max_pages' id='max_pages' value='<?php echo $max_pages; ?>'>
      <input type="hidden" name="nb_total_posts" id="nb_total_posts" value="<?php  echo $nb_total_posts; ?>">
       <!-- Mise à jour par ajax.php -->                                    
    </form>  
  
    <?php 
    endif;

    if($query_more->have_posts()) {
      while($query_more->have_posts()) : $query_more->the_post();
        $response .= get_template_part('template-parts/post/publication');
      endwhile;        
    } else {
      $response = ''; 
    }

    wp_reset_postdata();
    exit;
  }
  add_action('wp_ajax_motaphoto_load', 'motaphoto_load');
  add_action('wp_ajax_nopriv_motaphoto_load', 'motaphoto_load');


/**
*  Récupération des données de filtres et nettoyage. génération de de la photo pour la lightbox
*/ 
function motaphoto_lightbox() {
  

  // On vérifie que l'identifiant a bien été envoyé
  if( ! isset( $_POST['photo_id'] ) ) {
    wp_send_json_error( "L'identifiant de la photo est manquant.", 403 );
    exit;
  }

  // Récupération des données pour le filtre
  $photo_id = intval($_POST['photo_id']);
  
  // Configuration du filtre
  $query_lightbox = new WP_Query([
    'post_type' => 'photographie',
    'posts_per_page' => -1,
  ]);
 
$response = '';

if($query_lightbox->have_posts()) {
  while($query_lightbox->have_posts()) : $query_lightbox->the_post();
  if ( get_the_id() == $photo_id) {
    $response = get_template_part('template-parts/modal/lightbox');
  }
  endwhile;
} else {
  $response = '';

}

// On renvoie la réponse au format JSON
wp_reset_postdata();
exit;
 }
add_action('wp_ajax_motaphoto_lightbox', 'motaphoto_lightbox');
add_action('wp_ajax_nopriv_motaphoto_lightbox', 'motaphoto_lightbox');

?>
<?php 
// echo ('photo-detail.php');
//   Vérifier l'activation de ACF
if (!function_exists('get_field')) return;

// Récupérer la taxonomie actuelle
$term = get_queried_object();
$term_id = my_acf_load_value('ID', $term);

// Récupération des termes de la catégorie
$categorie_terms = get_the_terms(get_the_ID(), 'categorie-acf');
$categorie = '';
if ($categorie_terms && !is_wp_error($categorie_terms)) {
    foreach ($categorie_terms as $categ) {
        $categorie .= $categ->name . ' ';
    }
}

// Récupération des termes du format
$format_terms = get_the_terms(get_the_ID(), 'format-acf');
$format = '';
if ($format_terms && !is_wp_error($format_terms)) {
    foreach ($format_terms as $fmt) {
        $format .= $fmt->name . ' ';
    }
}

// Récupération des autres champs ACF
$reference = get_field('reference');
$type = get_field('type');
$annee = get_field('annee');
?>

<article class="container__photo flexcolumn">
    <div class="photo__info flexrow">
        <div class="photo__info--description flexcolumn">
            <h1><?php the_title(); ?></h1>
            <ul class="flexcolumn">
                <!-- Affiche les données ACF -->
                <li class="reference">Référence : 
                    <?php 
                        if($reference) {
                            echo $reference;
                        } else {
                            echo ('Inconnue');
                        }
                    ?>
                </li>
                <li>Catégorie :
                    <?php 
                        if($categorie) {
                            echo trim($categorie);
                        } else {
                            echo ('Inconnue');
                        }
                    ?>
                </li>
                <li>Format :             
                    <?php 
                        if($format) {
                            echo trim($format);
                        } else {
                            echo ('Inconnu');
                        }
                    ?>
                </li>
                <li>Type :              
                    <?php 
                        if($type) {
                            echo $type;
                        } else {
                            echo ('Inconnu');
                        }
                    ?>
                </li>
                <li>Année : 
                    <?php echo $annee ? $annee : the_time('Y'); ?>
                </li>
            </ul>
        </div>
        <div class="photo__info--image flexcolumn">
            <div class="container--image brightness">
                <!-- permet d’afficher l’image mise en avant -->
                <?php the_post_thumbnail('medium_large'); ?>            
                <span class="openLightbox"></span>
            </div>                     
            <form>
                <input type="hidden" name="postid" class="postid" value="<?php the_id(); ?>">
                <button class="openLightbox" title="Afficher la photo en plein écran" alt="Afficher la photo en plein écran"
                    data-postid="<?php echo get_the_id(); ?>"       
                    data-arrow="false"
                    data-nonce="<?php echo wp_create_nonce('motaphoto_lightbox'); ?>"
                    data-action="motaphoto_lightbox"
                    data-ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>"
                >
                </button>
            </form>
        </div>         
    </div>
    
</article>

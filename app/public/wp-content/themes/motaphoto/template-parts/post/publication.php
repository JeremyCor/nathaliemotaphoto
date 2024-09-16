<?php if(has_post_thumbnail()) : ?>                        

<?php
    // Récupérer le champ ACF de la catégorie
    $categorie = get_field('categorie-acf');
?>

<div class="news-info brightness">
    <div class="info-header">
        <h2 class="info-title"><?php the_title(); ?></h2>
        <p class="info-tax">
            <?php
            $categorie = get_the_terms($post->ID, 'categorie-acf');
            if ($categorie && ! is_wp_error($categorie)) {
                echo esc_html($categorie[0]->name); // Affiche le nom de la première catégorie
            } else {
                echo 'Pas de catégorie';
            }
            ?>
        </p>
    </div>
    <a href="<?php the_permalink() ?>" aria-label="Voir le détail de la photo <?php the_title(); ?>" alt="<?php the_title(); ?>" title="Voir le détail de la photo">
        <span class="detail-photo"></span>
    </a>
    <?php the_post_thumbnail(); ?>

    <form>
        <input type="hidden" name="postid" class="postid" value="<?php the_ID(); ?>">
        <a class="openLightbox"  title="Afficher la photo en plein écran" alt="Afficher la photo en plein écran"
            data-postid="<?php echo get_the_ID(); ?>"    
            data-arrow="true" 
        >
        </a>
    </form>
</div>

<?php endif; ?> 

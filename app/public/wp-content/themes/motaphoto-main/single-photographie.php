<?php
/*Template Name: single-photographie */ 

	get_header();
	//wp_enqueue_script( 'motaphoto-scripts-lightbox-ajax', get_theme_file_uri( '/assets/js/lightbox-ajax.js' ), array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/lightbox-ajax.js'), true );
?>

<?php
if( have_posts() ) : while( have_posts() ) : the_post(); ?>
	<section class="photo_detail">
		<?php get_template_part ( 'template-parts/post/photo-detail'); ?>
		
		<div class="photo__contact flexrow">
			<p>Cette photo vous intéresse ? <button class="btn" type="button"><?php echo do_shortcode('[contact]'); ?></button></p>
			<div class="site__navigation flexrow">				
				<div class="site__navigation__prev">
				<?php
					$prev_post = get_previous_post();							
					if($prev_post) {
						$prev_title = strip_tags(str_replace('"', '', $prev_post->post_title));
						$prev_post_id = $prev_post->ID;
						echo '<a rel="prev" href="' . get_permalink($prev_post_id) . '" title="' . $prev_title. '" class="previous_post">';
						if (has_post_thumbnail($prev_post_id)){
							?>
							<div>
								<?php echo get_the_post_thumbnail($prev_post_id, array(77,60));?></div>
							<?php
							}
							else{
								echo '<img src="'. get_stylesheet_directory_uri() .'/assets/img/no-image.jpeg" alt="Pas de photo" width="77px" ><br>';
							}							
							echo '<img src="'. get_stylesheet_directory_uri() .'/assets/img/precedent.png" alt="Photo précédente" ></a>';
						}
						?>
				</div>
				<div class="site__navigation__next">
					<!-- next_post_link( '%link', '%title', false );  -->
					<?php
						$next_post = get_next_post();
						if($next_post) {
							$next_title = strip_tags(str_replace('"', '', $next_post->post_title));
							$next_post_id = $next_post->ID;
							echo  '<a rel="next" href="' . get_permalink($next_post_id) . '" title="' . $next_title. '" class="next_post">';
							if (has_post_thumbnail($next_post_id)){
							?>
								<div><?php echo get_the_post_thumbnail($next_post_id, array(77,60));?></div>
							<?php
							}
							else{
								echo '<img src="'. get_stylesheet_directory_uri() .'/assets/img/no-image.jpeg" alt="Pas de photo" width="77px" ><br>';
							}							
							echo '<img src="'. get_stylesheet_directory_uri() .'/assets/img/suivant.png" alt="Photo suivante" ></a>';
						}
					?>
					
				</div>
			</div>
		</div>
		<div class="photo__others flexcolumn">
			<h2>Vous aimerez aussi</h2>		
			<div class="photo__others--images flexrow">
			<?php
            // Récupérer les catégories de l'article actuel
            $current_post_id = get_the_ID();
            $current_terms = wp_get_post_terms($current_post_id, 'categorie-acf', array('fields' => 'ids'));

            // Arguments pour WP_Query pour récupérer les articles similaires
            $related_args = array(
                'post_type' => 'photographie',
                'posts_per_page' => 2,
                'post__not_in' => array($current_post_id),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie-acf',
                        'field' => 'term_id',
                        'terms' => $current_terms,
                    ),
                ),
            );

            $related_query = new WP_Query($related_args);

            if ($related_query->have_posts()) : ?>
                <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                    <?php get_template_part('template-parts/post/publication'); ?>
                <?php endwhile; ?>
            <?php else : ?>
                <p>Désolé. Aucun article ne correspond à cette demande.</p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
<?php endwhile; endif; ?>

<?php get_footer();?>
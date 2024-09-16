<<<<<<< HEAD
<?php
/**
 * The single : ATRICLE BLOG 
 *
 * @package WordPress
 * @subpackage nathalie-mota theme
 */

	get_header();
?>

<div id="wrap">
    <section id="content">
		<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
			
		<article class="post">
			<?php 
				// permet d’afficher l’image mise en avant
				the_post_thumbnail(); 
			?>

			<h1><?php the_title(); ?></h1>

			<div class="post__meta">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
				<p>
				Publié le <?php the_date(); ?>
				par <?php the_author(); ?>
				Dans la catégorie <?php the_category(); ?>
				Avec les étiquettes <?php the_tags(); ?>
				</p>
			</div>

			<div class="post__content">
				<?php the_content(); ?>
			</div>
		</article>

		<?php endwhile; endif; ?>

		<p>Navigation</p>
		<div class="site__navigation flexrow">
			<div class="site__navigation__prev">
				<?php previous_post_link( 'Article Précédent<br>%link' ); ?>
			</div>
			<div class="site__navigation__next">
				<?php next_post_link( 'Article Suivant<br>%link' ); ?> 
			</div>
		</div>
    </section>
</div>
<br>
<?php get_footer();?>
=======
<?php get_header(); ?>
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
					get_template_part ( 'template-parts/post/photo-common');
				 ?>
			<button class="btn btn-all-photos" type="button">
				<a href="<?php echo home_url( '/' ); ?>" aria-label="Page d'accueil de Nathalie Mota">Toutes les photos</a>
			</button>
			</div>
		</div>
	</section>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
>>>>>>> ed3b13d57387777ce8bce3ccb2ee10109a204e6d

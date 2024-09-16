<footer id="footer">
		<?php 
			// Affichage du menu footer déclaré dans functions.php
			wp_nav_menu(array('theme_location' => 'footer')); 
		?>		
		<!-- Ajout du widget dans le pied de page -->	
	</footer>

	<!-- Lance la popup contact -->
	<?php 
		get_template_part('templates-parts/modal/lightbox');
        get_template_part ( 'template-parts/modal/contact');
		 ?> 		
    

<?php wp_footer(); ?>

</body>
</html>
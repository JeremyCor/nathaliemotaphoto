<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
	<!-- Récupération sur Fontawesome des icones dont on aura besoin -->
	<script src="https://kit.fontawesome.com/57bf6f7049.js" crossorigin="anonymous"></script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>    
    <header id="header" class="header flexrow">
        <div class="container-header flexrow"> <!-- affichage du logo -->
            <a href="<?php echo home_url( '/' ); ?>" aria-label="Page d'accueil de Nathalie Mota">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Logo.png" 
                alt="Logo <?php echo bloginfo('name'); ?>">
            </a>
            <nav id="contact"> <!-- appel du menu wordpress déclaré dans functions.php -->
				<?php 
					wp_nav_menu(array('theme_location' => 'main'));
				?>
                
                <button id="modal__burger" class="btn-modal" aria-label="Menu pour la version portable">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </button>
				
                <div id="modal__content" class="modal__content">           
					<?php 				
					wp_nav_menu(array('theme_location' => 'main')); 
					?>
                </div>
            </nav>
        </div>
    </header>

    <?php wp_footer(); ?>
</body>
</html>

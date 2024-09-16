<!-- Wrap Slider Area -->
<div class="hero-area">
    <div class="hero-thumbnail">
        <!-- Initialisation de post à afficher -->
        <?php   
            $random_image = get_posts(array(
                'post_type' => 'photographie', 
                'posts_per_page' => 1, 
                'orderby' => 'rand', 
            ));
            
            if ($random_image) {
                $post = $random_image[0];
                $thumbnail_id = get_post_thumbnail_id($post->ID);
                $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'full');
            }          
        ?>
        <div id="home" class="home__hero hero-background" style="background-image: url('<?php echo $thumbnail_url ?>');">
            <h1 class="home__hero__title">Photographe Event</h1>
        </div>
    </div>  
</div>
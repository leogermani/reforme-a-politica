<?php get_header(); ?>

<div class="wrap clearfix">
    <?php get_sidebar(); ?>
    <section id="main-section" class="col-8">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php html::part('loop-propostas'); ?>
            <?php endwhile; ?>				
        <?php else : ?>
            <p><?php _e('Nenhuma proposta aqui', 'reforme'); ?></p>              
        <?php endif; ?>
    </section>
    <!-- #main-section -->	          
</div>

<!-- .wrap --> 
<?php get_footer(); ?>

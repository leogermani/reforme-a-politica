<?php get_header(); ?>

<div class="wrap clearfix">

    <section id="main-section" class="col-12">
        
        <?php 
        $oque = new WP_Query(array(
            'post_type' => 'propostas',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'escopo',
                    'terms' => 'o-que',
                    'field' => 'slug'
                )
            ),
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));
        ?>
        
        
        <div class="col-5 alignleft">
            <h2>O que?</h2>
            
            <?php if ($oque->have_posts()) : while ($oque->have_posts()) : $oque->the_post(); ?>
                <?php html::part('loop-propostas'); ?>
                <?php endwhile; ?>
            <?php else : ?>
                <p><?php _e('Nenhuma proposta aqui', 'reforme'); ?></p>              
            <?php endif; ?>
        </div>
        
        
        
        <?php 
        $como = new WP_Query(array(
            'post_type' => 'propostas',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'escopo',
                    'terms' => 'como',
                    'field' => 'slug'
                )
            ),
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));
        ?>
        
        <div class="col-5 alignleft">
            <h2>Como?</h2>
            <?php if ($como->have_posts()) : while ($como->have_posts()) : $como->the_post(); ?>
                <?php html::part('loop-propostas'); ?>
                <?php endwhile; ?>				
            <?php else : ?>
                <p><?php _e('Nenhuma proposta aqui', 'reforme'); ?></p>              
            <?php endif; ?>
        </div>
        
        
        <?php wp_reset_query(); ?>
        
        
    </section>
    <!-- #main-section -->	          
</div>

<!-- .wrap --> 
<?php get_footer(); ?>

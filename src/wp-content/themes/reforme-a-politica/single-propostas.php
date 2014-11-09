<?php get_header(); ?>
	
    <div class="wrap clearfix">
		<aside id="main-sidebar" class="col-4 clearfix">
            
            <h2>Posicione-se</h2>
            
            <?php dynamic_sidebar('Sidebar'); ?>
        </aside>
		<section id="main-section" class="col-8">			
			<?php if ( have_posts()) : while ( have_posts()) : the_post(); ?>
			
				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix');?>>	  
                    <header>                       
                        <h2><?php the_terms( get_the_ID(), 'tema', '', ', ', '' ); ?></h2>
                        <h1><a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h1>					
                        <p>
                            <a class="comments-number" href="<?php comments_link(); ?>"title="<?php _e('comments', 'reforme'); ?>"><?php comments_number('0 comentários','1 comentário','% comentários');?></a>
                            
                            <?php edit_post_link( __( 'Edit', 'reforme' ), '| ', '' ); ?>
                        </p>
                    </header>
                    <div class="post-content clearfix">    
                        <?php if ( has_post_thumbnail() ) : ?> 
                          <?php the_post_thumbnail(); ?>				 
                        <?php endif; ?>
                        <?php the_content(); ?>
                    </div>
                    <!-- .post-content -->
                    
                    <?php comments_template(); ?>

                </article>
                <!-- .post -->

			<?php endwhile; ?>
                        
			<?php else : ?>
			   <p><?php _e('Nenhuma proposta aqui.', 'reforme'); ?></p>              
			<?php endif; ?>
		</section>
		<!-- #main-section -->	          
    </div>
    <!-- .wrap --> 
    
    
<?php get_footer(); ?>

<?php

// Dẽ um Find & Replace (CASE SENSITIVE!) em tema Pelo nome da sua taxonomia

class tema {
    const NAME = 'temas';

    /**
     * slug da taxonomia: deve conter somente minúscula 
     * @var unknown_type
     */
    protected static $taxonomy;
    protected static $post_types;
    
    static function init(){
        // o slug da taxonomia
        self::$taxonomy = strtolower(__CLASS__);
        
        // Coloque aqui o slug dos post types aos quais essa taxonomia vai se aplicar
        self::$post_types = array ( 'propostas' );
        
        add_action( 'init', array(self::$taxonomy, 'register') ,0);

    }
    
    static function register(){
    	
        $labels = array(
            'name' => _x( 'temas', 'taxonomy general name', 'reforme' ),
            'singular_name' => _x( 'tema', 'taxonomy singular name', 'reforme' ),
            'search_items' =>  __( 'Buscar temas', 'reforme' ),
            'all_items' => __( 'Todos os temas', 'reforme' ),
            'parent_item' => __( 'tema pai', 'reforme' ),
            'parent_item_colon' => __( 'tema pai:', 'reforme' ),
            'edit_item' => __( 'Editar tema', 'reforme' ), 
            'update_item' => __( 'Atualizar tema', 'reforme' ),
            'add_new_item' => __( 'Adicionar novo tema', 'reforme' ),
            'new_item_name' => __( 'Nome do novo tema', 'reforme' ),
        ); 	

        register_taxonomy(self::$taxonomy,self::$post_types, array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => true,
            )
        );
    }
  
}

tema::init();

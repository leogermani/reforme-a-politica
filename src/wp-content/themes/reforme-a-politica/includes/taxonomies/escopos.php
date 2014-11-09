<?php

// Dẽ um Find & Replace (CASE SENSITIVE!) em escopo Pelo nome da sua taxonomia

class escopo {
    const NAME = 'escopos';

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
            'name' => _x( 'escopos', 'taxonomy general name', 'reforme' ),
            'singular_name' => _x( 'escopo', 'taxonomy singular name', 'reforme' ),
            'search_items' =>  __( 'Buscar escopos', 'reforme' ),
            'all_items' => __( 'Todos os escopos', 'reforme' ),
            'parent_item' => __( 'escopo pai', 'reforme' ),
            'parent_item_colon' => __( 'escopo pai:', 'reforme' ),
            'edit_item' => __( 'Editar escopo', 'reforme' ), 
            'update_item' => __( 'Atualizar escopo', 'reforme' ),
            'add_new_item' => __( 'Adicionar novo escopo', 'reforme' ),
            'new_item_name' => __( 'Nome do novo escopo', 'reforme' ),
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

escopo::init();

<?php
// Dê um Find Replace (CASE SENSITIVE!) em proposta pelo nome do seu post type 

class propostas
{
    const NAME = 'Propostas';
    const MENU_NAME = 'proposta';

    /**
     * alug do post type: deve conter somente minúscula 
     * @var string
     */
    protected static $post_type;

    static function init()
    {
        // o slug do post type
        self::$post_type = strtolower(__CLASS__);

        add_action('init', array(self::$post_type, 'register'), 0);

        //add_filter('menu_order', array(self::$post_type, 'change_menu_label'));
        //add_filter('custom_menu_order', array(self::$post_type, 'custom_menu_order'));
        //add_action('save_post',array(__CLASS__, 'on_save'));
    }

    static function register()
    {
        register_post_type(self::$post_type, array(
            'labels' => array(
                'name' => _x(self::NAME, 'post type general name', 'reforme'),
                'singular_name' => _x('proposta', 'post type singular name', 'reforme'),
                'add_new' => _x('Adicionar Nova', 'image', 'reforme'),
                'add_new_item' => __('Adicionar nova proposta', 'reforme'),
                'edit_item' => __('Editar proposta', 'reforme'),
                'new_item' => __('Nova proposta', 'reforme'),
                'view_item' => __('Ver proposta', 'reforme'),
                'search_items' => __('Buscar propostas', 'reforme'),
                'not_found' => __('Nenhuma proposta Encontrado', 'reforme'),
                'not_found_in_trash' => __('Nenhuma proposta na Lixeira', 'reforme'),
                'parent_item_colon' => ''
            ),
            'public' => true,
            'rewrite' => array('slug' => 'propostas'),
            'capability_type' => 'post',
            'hierarchical' => true,
            'map_meta_cap ' => true,
            'menu_position' => 6,
            'has_archive' => true, //se precisar de arquivo
            'supports' => array(
                'title',
                'editor',
                'page-attributes',
                'thumbnail'
            ),
            //'taxonomies' => array('taxonomia')
            )
        );
    }

    static function change_menu_label($stuff)
    {
        global $menu, $submenu;
        foreach ($menu as $i => $mi) {
            if ($mi[0] == self::NAME) {
                $menu[$i][0] = self::MENU_NAME;
            }
        }
        return $stuff;
    }

    static function custom_menu_order()
    {
        return true;
    }

    /**
     * Chamado pelo hook save_post
     * @param int $post_id
     * @param object $post
     */
    static function on_save($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        global $post;

        if ($post->post_type == self::$post_type) {
            // faça algo com o post 
        }
    }

}
propostas::init();

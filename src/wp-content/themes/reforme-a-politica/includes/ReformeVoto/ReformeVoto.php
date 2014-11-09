<?php
/**
 * Classe para tratar o esquema de votos
 *
 * @author leogermani
 */

class ReformeVoto {
    
    static function init() {
        
        add_action('wp_ajax_reforme_voto', array(__CLASS__, 'handleAjax'));
        add_action('wp_print_scripts', array(__CLASS__, 'addJS'));
    
    }
    
    static function addJS() {
        wp_enqueue_script('reforme-voto', get_stylesheet_directory_uri().'/includes/ReformeVoto/reforme-voto.js', array('jquery', 'congelado'));
    }
    
    static function theLink($post_id) {
        echo self::get_theLink($post_id);
    }
    
    static function get_theLink($post_id) {
        
        $r = '<span class="reforme-voto-container">'; 
        
        $curVote = self::getCurrentUserVoteForPost($post_id);

        if (!current_user_can('read')) {
            $r .= '<a class="reforme-voto votar" href="' . wp_login_url( get_permalink($post_id) ) . '">APOIAR!</a>';
        } elseif ($curVote === true) {
            $r .= 'APOIADO! <a class="reforme-voto desfazer" data-action="unvote" data-post_id="' . $post_id . '">(Desfazer)</a>';
        } elseif ($curVote === false) {
            $r .= '<a class="reforme-voto votar" data-action="vote"  data-post_id="' . $post_id . '">APOIAR!</a>';
        } elseif (is_int($curVote)) {
            $title = get_the_title($curVote);
            $link = get_permalink($curVote);
            $r .= 'Você já apoiou uma proposta que exclui essa: <a href="' . $link . '">' . $title . '</a> <a class="reforme-voto desfazer" data-action="unvote" data-post_id="' . $curVote . '" data-return_post_id="' . $post_id . '">(Desfazer)</a>';
        }
        
        $r .= '</span>';
        
        return $r;
        
    }
    
    static function getCurrentUserVoteForPost($post_id) {
        $cur_user = wp_get_current_user();
        return self::getUserVoteForPost($cur_user->ID, $post_id);
    }
    
    /**
    * get the vote a user has given for a post
    * @param int $user_id ID of the user
    * @param int $post_id ID of the post
    * @return bool|int true if user has chosen this post, false if user has not chosen this post, INT if user already chosed another posts that excludes this one 
    */
    static function getUserVoteForPost($user_id, $post_id) {
        global $wpdb;

        if ( $wpdb->get_var( $wpdb->prepare("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = %d AND meta_key = 'vote_proposta' AND meta_value = %d", $user_id, $post_id) ) ) {
            return true;
        }
        
        $excludentPosts = self::getExcludentPosts($post_id);
        
        if ($excludentPosts && is_array($excludentPosts)) {
            if ( $excludent_id = $wpdb->get_var( "SELECT meta_value FROM $wpdb->usermeta WHERE user_id = $user_id AND meta_key = 'vote_proposta' AND meta_value IN (".implode(',', $excludentPosts).")" ) ) {
                return (int) $excludent_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    static function getExcludentPosts($post_id) {
        //check if post is part of a group
        $group = get_post_meta($post_id, '_grupo_excludente', true);
        if (!$group)
            return false;
        
        global $wpdb;
        return $wpdb->get_col( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_grupo_excludente' AND meta_value = %s", $group) );
    }
    
    
    static function handleAjax() {
        
        $post_id = $_POST['post_id'];
        $return_post_id = isset($_POST['return_post_id']) && is_numeric($_POST['return_post_id']) ? $_POST['return_post_id'] : false;
        $msg = '';
        
        switch ($_POST['reforme_action']) {
        
            case ('vote'):
                if (self::getCurrentUserVoteForPost($post_id) === false) {
                    self::vote($post_id);
                    $msg = 'Proposta Apoiada!';
                } else {
                    $msg = 'Não foi possível apoiar proposta';
                }
                break;
            case ('unvote'):
                self::unvote($post_id);
                $msg = 'Você não apoia mais essa proposta!';
                break;
        
        }
        
        echo json_encode(array(
            'msg' => $msg,
            'html' => self::get_theLink( $return_post_id ? $return_post_id : $post_id )
        ));
        
        die;
    
    }
    
    static function vote($post_id, $user_id = null) {
        
        if (is_null($user_id)) {
            $cur_user = wp_get_current_user();
            $user_id = $cur_user->ID;
        }
        
        delete_user_meta($user_id, 'vote_proposta', $post_id);
        add_user_meta($user_id, 'vote_proposta', $post_id);
        
    }
    
    static function unvote($post_id, $user_id = null) {
        
        if (is_null($user_id)) {
            $cur_user = wp_get_current_user();
            $user_id = $cur_user->ID;
        }
        
        delete_user_meta($user_id, 'vote_proposta', $post_id);
        
    }
    
    
}   

ReformeVoto::init();

?>

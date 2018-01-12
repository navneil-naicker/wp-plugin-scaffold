<?php
/*
Plugin Name: WordPress Plugin Example
Plugin URI: hhttp://www.navz.me
Description: A starter plugin example for WordPress
Version: 1.0.0
Author: Navneil Naicker
Author URI: http://www.navz.me
*/

class wp_plugin_example{

    public $plugin_name = 'WP Plugin';
    public $plugin_slug = 'wp-plugin-example';
    public $plugin_admin_url;
    public $plugin_dir_path;
    public $plugin_dir_url;
    public $view;
    public $title;

    public function __construct(){
        $this->plugin_slug = basename(dirname(__FILE__));
        $this->plugin_dir_path = plugin_dir_path( __FILE__ );
        $this->plugin_dir_url = plugin_dir_url( __FILE__ );
        
        add_action( 'admin_menu', array($this, 'add_menu_page') );
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_css_js' ));

    }

    public function add_menu_page(){
        //add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null );
        add_menu_page(__( $this->plugin_name, 'textdomain' ), $this->plugin_name, 'manage_options', $this->plugin_slug, array($this, 'router'), 'dashicons-image-crop', 80);
        //After the admin menu is registered, get the admin url link dynamically
        $this->plugin_admin_url = menu_page_url($this->plugin_slug, false);
    }

    public function router(){
        require_once( $this->plugin_dir_path . '/templates/default.php' );
    }

    function enqueue_css_js( $hook ){
        if( $hook != 'toplevel_page_wp-plugin-example'){ return; }
        //https://developer.wordpress.org/reference/functions/wp_enqueue_style/
        wp_enqueue_style( 'wp-plugin-example-css', $this->plugin_dir_url . '/css/wp-plugin-example.css');
        //https://developer.wordpress.org/reference/functions/wp_enqueue_script/
        wp_enqueue_script( 'wp-plugin-example-js', $this->plugin_dir_url . '/js/wp-plugin-example.js', array('jquery'), '1.0', true);
    }


}

new wp_plugin_example;
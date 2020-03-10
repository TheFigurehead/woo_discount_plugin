<?php

class Woo_sales_Visit{

    public function __construct(){
        $this->show_message = false;
    }

    public function setup(){

        if( !isset($_COOKIE['woo_addon_visit']) || $_COOKIE['woo_addon_visit'] == false ) {
            setcookie(
                'woo_addon_visit',
                time() + get_option('wc_settings_woo_sales_comming_back_timing'),
                strtotime("tomorrow"),
                COOKIEPATH, COOKIE_DOMAIN
            );
        }

        if( isset($_COOKIE['woo_addon_visit']) && $_COOKIE['woo_addon_visit'] <= time() ){
            setcookie(
                'woo_addon_discount', 
                true, 
                strtotime("tomorrow"),
                COOKIEPATH, COOKIE_DOMAIN
            );
            setcookie(
                'woo_addon_visit',
                false,
                strtotime("tomorrow"),
                COOKIEPATH, COOKIE_DOMAIN
            );
            $this->show_message = (!is_user_logged_in()) ? true : false;
        }


    }

    public function add_message(){
        if($this->show_message){
            Woo_sales_Public::insert_discount_message();
        }
    }

    public static function start_session(){
        if(!isset($_SESSION)){
            session_start();
        }
    }

    public static function check_user_discount(){
        if( isset($_COOKIE['woo_addon_discount']) && $_COOKIE['woo_addon_discount'] == true ){
            return true;
        }
        return false;
    }

    public static function set_staying_discount(){

        self::start_session();

        $_SESSION['woo_addon_user_stayed'] = true;

    }

    public static function refuse_staying_discount(){

        self::start_session();

        $_SESSION['woo_addon_user_stayed'] = false;

    }

    
    public static function check_user_stayed(){

        self::start_session();

        if( isset($_SESSION['woo_addon_user_stayed']) && $_SESSION['woo_addon_user_stayed'] == true ){

            return 1;

        }elseif( isset($_SESSION['woo_addon_user_stayed']) && $_SESSION['woo_addon_user_stayed'] == false ){
            return 2;
        }

        return 0;

    }

}
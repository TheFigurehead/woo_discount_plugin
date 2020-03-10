<?php

class Woo_sales_Discount{

    public function add_user_discounts( WC_Cart $cart ){

        $subtotal = $cart->get_subtotal();

        //if with coupons

        if( get_option('wc_settings_woo_sales_with_coupons') === 'yes'){
            $coupons_total = array_reduce($cart->get_coupon_discount_totals(), function($total, $item){
                return $total + $item;
            });
            $subtotal -= $coupons_total;
        }

        $discounts = $this->calculate_discount();

        foreach($discounts as $discount){
            $amount = ( $subtotal / 100 ) * $discount['amount'];
            $cart->add_fee( $discount['label'], -$amount);
        }
    
    }

    private function calculate_discount(){

        $discounts = [];

        if(is_user_logged_in()){
            $registered_discount = self::get_discount_amount();
            $discounts[] = [
                'label' => sprintf('Registered user discount (-%s)', $registered_discount . '%'),
                'amount' => $registered_discount
            ];
        }

        if( !is_user_logged_in() && Woo_sales_Visit::check_user_discount() ){
            $comming_back_discount = self::get_discount_amount('comming_back_discount');
            $discounts[] = [
                'label' => sprintf('Comming back discount (-%s)', $comming_back_discount . '%'),
                'amount' => $comming_back_discount
            ];
        }

        if( Woo_sales_Visit::check_user_stayed() == 1 ){
            $returning_discount = self::get_discount_amount('returning_discount');
            $discounts[] = [
                'label' => sprintf('Thanks for staying with us (-%s)', $returning_discount . '%'),
                'amount' => $returning_discount
            ];
        }

        return $discounts;

    }

    public static function get_discount_amount($name = 'registered_discount'){
        $defaults = [
            'registered_discount' => 10,
            'comming_back_discount' => 5,
            'returning_discount' => 3
        ];
        return (get_option('wc_settings_woo_sales_' . $name )) ? get_option('wc_settings_woo_sales_' . $name) : $defaults[$name];
    }

    public function get_staying_discount(){
        Woo_sales_Visit::set_staying_discount();
	    wp_die();
    }

    public function refuse_staying_discount(){
        Woo_sales_Visit::refuse_staying_discount();
	    wp_die();
    }

}
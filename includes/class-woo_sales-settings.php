<?php 

class Woo_sales_Settings{

    public function add_settings_tab(){
        $settings_tabs[ Woo_sales::PLUGIN_NAME ] = __( 'Woo Sales Discount', 'woocommerce-settings-' . Woo_sales::PLUGIN_NAME );
        return $settings_tabs;
    }

    // public function add_settings_tab_content(){
    //     echo "settings";
    // }

    public function add_settings_tab_content() {
        woocommerce_admin_fields( $this->get_settings() );
    }
    
    public function get_settings() {
        $settings = array(
            'section_title' => array(
                'name'     => __( 'Section Title', 'woocommerce-settings-tab-demo' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'wc_settings_woo_sales_section_title'
            ),
            'registered_user' => array(
                'name' => __( 'Registered user discount', 'woocommerce-settings-tab-demo' ),
                'type' => 'number',
                'custom_attributes' => [
                    'max' => 100,
                    'min' => 0
                ],
                'desc' => __( 'The discount every registered user gets.', 'woocommerce-settings-tab-demo' ),
                'id'   => 'wc_settings_woo_sales_registered_discount',
                'default' => 10
            ),
            'comming_back' => array(
                'name' => __( 'Comming back discount', 'woocommerce-settings-tab-demo' ),
                'type' => 'number',
                'custom_attributes' => [
                    'max' => 100,
                    'min' => 0
                ],
                'desc' => __( 'The discount for the user who visited the site today and came back.', 'woocommerce-settings-tab-demo' ),
                'id'   => 'wc_settings_woo_sales_comming_back_discount',
                'default' => 5
            ),
            'staying' => array(
                'name' => __( 'Staying with us discount', 'woocommerce-settings-tab-demo' ),
                'type' => 'number',
                'custom_attributes' => [
                    'max' => 100,
                    'min' => 0
                ],
                'desc' => __( 'The discount for the user who decided not to leave the site and get his discount.', 'woocommerce-settings-tab-demo' ),
                'id'   => 'wc_settings_woo_sales_returning_discount',
                'default' => 3
            ),
            'with_coupons' => array(
                'name' => __( 'Implement the discount with coupons', 'woocommerce-settings-tab-demo' ),
                'type' => 'checkbox',
                'desc' => __( 'If false the discount will be subtracted from the total order price without including coupons dicount.', 'woocommerce-settings-tab-demo' ),
                'id'   => 'wc_settings_woo_sales_with_coupons',
                'default' => 'yes', 
            ),
            'comming_back_timing' => array(
                'name' => __( 'Comming back timing (in seconds)', 'woocommerce-settings-tab-demo' ),
                'type' => 'number',
                'desc' => __( 'The time after what the user should come back to be marked as Came back user and get his discount. (when to think that user came to the site twice).', 'woocommerce-settings-tab-demo' ),
                'id'   => 'wc_settings_woo_sales_comming_back_timing',
                'default' => 3600
            ),
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_woo_sales_section_end'
            )
        );
        return apply_filters( 'wc_settings_tab_' . Woo_sales::PLUGIN_NAME , $settings );
    }

    public function update_settings(){
        woocommerce_update_options( $this->get_settings() );
    }

}
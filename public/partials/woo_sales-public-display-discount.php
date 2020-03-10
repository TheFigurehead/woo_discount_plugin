<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.linkedin.com/in/shkapenko-oleksii/
 * @since      1.0.0
 *
 * @package    Woo_sales
 * @subpackage Woo_sales/public/partials
 */
?>


<div class="coming_back_discount">
    <span> You got <?=Woo_sales_Discount::get_discount_amount('comming_back_discount')?>% discount! <a href="<?=get_permalink( woocommerce_get_page_id( 'shop' ) )?>"> Go to shop </a> </span>
    <span class="woo_addon_close">x</span>
</div>
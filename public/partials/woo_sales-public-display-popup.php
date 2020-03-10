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

<div id="woo_addon_popup" class="woo_addon_popup__wrapper">
  <div class="woo_addon_popup__container">
    <h1 class="woo_addon_popup__title">Dont leave us!</h1>
    <h2>And get <?=Woo_sales_Discount::get_discount_amount('returning_discount')?>% discount now!</h2>
    <p>Have a wonderful day 💁</p>
    <button id="woo_addon_popup__refuse">No, thanks</button>
    <button id="woo_addon_popup__sure">Get my discount now!</button>
  </div>
</div>
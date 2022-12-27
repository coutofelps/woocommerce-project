<?php

/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package MercadoPago
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="mp-card-info">
	<div class="<?php echo esc_html($settings['value']['color_card']); ?>"></div>
	<div class="mp-card-body-payments <?php echo esc_html($settings['value']['size_card']); ?>">
		<div class="<?php echo esc_html($settings['value']['icon']); ?>"></div>
		<div>
			<span class="mp-text-title"><b><?php echo esc_html($settings['value']['title']); ?></b></span>
			<span class="mp-text-subtitle"><?php echo wp_kses($settings['value']['subtitle'], 'b'); ?></span>
			<a class="mp-button-payments-a" target="<?php echo esc_html($settings['value']['target']); ?>" href="<?php echo esc_html($settings['value']['button_url']); ?>"><button type="button" class="mp-button-payments"><?php echo esc_html($settings['value']['button_text']); ?></button></a>
		</div>
	</div>
</div>

<?php if ( ! \defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<h2><?php \esc_html_e( 'Installment Calculator', 'wc-installment-calculator' ); ?></h2>
<?php
	\wp_nonce_field( 'wc-installment-calculator-nonce', 'wc-installment-calculator-field' );

	\woocommerce_wp_checkbox([
		'id'			=> '_wc_icalculator_enable',
		'label'			=> \esc_html__( 'Enable Installment Calculator', 'wc-installment-calculator' ),
		'description'	=> \esc_html__( 'Enable the installment calculator for this product.', 'wc-installment-calculator' ),
		'value'			=> $is_new ? 'yes' : $enable,
	]);
?>

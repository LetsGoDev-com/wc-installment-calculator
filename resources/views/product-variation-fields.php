<?php if ( ! \defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<p class="form-field" style="font-size: 14px; padding: 8px 0; line-height: 1.4; font-weight: 500; clear: both;">
	<?php \esc_html_e( 'Installment Calculator', 'wc-installment-calculator' ); ?>
</p>

<?php

    \wp_nonce_field( 'wc-installment-calculator-nonce', 'wc-installment-calculator-field' );

	\woocommerce_wp_checkbox([
		'id'			    => \sprintf( '_wc_icalculator_enable_%d', $loop ),
		'class'			    => 'checkbox _wc_icalculator_enable_loop',
		'name'			    => \sprintf( '_wc_icalculator_enable[%s]', $loop ),
		'label'			    => \esc_html__( 'Installment Calculator', 'wc-installment-calculator' ),
		'desc_tip'		    => true,
		'custom_attributes'	=> [ 'data-loop' => $loop ],
		'description'	    => \esc_html__( 'Enable installment calculator for this variation.', 'wc-installment-calculator' ),
		'value'			    => $is_new ? 'yes' : $enable,
	]);
?>

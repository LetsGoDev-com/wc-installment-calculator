<?php
namespace iCalculator;


/**
 * Get settings
 * @param string $key
 * @param mixed $default
 * @param string $option
 * @return mixed
 */
function getSettings( string $key = '', mixed $default = false, string $option = 'wc_icalculator' ): mixed {
	
	$key     = \sanitize_key( $key );
	$options = \get_option( $option, false );
	
	return \apply_filters('icalculator/helpers/settings', $options[ $key ] ?? $default );
}


/**
 * Get installment calculator
 * @param \WC_Product $product
 * @return array
 */
function getInstallmentCalculator( \WC_Product $product ): array {

	$enable = \get_post_meta( $product->get_id(), '_wc_icalculator_enable', true );

	if ( empty( $enable ) || $enable === 'no' ) {
		return [];
	}

	$rules = getSettings( 'rules', [] );

	if ( empty( $rules ) || empty( $rules[0]['items'] ) ) {
		return [];
	}

	$items = [];

	foreach ( $rules[0]['items'] as $rule ) {
		$items[] = \str_replace( [
				'%price%', '%number%', '%surcharge%', '%subtotal%'
			], [
				$product->get_price(),
				$rule['number'],
				$rule['surcharge'],
				\wc_price( ( \floatval( $product->get_price() ) + ( floatval( $product->get_price() ) * \floatval( $rule['surcharge'] ) / 100 ) ) / \floatval( $rule['number'] ) )
			],
			$rule['content']
		);
	}

	return [
		'subtitle' => $rules[0]['subtitle'] ?? '',
		'items'    => $items,
	];
}
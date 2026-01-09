<?php
namespace iCalculator\Controllers;

use iCalculator\Traits\Singleton;

class LinksController {
    use Singleton;

    public function __construct() {
        \add_filter( 'plugin_row_meta', [ $this, 'pluginInfo' ], 10, 2 );
		\add_filter( 'plugin_action_links_' . ICALCULATOR_BASE, [ $this, 'pluginActionLinks' ] );
    }

    /**
	 * Plugin Action Links
	 * @param  array  $links
	 * @return array
	 */
	public function pluginActionLinks( array $links = [] ): array {
		$settings = [
			'settings' => \sprintf('<a href="%s">%s</a>',
				\admin_url('admin.php?page=wc-settings&tab=wc_installment_calculator'),
				\esc_html__( 'Settings', 'wc-installment-calculator' )
			),
		];

		return \array_merge( $links, $settings );
	}

    /**
	 * Plugin Info
	 * @param  array  $links
	 * @param  string $file
	 * @return array
	 */
	public function pluginInfo( array $links = [], string $file = '' ) {

		if( $file != 'wc-installment-calculator/wc-installment-calculator.php' ) {
			return $links;
		}

		$newLinks = [
			'premium' => sprintf(
				'<a href="%s" target="_blank" title="%s">%s</a>',
				\esc_url( 'https://www.letsgodev.com/product/woocommerce-installment-calculator-pro/' ),
				\esc_html__( 'WC Installment Calculator PRO', 'wc-installment-calculator' ),
				\esc_html__( 'WC Installment Calculator PRO', 'wc-installment-calculator' )
			),
		];

		return \array_merge( $links, $newLinks );
	}
}
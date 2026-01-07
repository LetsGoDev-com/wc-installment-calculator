<?php
Namespace iCalculator\Controllers;

use iCalculator\Traits\Singleton;
use Automattic\WooCommerce\Utilities\FeaturesUtil;
use Automattic\WooCommerce\Utilities\OrderUtil;
use Automattic\WooCommerce\Internal\DataStores\Orders\OrdersTableDataStore;


class HPOSController {
	use Singleton;


	/**
	 * Construct
	 */
	public function __construct() {
		\add_action( 'before_woocommerce_init', [ $this, 'declareCompatibilty' ] );
	}

	/**
	 * Declare compatibility
	 * @return void
	 */
	public function declareCompatibilty(): void {
		if ( \class_exists( FeaturesUtil::class ) ) {
			FeaturesUtil::declare_compatibility( 'custom_order_tables', ICALCULATOR_FILE, true );
		}
	}

	/**
	 * Check if HPOS is enabled
	 * @return boolean
	 */
	public function isEnabled(): bool {
		return OrderUtil::custom_orders_table_usage_is_enabled();
	}

	/**
	 * Get meta order table
	 * @return string
	 */
	public function getMetaOrder(): string {
		return OrdersTableDataStore::get_meta_table_name();
	}
}
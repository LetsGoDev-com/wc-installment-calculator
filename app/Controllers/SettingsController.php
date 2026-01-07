<?php
namespace iCalculator\Controllers;

use iCalculator\Traits\Singleton;

use function iCalculator\getSettings;

/**
 * SettingsController
 *
 * @package   iCalculator\Controllers
 * @author    Alex Gonzales <support@letsgodev.com>
 * @copyright 2020 Linsila LLC
 * @license   GPL 2.0+
 * @link      https://www.letsgodev.com
 */

class SettingsController {
	use Singleton;

	public function __construct() {
		
		// Add WC Class Tab
		\add_filter( 'woocommerce_get_settings_pages', [ $this, 'loadSettings' ] );

		// Enqueue styles
		\add_action( 'admin_enqueue_scripts', [ $this, 'enqueueStyles' ] );
		\add_action( 'admin_enqueue_scripts', [ $this, 'enqueueScripts' ] );

		// Add new field - Rules
		\add_action( 'woocommerce_admin_field_wc_icalculator_rules', [ $this, 'rulesField' ] );

		// Add new field - Shop page
		\add_action( 'woocommerce_admin_field_wc_icalculator_shop', [ $this, 'shopField' ] );

		// Add new field - Designs with radio buttons
		\add_action( 'woocommerce_admin_field_wc_icalculator_design_product_page', [ $this, 'designsField' ] );

		// Add new field - Disable Installment Calculator
		\add_action( 'woocommerce_admin_field_wc_icalculator_disable_installment', [ $this, 'disableInstallment' ] );

		// Add new field - Enable Installment Calculator
		\add_action( 'woocommerce_admin_field_wc_icalculator_enable_installment', [ $this, 'enableInstallment' ] );

		// Sanitize options
		\add_filter( 'woocommerce_admin_settings_sanitize_option_wc_icalculator', [ $this, 'sanitizeOptions' ], 10, 3 );
	}


	/**
	 * Add WC Class Tab
	 * @param  array  $settings
	 * @return mixed
	 */
	public function loadSettings( array $settings ): array {

		$settings[] = include ICALCULATOR_DIR . 'app/Settings/WCSettings.php';

		return $settings;
	}


	/**
	 * Enqueue styles
	 * @return void
	 */
	public function enqueueStyles( string $screen ): void {

		// @codingStandardsIgnoreLine
		if ( $screen !== 'woocommerce_page_wc-settings' || ! isset( $_GET['tab'] ) || $_GET['tab'] !== 'wc_installment_calculator' ) {
			return;
		}

		\wp_enqueue_style( 'wc-icalculator-settings', ICALCULATOR_URL . 'resources/assets/styles/settings.css', [], '1.0.0' );
	}

	/**
	 * Enqueue scripts
	 * @return void
	 */
	public function enqueueScripts( string $screen ): void {

		// @codingStandardsIgnoreLine
		if ( $screen !== 'woocommerce_page_wc-settings' || ! isset( $_GET['tab'] ) || $_GET['tab'] !== 'wc_installment_calculator' ) {
			return;
		}

		if ( \has_action( 'icalculator/settings/enqueue_scripts' ) ) {
			\do_action( 'icalculator/settings/enqueue_scripts' );
			return;
		}

		\wp_enqueue_script( 'icalculator-settings', ICALCULATOR_URL . 'resources/assets/scripts/settings.js', [], '1.0.0', true );

		\wp_localize_script( 'icalculator-settings', 'icalculator_settings', [
			/* translators: %number% - number of installments, %subtotal% - subtotal of the installment */
            'installment_content_product' => \esc_html__('%number% installments of %subtotal%', 'wc-installment-calculator'),
		] );
	}


	/**
	 * Sanitize options before saving
	 *
	 * @param mixed $value     The sanitized value.
	 * @param array $option    Option array.
	 * @param mixed $rawValue  Raw value from POST.
	 * @return mixed Sanitized value.
	 */
	public function sanitizeOptions( mixed $value, array $option, mixed $rawValue ): mixed {
		
		// Process rules if they exist
		if ( $option['type'] === 'wc_icalculator_rules' && \is_array( $value ) ) {
			$sanitizedRules = [];

			// Process each rule and reindex sequentially
			foreach ( $value as $rule ) {
				if ( ! \is_array( $rule ) ) {
					continue;
				}

				// Sanitize and filter items - always store sequentially
				$sanitizedItems = [];
				
				if ( ! empty( $rule['items'] ) ) {
					foreach ( $rule['items'] as $item ) {
						if ( ! \is_array( $item ) || empty( $item ) ) {
							continue;
						}

						if ( empty( $item['number'] ) || empty( $item['content'] ) ) {
							continue;
						}

						// Always append to array to ensure sequential indices
						$sanitizedItems[] = [
							'number'    => \absint( $item['number'] ),
							'surcharge' => \floatval( $item['surcharge'] ),
							'content'   => \sanitize_text_field( \trim( $item['content'] ) ),
						];
					}
				}

				$sanitizedRules[] = [
					'subtitle' => \sanitize_text_field( $rule['subtitle'] ),
					'items'    => $sanitizedItems,
				];
			}

			// Store rules with sequential indices
			$value = $sanitizedRules;
		}

		return \apply_filters( 'icalculator/settings/sanitize_options', $value, $option, $rawValue );
	}


	/**
	 * Rules Fields
	 * @param  array  $args
	 * @return html
	 */
	public function rulesField( array $args = [] ): void {

		$args = [
			'id'           => $args['id'] ?? '',
			'title'        => $args['title'] ?? '',
			'tooltip_html' => $args['tooltip_html'] ?? '',
			'rules'        => getSettings( 'rules', [] ),
		];

		if ( \has_action( 'icalculator/settings/rules_field' ) ) {
			\do_action( 'icalculator/settings/rules_field', $args );
			return;
		}

		\wc_get_template(
			'resources/views/settings-rules.php',
			$args,
			false,
			ICALCULATOR_DIR
		);
	}


	/**
	 * Shop page Fields
	 * @param  array  $args
	 * @return html
	 */
	public function shopField( array $args = [] ): void {

		$args = [
			'id'           => $args['id'] ?? '',
			'title'        => $args['title'] ?? '',
			'tooltip_html' => $args['tooltip_html'] ?? '',
			'shop'         => getSettings( 'shop', [] ),
			'rules'        => getSettings( 'rules', [] ),
		];

		if ( \has_action( 'icalculator/settings/shop_field' ) ) {
			\do_action( 'icalculator/settings/shop_field', $args );
			return;
		}

		\wc_get_template(
			'resources/views/settings-shop.php',
			$args,
			false,
			ICALCULATOR_DIR
		);
	}

	/**
	 * Designs Fields
	 * @param  array  $args
	 * @return html
	 */
	public function designsField( array $args = [] ): void {

		$args = \apply_filters( 'icalculator/settings/designs_field_args', [
			'id'           => $args['id'] ?? '',
			'title'        => $args['title'] ?? '',
			'tooltip_html' => $args['tooltip_html'] ?? '',
			'desc'         => $args['description'] ?? '',
			'disabled'     => true,
			'design'       => getSettings( 'design_product_page', 1 ),
		] );
		
		\wc_get_template(
			'resources/views/settings-designs.php',
			$args,
			false,
			ICALCULATOR_DIR
		);
	}


	/**
	 * Disable Installment Calculator
	 * @param  array  $args
	 * @return void
	 */
	public function disableInstallment( array $args = [] ): void {

		$args = \apply_filters( 'icalculator/settings/disable_button_args', [
			'id'           => $args['id'] ?? '',
			'title'        => $args['title'] ?? '',
			'tooltip_html' => $args['tooltip_html'] ?? '',
			'desc'         => $args['description'] ?? '',
			'disabled'     => true,
		] );
		
		\wc_get_template(
			'resources/views/settings-button-disable.php',
			$args,
			false,
			ICALCULATOR_DIR
		);
	}


	/**
	 * Enable Dynamic Pricing
	 * @param  array  $args
	 * @return void
	 */
	public function enableInstallment( array $args = [] ): void {

		$args = \apply_filters( 'icalculator/settings/enable_button_args', [
			'id'           => $args['id'] ?? '',
			'title'        => $args['title'] ?? '',
			'tooltip_html' => $args['tooltip_html'] ?? '',
			'desc'         => $args['description'] ?? '',
			'disabled'     => true,
		] );
		
		\wc_get_template(
			'resources/views/settings-button-enable.php',
			$args,
			false,
			ICALCULATOR_DIR
		);
	}

}

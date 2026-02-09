<?php

namespace iCalculator\Controllers;

use iCalculator\Traits\Singleton;

use function iCalculator\getInstallmentCalculator;
use function iCalculator\getSettings;

class ProductController {
	use Singleton;

	public function __construct() {
		// FrontEnd
		\add_action('wp_enqueue_scripts', [ $this, 'enqueueStyles' ]);
		\add_action('wp_enqueue_scripts', [ $this, 'enqueueScripts' ]);
		\add_action('woocommerce_single_product_summary', [ $this, 'productDisplay' ], 15);

		// WP-Admin
		// Enable Installment Calculator
		\add_action( 'woocommerce_product_options_pricing', [ $this, 'productSimpleFields' ] );

		// Meta prices save - Simple Product
		\add_action( 'woocommerce_admin_process_product_object', [ $this, 'saveProductSimpleFields' ] );

		// Meta prices on the backend product - Variation
		\add_action( 'woocommerce_variation_options_pricing', [ $this, 'productVariationFields' ], 10, 3 );

		// Meta prices save - Variation
		\add_action( 'woocommerce_save_product_variation', [ $this, 'saveProductVariationFields' ], 10, 2 );

		// Installments on variations
		\add_filter( 'woocommerce_available_variation', [ $this, 'productVariationDisplay' ], 10, 3 );
	}

	/**
	 * Enqueue styles
	 * @return void
	 */
	public function enqueueStyles() {
		if ( ! is_product() ) {
			return;
		}

		$allowedDesigns = [ 1 ];
		$designID = getSettings( 'design_product_page', 1 );
		
		if ( \in_array( $designID, $allowedDesigns ) ) {
			$designPath = \sprintf( 'resources/assets/styles/design%s.css', $designID );
			\wp_enqueue_style( 'wc-icalculator-product', ICALCULATOR_URL . $designPath, [], \wp_get_wp_version() );
		}

	}

	/**
	 * Enqueue scripts
	 * @return void
	 */
	public function enqueueScripts() {
		if ( ! is_product() ) {
			return;
		}

		\wp_enqueue_script( 'wc-icalculator-product', ICALCULATOR_URL . 'resources/assets/scripts/product.js', [], '1.0.0', true );

		\wp_localize_script( 'wc-icalculator-product', 'icalculator_product', [
			'is_popup' => false,
		] );
	}


	/**
	 * show installments in each variation
	 * @param array                $data
	 * @param \WC_Product_Variable $variable
	 * @return array
	 */
	public function productVariationDisplay( array $data, \WC_Product_Variable $variable, \WC_Product_Variation $variation ): array {
		
		$installments = $this->productHTMLDisplay( $variation, false );

		if ( !  $installments ) {
			return $data;
		}

		$data[ 'icalculator' ] = $installments;

		return $data;
	}


	/**
	 * Display installment calculator on product page
	 * @return void
	 */
	public function productDisplay(): void {
		global $product;

		if ( \apply_filters( 'icalculator/product/avoid_product_display', false, $product ) ) {
			return;
		}


		if ( $product->is_type('variable') ) {
			echo '<div class="icalculator"></div>';
			return;
		}

		$this->productHTMLDisplay( $product );
	}
	
	/**
	 * Product HTML display
	 * @param \WC_Product $product
	 * @param boolean $echo
	 * @return mixed
	*/
	public function productHTMLDisplay( \WC_Product $product, $echo = true ) {   
		
		$enable = \get_post_meta( $product->get_id(), '_wc_icalculator_enable', true );

		if ( empty( $enable ) || $enable === 'no' || empty( $product->get_price() ) ) {
			return;
		}
		
		$installmentCalculator = getInstallmentCalculator( $product );

		if ( empty( $installmentCalculator ) ) {
			return;
		}

		if ( ! $echo ) {
			\ob_start();
		}

		if ( \apply_filters( 'icalculator/product/has_display_installment', false ) ) {
			\do_action( 'icalculator/product/display_installment', $product );
			
			if ( ! $echo ) {
				return ob_get_clean();
			}

			return;
		}

		\wc_get_template(
			'resources/views/single-product-installments.php',
			[
				'installments' => $installmentCalculator,
				'enable_link'  => getSettings( 'enable_show_installment', 'no' ),
				'label_link'   => getSettings( 'label_show_installment', \esc_html__('Show Installments', 'wc-installment-calculator') ),
			],
			false,
			ICALCULATOR_DIR
		);

		if ( ! $echo ) {
			return ob_get_clean();
		}
	}


	/**
	 * Save product simple fields
	 * @return void
	 */
	public function productSimpleFields(): void {
		global $product_object, $pagenow;

		// Get Meta values
		$enable = \get_post_meta( $product_object->get_id(), '_wc_icalculator_enable', true );

		$args = \apply_filters( 'icalculator/product/enable_installment_calculator_field_args', [
			'product' => $product_object,
			'enable'  => $enable ?: 'no',
			'is_new'  => $pagenow === 'post-new.php',
		], $product_object );


		\wc_get_template(
			'resources/views/product-simple-fields.php',
			$args,
			false,
			ICALCULATOR_DIR
		);

		\do_action( 'icalculator/product/enable_installment_calculator_field', $args );
	}


	/**
	 * Save installment calculator field
	 * @param \WC_Product $product
	 * @return void
	 */
	public function saveProductSimpleFields( \WC_Product $product ): void {

		if ( ! isset( $_POST['wc-installment-calculator-field'] ) || ! \check_admin_referer( 'wc-installment-calculator-nonce', 'wc-installment-calculator-field' ) ) {
			\wp_die( \esc_html__( 'Security check failed.', 'wc-installment-calculator' ) );
		}

		$enable = isset( $_POST['_wc_icalculator_enable'] ) ? 'yes' : 'no';
		\update_post_meta( $product->get_id(), '_wc_icalculator_enable', $enable );
	}


	/**
	 * Product variation fields
	 * @param int $loop
	 * @param array $variationData
	 * @param \WP_Post $wpPost
	 * @return void
	 */
	public function productVariationFields( int $loop, array $variationData, ?\WP_Post $wpPost ): void {
		global $pagenow;
		
		// Get Variation
		$variation = \wc_get_product( $wpPost->ID );

		// Get Meta values
		$enable = \get_post_meta( $variation->get_id(), '_wc_icalculator_enable', true );

		$args = [
			'loop'		=> $loop,
			'variation'	=> $variation,
			'enable'	=> $enable ?: 'no',
			'is_new'    => $pagenow === 'post-new.php',
		];

		\wc_get_template(
			'resources/views/product-variation-fields.php',
			$args,
			false,
			ICALCULATOR_DIR
		);
	}

	/**
	 * Save product variation fields
	 * @param int $variationID
	 * @param int $i
	 * @return void
	 */
	public function saveProductVariationFields( int $variationID, int $i ): void {
		
		if ( ! isset( $_POST['wc-installment-calculator-field'] ) || ! \check_admin_referer( 'wc-installment-calculator-nonce', 'wc-installment-calculator-field' ) ) {
			\wp_die( \esc_html__( 'Security check failed.', 'wc-installment-calculator' ) );
		}

		$enable = isset( $_POST['_wc_icalculator_enable'][$i] ) ? 'yes' : 'no';
		\update_post_meta( $variationID, '_wc_icalculator_enable', $enable );
	}
}
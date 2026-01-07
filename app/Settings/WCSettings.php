<?php
namespace iCalculator\Settings;

/**
 * WC_Settings_DynPrice
 *
 * @package   iCalculator\Settings
 * @author    Alex Gonzales <support@letsgodev.com>
 * @copyright 2020 Linsila LLC
 * @license   GPL 2.0+
 * @link      https://www.letsgodev.com
 */

class WCSettings extends \WC_Settings_Page {

	/**
	 * Construct.
	 */
	public function __construct() {
		$this->id    = 'wc_installment_calculator';
		$this->label = esc_html__( 'Installment Calculator', 'wc-installment-calculator' );

		parent::__construct();
	}


	/**
	 * Get Sections
	 * @return array
	 */
	public function get_sections(): array {

		$sections = [
			''			=> \esc_html__( 'General', 'wc-installment-calculator' ),
			'design'	=> \esc_html__( 'Design', 'wc-installment-calculator' ),
		];

		return \apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
	}


	/**
	 * Output the settings.
	 * @return void
	 */
	public function output(): void {
		global $current_section;

		$settings = $this->get_settings( $current_section );

		\WC_Admin_Settings::output_fields( $settings );
	}


	/**
	 * Save settings.
	 * @return void
	 */
	public function save(): void {
		global $current_section;

		$settings = $this->get_settings( $current_section );
		\WC_Admin_Settings::save_fields( $settings );

		\do_action( 'icalculator/settings/after_save', $current_section );

		if ( $current_section ) {
			\do_action( 'woocommerce_update_options_' . $this->id . '_' . $current_section );
		}
	}


	/**
	 * Get settings array.
	 *
	 * @param string $current_section Current section name.
	 * @return array
	 */
	public function get_settings( string $currentSection = '' ): array {

		if ( $currentSection === 'design' ) {

			$settings = \apply_filters( 'icalculator/settings/design', [
				[
					'title'	=> \esc_html__( 'Desings', 'wc-installment-calculator' ),
					'type'	=> 'title',
					'id'	=> 'wc_icalculator_page_designs',
				],[
					'type'	=> 'wc_icalculator_design_product_page',
					'title'	=> \esc_html__( 'Design on the product page', 'wc-installment-calculator' ),
					'desc'	=> \esc_html__( 'Installments design on the product page.', 'wc-installment-calculator' ),
					'id'	=> 'wc_icalculator[design_product_page]',
				],[
					'type' => 'sectionend',
					'id'   => 'wc_icalculator_page_designs',
				]
			]);

		} else {

			$settings = \apply_filters( 'icalculator/settings/general', [
				[
					'title'	=> \esc_html__( 'Installments', 'wc-installment-calculator' ),
					'type'	=> 'title',
					'id'	=> 'wc_icalculator_page_installments',
				],[
					'type'	=> 'wc_icalculator_rules',
					'title'	=> \esc_html__( 'Rules', 'wc-installment-calculator' ),
					'desc'	=> \esc_html__( 'Define the rules for the installment calculator.', 'wc-installment-calculator' ),
					'id'	=> 'wc_icalculator[rules]',
				],[
					'type'	=> 'wc_icalculator_shop',
					'title'	=> \esc_html__( 'Shop page', 'wc-installment-calculator' ),
					'id'	=> 'wc_icalculator[shop]',
				],[
					'type' => 'sectionend',
					'id'   => 'wc_icalculator_page_installments',
				],[
					'title'	=> \esc_html__( 'Actions', 'wc-installment-calculator' ),
					'type'	=> 'title',
					'id'	=> 'wc_icalculator_page_actions',
				],[
					'title'		=> \esc_html__( 'Enable the show installment button','wc-installment-calculator' ),
					'type'		=> 'checkbox',
					'id'		=> 'wc_icalculator[enable_show_installment]',
					'desc'		=> \esc_html__( 'If you activate this option, a button/link will appear on the product page that, when clicked, will display the installments', 'wc-installment-calculator' ),
					'default'	=> 'no',
				],[
					'title'		=> \esc_html__( 'Label of the show installment button','wc-installment-calculator' ),
					'type'		=> 'text',
					'id'		=> 'wc_icalculator[label_show_installment]',
					'default'	=> \esc_html__('Show Installments', 'wc-installment-calculator'),
				],[
					'title'		=> \esc_html__( 'Remove installment calculator for all products','wc-installment-calculator' ),
					'type'		=> 'wc_icalculator_disable_installment',
				],[
					'title'		=> \esc_html__( 'Enable installment calculator for all products','wc-installment-calculator' ),
					'type'		=> 'wc_icalculator_enable_installment',
				],[
					'type'	=> 'sectionend',
					'id'	=> 'wc_icalculator_page_actions',
				]
			]);
		}

		return \apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $currentSection );
	}
}

return new WCSettings();
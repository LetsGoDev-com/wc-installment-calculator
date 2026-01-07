<?php
Namespace iCalculator\Controllers;

use iCalculator\Traits\Singleton;


/**
 * Internationalization Controller
 */
class I18nController {
	use Singleton;

	
	/**
	 * Domain to i18n
	 * @var string
	 */
	protected string $domain = 'wc-installment-calculator';


	/**
	 * Construct
	 * Define the locale for this plugin for internationalization.
	 */
	public function __construct() {
		\add_filter( 'load_textdomain_mofile', [ $this, 'overrideLoadTextdomainMofile' ], 10, 2 );
	}



	/**
	 * Override load textdomain
	 * @param bool $override
	 * @param string $domain
	 * @param string $mofile
	 * @param string $locale
	 * @return bool
	 */
	public function overrideLoadTextdomainMofile( string $mofile, string $domain ): string {

		if ( $domain !== $this->domain ) {
			return $mofile;
		}

		/** TODO: get_locale() has like output: en_US or de_DE */
		$newmofile = \sprintf( '%s/resources/languages/wc-installment-calculator-%s.mo', ICALCULATOR_DIR, \get_locale() );
	
		if ( \file_exists( $newmofile ) ) {
			return $newmofile;
		}

		return $mofile;
	}
}
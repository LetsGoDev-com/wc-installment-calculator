<?php

Namespace iCalculator\Core;

use iCalculator\Controllers\I18nController;
use iCalculator\Controllers\HPOSController;
use iCalculator\Controllers\LinksController;
use iCalculator\Controllers\SettingsController;
use iCalculator\Controllers\ProductController;

/**
 * Class iCalculator
 * @package iCalculator\Core
 * @since 1.0.0
 */
class iCalculator {

	/**
	 * Instance
	 * @var iCalculator
	 */
	public static ?iCalculator $instance = null;


	/**
	 * Construct
	 */
	public function __construct() {
		$this->initControllers();
	}


	/**
	 * Init controllers
	 * @return void
	 */
	public function initControllers(): void {
		I18nController::getInstance();
		HPOSController::getInstance();
		LinksController::getInstance();
		SettingsController::getInstance();
		ProductController::getInstance();
	}


	/**
	 * Getinstance method
	 * @return mixed
	 */
	public static function getInstance(): ?iCalculator {
		
		if ( empty( self::$instance ) ) {
			$className      = \get_called_class();
			self::$instance = new $className();
		}

		return self::$instance;

	}

}
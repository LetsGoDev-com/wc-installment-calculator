(function($) {
	'use strict';

	const iCalculator = {

		/**
		 * Start the engine.
		 *
		 * @since 2.0.0
		 */
		init: function() {

			// Document ready
			$( document ).ready( iCalculator.ready );

			// Page load
			$( window ).on( 'load', iCalculator.load );

			// Document ready
			$( document ).on( 'iCalculatorReady', iCalculator.start );
		},
		/**
		 * Document ready.
		 *
		 * @since 2.0.0
		 */
		ready: function() {

			// Execute
			iCalculator.executeUIActions();
		},
		/**
		 * Page load.
		 *
		 * @since 2.0.0
		 */
		load: function() {

			// Bind all actions.
			iCalculator.bindUIActions();
		},

		start: function() {
			// Set user identifier
			$( document ).trigger( 'iCalculatorStarted' );
		},

		/**
		 * Execute when the page is loaded
		 * @return mixed
		 */
		executeUIActions: function() {
		},

		// --------------------------------------------------------------------//
		// Binds
		// --------------------------------------------------------------------//
		/**
		 * Events bindings.
		 *
		 * @since 2.0.0
		 */
		bindUIActions: function() {

            // Variation found
            $('form.variations_form').on('found_variation', function(e, variation) {
                iCalculator.displayOnVariation( variation );
            });

            // Display
            $('.product').on( 'click', function(e) {
                if ( e.target && e.target.classList.contains('wc-icalculator-show-link') ) {
                    e.preventDefault();
                    iCalculator.displayInstallments();
                }
            } )
		},

        displayOnVariation: function( variation ) {
            if ( variation.icalculator ) {
                $('.icalculator').html( variation.icalculator );
            } else {
				$('.icalculator').empty();
			}
        },

        displayInstallments: function() {
            const showContent = $('.wc-icalculator-show-content');

			if ( ! icalculator_product.is_popup ) {
				showContent.slideToggle('fast');
			}
        }
	};

	// Initialize.
	iCalculator.init();

	// Add to global scope.
	window.icalculator = iCalculator;

})(jQuery);
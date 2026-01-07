/**
 * Initialize iCalculator
 * @return void
 */
const iCalculator = {

	/**
	 * Start the engine.
	 *
	 * @since 2.0.0
	 */
	init: function() {

		// Document ready
		document.addEventListener( "DOMContentLoaded", iCalculator.ready );

		// Page load
		window.addEventListener( 'load', iCalculator.load );

		// Document Start
		document.addEventListener( "iCalculatorTemplateReady", iCalculator.start );
	},
	/**
	 * Window Load
	 * @return void
	 */
	load: function() {
		// Bind all actions.
		iCalculator.bindUIActions();
	},
	/**
	 * DOMContentLoaded event
	 * @return void
	 */
	ready: function() {
		// Execute
		iCalculator.executeUIActions();
	},
	/**
	 * Start Trigger
	 * @return void
	 */
	start: function() {
		const event = new CustomEvent( 'iCalculatorStarted' );
		document.dispatchEvent(event);
	},
	/**
	 * Execute Actions
	 * @return void
	 */
	executeUIActions: function() {

	},
	/**
	 * Listener Actions
	 * @return void
	 */
	bindUIActions : function() {

		/**
		 * Bind the contact send event
		 */
		iCalculator.addInstallment();
        iCalculator.removeInstallment();
        iCalculator.previewInstallment();
	},

	addInstallment: function() {
		const addInstallmentButton = document.querySelector('.add-installment');
		
        if (!addInstallmentButton) {
            return;
        }
		
		addInstallmentButton.addEventListener('click', function(e) {
			e.preventDefault();

			let newRow;
			const lastRow = document.querySelector('.wc-icalculator-table tbody tr:last-child');

			if ( ! lastRow ) {
				newRow = iCalculator.createNewInstallment();
			} else {
				newRow =iCalculator.createCloneInstallment( lastRow );
			}
			
			// Add new row to table
			document.querySelector('.wc-icalculator-table tbody').appendChild(newRow);
		});
	},

	/**
	 * Create a clone of the last row
	 * @param {HTMLElement} lastRow
	 * @return {HTMLElement}
	 */
	createCloneInstallment: function( lastRow ) {
		const newRow = lastRow.cloneNode(true);
			
		// Get current index and calculate new one
		const dataItem = parseInt(lastRow.dataset.item) || 0;
		const newDataItem = dataItem + 1;
		
		// Update the data-item of the tr
		newRow.dataset.item = newDataItem;
		
		// Update the remove link
		const removeLink = newRow.querySelector('a.remove-installment');
		
		if (removeLink) {
			removeLink.dataset.item = newDataItem;
			removeLink.dataset.group = '0';
		}
		
		// Update input names with the new index
		const inputs = newRow.querySelectorAll('input');
		
		inputs.forEach(function(input) {
			const name = input.getAttribute('name');
			if (name && name.indexOf('[items][') !== -1) {
				// Replace index in name: wc_icalculator[rules][0][items][0][...] -> wc_icalculator[rules][0][items][1][...]
				// Find the pattern [items][NUMBER] and replace NUMBER with newDataItem
				const regex = /(\[items\]\[)\d+(\])/;
				const newName = name.replace(regex, '$1' + newDataItem + '$2');
				
				input.setAttribute('name', newName);
			}
		});

		return newRow;
	},

	/**
	 * Create a new installment
	 * @return {HTMLElement}
	 */
	createNewInstallment: function() {
		const newRow = document.createElement('tr');
		newRow.dataset.group = '0';
		newRow.dataset.item = '0';

		const tdNumber = document.createElement('td');
		tdNumber.classList.add('small');
		newRow.appendChild(tdNumber);

		const tdSurcharge = document.createElement('td');
		tdSurcharge.classList.add('small');
		newRow.appendChild(tdSurcharge);

		const tdContent = document.createElement('td');
		tdContent.classList.add('label');
		newRow.appendChild(tdContent);

		const tdRemove = document.createElement('td');
		tdRemove.classList.add('verysmall');
		newRow.appendChild(tdRemove);

		const iNumber = document.createElement('input');
		iNumber.type = 'number';
		iNumber.step = '1';
		iNumber.name = 'wc_icalculator[rules][0][items][0][number]';
		iNumber.value = '1';
		tdNumber.appendChild(iNumber);

		const iSurcharge = document.createElement('input');
		iSurcharge.type = 'number';
		iSurcharge.step = '0.01';
		iSurcharge.name = 'wc_icalculator[rules][0][items][0][surcharge]';
		iSurcharge.value = '0';
		tdSurcharge.appendChild(iSurcharge);

		const iContent = document.createElement('input');
		iContent.type = 'text';
		iContent.name = 'wc_icalculator[rules][0][items][0][content]';
		iContent.value = icalculator_settings?.installment_content_product || '';
		tdContent.appendChild(iContent);

		const aRemove = document.createElement('a');
		aRemove.href = '#';
		aRemove.classList.add('remove-installment');
		aRemove.dataset.group = '0';
		aRemove.dataset.item = '0';
		aRemove.innerHTML = 'x';
		tdRemove.appendChild(aRemove);

		return newRow;
	},

	removeInstallment: function() {
		// Use event delegation to handle dynamically added buttons
		const tableBody = document.querySelector('.wc-icalculator-table tbody');
		
		if (!tableBody) {
            return;
        }
		
		tableBody.addEventListener('click', function(e) {
			if (e.target && e.target.classList.contains('remove-installment')) {
				e.preventDefault();
				
				const button = e.target;
				const row = button.closest('tr');
				
				if (!row) {
					return; 
				}

				row.remove();				
			}
		});
	}
};

iCalculator.init();
<?php if ( ! \defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="<?php echo \esc_attr( $id ); ?>">
			<?php echo \esc_html( $title ); ?>
			<?php echo \esc_html( $tooltip_html ); ?>
		</label>
	</th>
	<td class="forminp">

		<div class="wc-icalculator-settings-container">
			<div class="wc-icalculator-settings-col1">
				<div class="wc-icalculator-settings-groups">
					<div class="wc-icalculator-settings-group" data-group="0">
						<label for="">
							<?php \esc_html_e( 'Subtitle (optional)', 'wc-installment-calculator' ); ?>
						</label>
						<input type="text" class="wc-icalculator-subtitle" name="wc_icalculator[rules][0][subtitle]" value="<?php echo \esc_attr( $rules[0]['subtitle'] ?? '' ); ?>" />

						<table class="wc-icalculator-table">
						<thead>
							<tr>
								<th class="small"><?php \esc_html_e( 'Installment', 'wc-installment-calculator' ); ?></th>
								<th class="small"><?php \esc_html_e( 'Surcharge (%)', 'wc-installment-calculator' ); ?></th>
								<th class="label"><?php \esc_html_e( 'Content', 'wc-installment-calculator' ); ?></th>
								<th class="verysmall"></th>
							</tr>
						</thead>
						<tbody>
							<?php if ( ! empty( $rules[0]['items'] ) ) : ?>
								<?php foreach ( $rules[0]['items'] as $icalculator_index => $icalculator_item ) : ?>
									<tr data-group="0" data-item="<?php echo \esc_attr( $icalculator_index ); ?>">
										<td class="small"><input type="number" step="1" name="wc_icalculator[rules][0][items][<?php echo \esc_attr( $icalculator_index ); ?>][number]" value="<?php echo \esc_html( $icalculator_item['number'] ); ?>" /></td>
										<td class="small"><input type="number" step="0.01" name="wc_icalculator[rules][0][items][<?php echo \esc_attr( $icalculator_index ); ?>][surcharge]" value="<?php echo \esc_html( $icalculator_item['surcharge'] ); ?>" /></td>
										<td class="label"><input type="text" name="wc_icalculator[rules][0][items][<?php echo \esc_attr( $icalculator_index ); ?>][content]" value="<?php echo \esc_html( $icalculator_item['content'] ); ?>" /></td>
										<td class="verysmall"><a href="#" class="remove-installment" data-group="0" data-item="<?php echo \esc_attr( $icalculator_index ); ?>">x</a></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
						</table>
						
						<a href="#" class="button add-installment" data-group="0"><?php \esc_html_e( 'Add Installment', 'wc-installment-calculator' ); ?></a>
					</div>
				</div>
			</div>
			<div class="wc-icalculator-settings-col2">
				<ul class="wc-icalculator-settings-list">
					<li><span>%price%</span><br /><?php \esc_html_e( 'Product price', 'wc-installment-calculator' ); ?></li>
					<li><span>%number%</span><br /><?php \esc_html_e( 'Number of installments', 'wc-installment-calculator' ); ?></li>
					<li><span>%surcharge%</span><br /><?php \esc_html_e( 'Surcharge (in percentage)', 'wc-installment-calculator' ); ?></li>
					<li><span>%subtotal%</span><br />
					<?php
						/* translators: %price% - product price, %surcharge% - surcharge (in percentage), %number% - number of installments */
						\esc_html_e( '( %price% + %surcharge% ) / %number%', 'wc-installment-calculator' );
					?>
					</li>
				</ul>

			</div>
		</div>
	</td>
</tr>
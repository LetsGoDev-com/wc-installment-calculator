<?php if ( ! \defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="<?php echo esc_attr( $id ); ?>">
			<?php echo esc_html( $title ); ?>
			<?php //echo $tooltip_html; // WPCS: XSS ok. ?>
		</label>
	</th>
	<td class="forminp">
		<button class="button button-secondary icalculator-button" data-action="enable" <?php \disabled( $disabled ); ?>><?php esc_html_e( 'Enable Installment Calculator', 'wc-installment-calculator' ); ?></button>
		<?php if ( $disabled ) : ?>
			<span class="wc-icalculator-only-pro">
				<?php \esc_html_e( 'Only Pro version available', 'wc-installment-calculator' ); ?>
			</span>
		<?php endif; ?>
		<span class="icalculator-loading" data-action="enable"></span>
		<p class="help"><?php esc_html_e( 'Clicking this button, you will enable the installment calculator for all your products.', 'wc-installment-calculator' ); ?></p>
	</td>
</tr>
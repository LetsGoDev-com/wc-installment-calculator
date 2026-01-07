<?php if ( ! \defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="<?php echo \esc_attr( $id ); ?>">
			<?php echo \esc_html( $title ); ?>
			<?php echo \esc_html( $tooltip_html ); ?>
		</label>
	</th>
	<td class="forminp">

        <div class="wc-icalculator-only-pro">
            <?php \esc_html_e( 'Only Pro version available', 'wc-installment-calculator' ); ?>
        </div>

        <div class="wc-icalculator-shop-container">
            <div class="wc-icalculator-shop-col1">
                <select name="" id="wc-icalculator-shop" disabled="disabled" placeholder="Select a page" >
                    <option value="2">2 cuotas</option>
                </select>
            </div>
            <div class="wc-icalculator-shop-col2">
                <input type="text" name="" value="O %subtotal% en %number% cuotas sin interés" disabled="disabled" />
            </div>
        </div>

        <div class="description">
            <?php \esc_html_e( 'Display a selected installment in the product list (shop page).', 'wc-installment-calculator' ); ?>
        </div>
	</td>
</tr>
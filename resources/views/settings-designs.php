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
			<table class="wc-icalculator-designs-table">
				<tbody>
					<tr>
						<td>
							<div class="wc-icalculator-design-input"><input type="radio" name="wc_icalculator[design_product_page]" value="1" <?php \checked( $design, 1 ); ?> /><span class="wc-icalculator-design-available"><?php \esc_html_e( 'Available', 'wc-installment-calculator' ); ?></span></div>
							<img src="<?php echo \esc_html( ICALCULATOR_URL ) . 'resources/assets/images/design1-es.jpg'; ?>" alt="Design 1" />
						</td>
						<td>
							<div class="wc-icalculator-design-input">
								<input type="radio" name="wc_icalculator[design_product_page]" value="2" <?php \checked( $design, 2 ); ?> <?php \disabled( $disabled ); ?> />
								<?php if ( $disabled ) : ?>
									<span class="wc-icalculator-design-only-pro">
										<?php \esc_html_e( 'Only Pro version available', 'wc-installment-calculator' ); ?>
									</span>
								<?php else : ?>
									<span class="wc-icalculator-design-available">
										<?php \esc_html_e( 'Available', 'wc-installment-calculator' ); ?>
									</span>
								<?php endif; ?>
							</div>
							<img src="<?php echo \esc_html( ICALCULATOR_URL ) . 'resources/assets/images/design2-es.jpg'; ?>" alt="Design 2" />
						</td>
						<td>
							<div class="wc-icalculator-design-input">
								<input type="radio" name="wc_icalculator[design_product_page]" value="3" <?php \checked( $design, 3 ); ?> <?php \disabled( $disabled ); ?> />
								<?php if ( $disabled ) : ?>
									<span class="wc-icalculator-design-only-pro">
										<?php \esc_html_e( 'Only Pro version available', 'wc-installment-calculator' ); ?>
									</span>
								<?php else : ?>
									<span class="wc-icalculator-design-available">
										<?php \esc_html_e( 'Available', 'wc-installment-calculator' ); ?>
									</span>
								<?php endif; ?>
							</div>
							<img src="<?php echo \esc_html( ICALCULATOR_URL ) . 'resources/assets/images/design3-es.jpg'; ?>" alt="Design 3" />
						</td>
					</tr>
					<tr>
						<td>
							<div class="wc-icalculator-design-input"><input type="radio" name="wc_icalculator[design_product_page]" value="4" <?php \checked( $design, 4 ); ?> <?php \disabled( $disabled ); ?> />
								<?php if ( $disabled ) : ?>
									<span class="wc-icalculator-design-only-pro">
										<?php \esc_html_e( 'Only Pro version available', 'wc-installment-calculator' ); ?>
									</span>
								<?php else : ?>
									<span class="wc-icalculator-design-available">
										<?php \esc_html_e( 'Available', 'wc-installment-calculator' ); ?>
									</span>
								<?php endif; ?>
							</div>
							<img src="<?php echo \esc_html( ICALCULATOR_URL ) . 'resources/assets/images/design4-es.jpg'; ?>" alt="Design 4" />
						</td>
						<td>
							<div class="wc-icalculator-design-input"><input type="radio" name="wc_icalculator[design_product_page]" value="5" <?php \checked( $design, 5 ); ?> <?php \disabled( $disabled ); ?> />
								<?php if ( $disabled ) : ?>
									<span class="wc-icalculator-design-only-pro">
										<?php \esc_html_e( 'Only Pro version available', 'wc-installment-calculator' ); ?>
									</span>
								<?php else : ?>
									<span class="wc-icalculator-design-available">
										<?php \esc_html_e( 'Available', 'wc-installment-calculator' ); ?>
									</span>
								<?php endif; ?>
							</div>
							<img src="<?php echo \esc_html( ICALCULATOR_URL ) . 'resources/assets/images/design5-es.jpg'; ?>" alt="Design 5" />
						</td>
						<td>
							<div class="wc-icalculator-design-input"><input type="radio" name="wc_icalculator[design_product_page]" value="6" <?php \checked( $design, 6 ); ?> <?php \disabled( $disabled ); ?> />
								<?php if ( $disabled ) : ?>
									<span class="wc-icalculator-design-only-pro">
										<?php \esc_html_e( 'Only Pro version available', 'wc-installment-calculator' ); ?>
									</span>
								<?php else : ?>
									<span class="wc-icalculator-design-available">
										<?php \esc_html_e( 'Available', 'wc-installment-calculator' ); ?>
									</span>
								<?php endif; ?>
							</div>
							<img src="<?php echo \esc_html( ICALCULATOR_URL ) . 'resources/assets/images/design6-es.jpg'; ?>" alt="Design 6" />
						</td>
					</tr>
					<tr>
						<td>
							<div class="wc-icalculator-design-input"><input type="radio" name="wc_icalculator[design_product_page]" value="7" <?php \checked( $design, 7 ); ?> <?php \disabled( $disabled ); ?> />
								<?php if ( $disabled ) : ?>
									<span class="wc-icalculator-design-only-pro">
										<?php \esc_html_e( 'Only Pro version available', 'wc-installment-calculator' ); ?>
									</span>
								<?php else : ?>
									<span class="wc-icalculator-design-available">
										<?php \esc_html_e( 'Available', 'wc-installment-calculator' ); ?>
									</span>
								<?php endif; ?>
							</div>
							<img src="<?php echo \esc_html( ICALCULATOR_URL ) . 'resources/assets/images/design7-es.jpg'; ?>" alt="Design 7" />
						</td>
						<td>
							<div class="wc-icalculator-design-input"><input type="radio" name="wc_icalculator[design_product_page]" value="8" <?php \checked( $design, 8 ); ?> <?php \disabled( $disabled ); ?> />
								<?php if ( $disabled ) : ?>
									<span class="wc-icalculator-design-only-pro">
										<?php \esc_html_e( 'Only Pro version available', 'wc-installment-calculator' ); ?>
									</span>
								<?php else : ?>
									<span class="wc-icalculator-design-available">
										<?php \esc_html_e( 'Available', 'wc-installment-calculator' ); ?>
									</span>
								<?php endif; ?>
							</div>
							<img src="<?php echo \esc_html( ICALCULATOR_URL ) . 'resources/assets/images/design8-es.jpg'; ?>" alt="Design 9" />
						</td>
						<td>
							<div class="wc-icalculator-design-input"><input type="radio" name="wc_icalculator[design_product_page]" value="9" <?php \checked( $design, 9 ); ?> <?php \disabled( $disabled ); ?> />
								<?php if ( $disabled ) : ?>
									<span class="wc-icalculator-design-only-pro">
										<?php \esc_html_e( 'Only Pro version available', 'wc-installment-calculator' ); ?>
									</span>
								<?php else : ?>
									<span class="wc-icalculator-design-available">
										<?php \esc_html_e( 'Available', 'wc-installment-calculator' ); ?>
									</span>
								<?php endif; ?>
							</div>
							<img src="<?php echo \esc_html( ICALCULATOR_URL ) . 'resources/assets/images/design9-es.jpg'; ?>" alt="Design 9" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</td>
</tr>
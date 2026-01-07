<?php if ( ! \defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="wc-icalculator-single-product">
	<?php if ( $enable_link === 'yes' ) : ?>
		<a href="#" class="wc-icalculator-show-link"><?php echo \esc_html( $label_link ); ?></a>
	<?php endif; ?>
	
	<div
		class="wc-icalculator-show-content <?php echo $enable_link === 'yes' ? 'has_show_link' : ''; ?>"
		style="<?php echo $enable_link === 'yes' ? 'display: none;' : ''; ?>"
	>
		<?php if ( ! empty( $installments['subtitle'] ) ) : ?>
			<h3><?php echo \esc_html( $installments['subtitle'] ); ?></h3>
		<?php endif; ?>
		<ul>
			<?php foreach ( $installments['items'] as $icalculator_item ) : ?>
				<li><?php echo \wp_kses_post( $icalculator_item ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php 
$hover = the_mounty_get_theme_option('shop_hover');
if ( 'product' == get_post_type(get_the_ID()) ) {
	global $product;
	if ($args['slider']) {
		?><div class="slider-slide swiper-slide"><?php
	} else if ((int)$args['columns'] > 1) {
		?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
	} ?>
	<div <?php wc_product_class( '', $product ); ?>>
		<div class="post_item post_layout_<?php echo esc_attr(is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ? the_mounty_storage_get('shop_mode') : 'thumbs'); ?>">
			<div class="post_featured hover_<?php echo esc_attr($hover); ?>">
				<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<?php if ( $product->is_on_sale() ) : ?>
						<?php echo '<span class="onsale">' . esc_html__( 'Sale!', 'the-mounty' ) . '</span>' ?>
					<?php endif;
					
					if (is_object($product) && get_post_type()=='product' && (!$product->is_in_stock() )) {
						?><span class="outofstock_label"><?php esc_html_e('Out of stock', 'the-mounty'); ?></span><?php
					}	

						echo wp_kses( $product->get_image(), 'the_mounty_kses_content' );
					?>
				</a>
				<?php
					if (($hover = the_mounty_get_theme_option('shop_hover')) != 'none') {
						?><div class="mask"></div><?php
						the_mounty_hovers_add_icons($hover);
					}
				?>
			</div><!-- /.post_featured -->
		</div>
		<div class="post_data">
			<div class="post_data_inner">
				<div class="post_header entry-header">
					<h2 class="woocommerce-loop-product__title">
						<a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
					</h2>
				</div><!-- /.post_header -->
				<div class="price_wrap">
					<span class="price">
						<?php echo wp_kses( $product->get_price_html(), 'the_mounty_kses_content' )?>
					</span>
				</div><!-- /.price_wrap -->
				<?php echo wp_kses( wc_get_rating_html( $product->get_average_rating() ), 'the_mounty_kses_content' ); ?>
			</div><!-- /.post_data_inner -->
		</div><!-- /.post_data -->
	</div><!-- /.post_item -->
	
	<?php if ($args['slider'] || (int)$args['columns'] > 1) {
		?></div><?php
	} ?>
<?php }
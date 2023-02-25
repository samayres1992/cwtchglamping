<div class="front_page_section front_page_section_woocommerce<?php
			$the_mounty_scheme = the_mounty_get_theme_option('front_page_woocommerce_scheme');
			if (!the_mounty_is_inherit($the_mounty_scheme)) echo ' scheme_'.esc_attr($the_mounty_scheme);
			echo ' front_page_section_paddings_'.esc_attr(the_mounty_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$the_mounty_css = '';
		$the_mounty_bg_image = the_mounty_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($the_mounty_bg_image)) 
			$the_mounty_css .= 'background-image: url('.esc_url(the_mounty_get_attachment_url($the_mounty_bg_image)).');';
		if (!empty($the_mounty_css))
			echo ' style="' . esc_attr($the_mounty_css) . '"';
?>><?php
	// Add anchor
	$the_mounty_anchor_icon = the_mounty_get_theme_option('front_page_woocommerce_anchor_icon');	
	$the_mounty_anchor_text = the_mounty_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($the_mounty_anchor_icon) || !empty($the_mounty_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($the_mounty_anchor_icon) ? ' icon="'.esc_attr($the_mounty_anchor_icon).'"' : '')
										. (!empty($the_mounty_anchor_text) ? ' title="'.esc_attr($the_mounty_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (the_mounty_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' the_mounty-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$the_mounty_css = '';
			$the_mounty_bg_mask = the_mounty_get_theme_option('front_page_woocommerce_bg_mask');
			$the_mounty_bg_color = the_mounty_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($the_mounty_bg_color) && $the_mounty_bg_mask > 0)
				$the_mounty_css .= 'background-color: '.esc_attr($the_mounty_bg_mask==1
																	? $the_mounty_bg_color
																	: the_mounty_hex2rgba($the_mounty_bg_color, $the_mounty_bg_mask)
																).';';
			if (!empty($the_mounty_css))
				echo ' style="' . esc_attr($the_mounty_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$the_mounty_caption = the_mounty_get_theme_option('front_page_woocommerce_caption');
			$the_mounty_description = the_mounty_get_theme_option('front_page_woocommerce_description');
			if (!empty($the_mounty_caption) || !empty($the_mounty_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($the_mounty_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($the_mounty_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses($the_mounty_caption, 'the_mounty_kses_content' );
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($the_mounty_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($the_mounty_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses(wpautop($the_mounty_description), 'the_mounty_kses_content' );
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$the_mounty_woocommerce_sc = the_mounty_get_theme_option('front_page_woocommerce_products');
				if ($the_mounty_woocommerce_sc == 'products') {
					$the_mounty_woocommerce_sc_ids = the_mounty_get_theme_option('front_page_woocommerce_products_per_page');
					$the_mounty_woocommerce_sc_per_page = count(explode(',', $the_mounty_woocommerce_sc_ids));
				} else {
					$the_mounty_woocommerce_sc_per_page = max(1, (int) the_mounty_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$the_mounty_woocommerce_sc_columns = max(1, min($the_mounty_woocommerce_sc_per_page, (int) the_mounty_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$the_mounty_woocommerce_sc}"
									. ($the_mounty_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($the_mounty_woocommerce_sc_ids).'"' 
											: '')
									. ($the_mounty_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(the_mounty_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($the_mounty_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(the_mounty_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(the_mounty_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($the_mounty_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($the_mounty_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>
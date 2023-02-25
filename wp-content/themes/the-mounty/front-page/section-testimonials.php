<div class="front_page_section front_page_section_testimonials<?php
			$the_mounty_scheme = the_mounty_get_theme_option('front_page_testimonials_scheme');
			if (!the_mounty_is_inherit($the_mounty_scheme)) echo ' scheme_'.esc_attr($the_mounty_scheme);
			echo ' front_page_section_paddings_'.esc_attr(the_mounty_get_theme_option('front_page_testimonials_paddings'));
		?>"<?php
		$the_mounty_css = '';
		$the_mounty_bg_image = the_mounty_get_theme_option('front_page_testimonials_bg_image');
		if (!empty($the_mounty_bg_image)) 
			$the_mounty_css .= 'background-image: url('.esc_url(the_mounty_get_attachment_url($the_mounty_bg_image)).');';
		if (!empty($the_mounty_css))
			echo ' style="' . esc_attr($the_mounty_css) . '"';
?>><?php
	// Add anchor
	$the_mounty_anchor_icon = the_mounty_get_theme_option('front_page_testimonials_anchor_icon');	
	$the_mounty_anchor_text = the_mounty_get_theme_option('front_page_testimonials_anchor_text');	
	if ((!empty($the_mounty_anchor_icon) || !empty($the_mounty_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_testimonials"'
										. (!empty($the_mounty_anchor_icon) ? ' icon="'.esc_attr($the_mounty_anchor_icon).'"' : '')
										. (!empty($the_mounty_anchor_text) ? ' title="'.esc_attr($the_mounty_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_testimonials_inner<?php
			if (the_mounty_get_theme_option('front_page_testimonials_fullheight'))
				echo ' the_mounty-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$the_mounty_css = '';
			$the_mounty_bg_mask = the_mounty_get_theme_option('front_page_testimonials_bg_mask');
			$the_mounty_bg_color = the_mounty_get_theme_option('front_page_testimonials_bg_color');
			if (!empty($the_mounty_bg_color) && $the_mounty_bg_mask > 0)
				$the_mounty_css .= 'background-color: '.esc_attr($the_mounty_bg_mask==1
																	? $the_mounty_bg_color
																	: the_mounty_hex2rgba($the_mounty_bg_color, $the_mounty_bg_mask)
																).';';
			if (!empty($the_mounty_css))
				echo ' style="' . esc_attr($the_mounty_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_testimonials_content_wrap content_wrap">
			<?php
			// Caption
			$the_mounty_caption = the_mounty_get_theme_option('front_page_testimonials_caption');
			if (!empty($the_mounty_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_testimonials_caption front_page_block_<?php echo !empty($the_mounty_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($the_mounty_caption, 'the_mounty_kses_content' ); ?></h2><?php
			}
		
			// Description (text)
			$the_mounty_description = the_mounty_get_theme_option('front_page_testimonials_description');
			$the_mounty_description = the_mounty_get_theme_option('front_page_testimonials_description');
			if (!empty($the_mounty_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_testimonials_description front_page_block_<?php echo !empty($the_mounty_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($the_mounty_description), 'the_mounty_kses_content' ); ?></div><?php
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_testimonials_output"><?php 
				if (is_active_sidebar('front_page_testimonials_widgets')) {
					dynamic_sidebar( 'front_page_testimonials_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!the_mounty_exists_trx_addons())
						the_mounty_customizer_need_trx_addons_message();
					else
						the_mounty_customizer_need_widgets_message('front_page_testimonials_caption', 'ThemeREX Addons - Testimonials');
				}
			?></div>
		</div>
	</div>
</div>
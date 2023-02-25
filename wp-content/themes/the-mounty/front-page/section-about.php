<div class="front_page_section front_page_section_about<?php
			$the_mounty_scheme = the_mounty_get_theme_option('front_page_about_scheme');
			if (!the_mounty_is_inherit($the_mounty_scheme)) echo ' scheme_'.esc_attr($the_mounty_scheme);
			echo ' front_page_section_paddings_'.esc_attr(the_mounty_get_theme_option('front_page_about_paddings'));
		?>"<?php
		$the_mounty_css = '';
		$the_mounty_bg_image = the_mounty_get_theme_option('front_page_about_bg_image');
		if (!empty($the_mounty_bg_image)) 
			$the_mounty_css .= 'background-image: url('.esc_url(the_mounty_get_attachment_url($the_mounty_bg_image)).');';
		if (!empty($the_mounty_css))
			echo ' style="' . esc_attr($the_mounty_css) . '"';
?>><?php
	// Add anchor
	$the_mounty_anchor_icon = the_mounty_get_theme_option('front_page_about_anchor_icon');	
	$the_mounty_anchor_text = the_mounty_get_theme_option('front_page_about_anchor_text');	
	if ((!empty($the_mounty_anchor_icon) || !empty($the_mounty_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_about"'
										. (!empty($the_mounty_anchor_icon) ? ' icon="'.esc_attr($the_mounty_anchor_icon).'"' : '')
										. (!empty($the_mounty_anchor_text) ? ' title="'.esc_attr($the_mounty_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_about_inner<?php
			if (the_mounty_get_theme_option('front_page_about_fullheight'))
				echo ' the_mounty-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$the_mounty_css = '';
			$the_mounty_bg_mask = the_mounty_get_theme_option('front_page_about_bg_mask');
			$the_mounty_bg_color = the_mounty_get_theme_option('front_page_about_bg_color');
			if (!empty($the_mounty_bg_color) && $the_mounty_bg_mask > 0)
				$the_mounty_css .= 'background-color: '.esc_attr($the_mounty_bg_mask==1
																	? $the_mounty_bg_color
																	: the_mounty_hex2rgba($the_mounty_bg_color, $the_mounty_bg_mask)
																).';';
			if (!empty($the_mounty_css))
				echo ' style="' . esc_attr($the_mounty_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$the_mounty_caption = the_mounty_get_theme_option('front_page_about_caption');
			if (!empty($the_mounty_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo !empty($the_mounty_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($the_mounty_caption, 'the_mounty_kses_content' ); ?></h2><?php
			}
		
			// Description (text)
			$the_mounty_description = the_mounty_get_theme_option('front_page_about_description');
			if (!empty($the_mounty_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo !empty($the_mounty_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($the_mounty_description), 'the_mounty_kses_content' ); ?></div><?php
			}
			
			// Content
			$the_mounty_content = the_mounty_get_theme_option('front_page_about_content');
			if (!empty($the_mounty_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo !empty($the_mounty_content) ? 'filled' : 'empty'; ?>"><?php
					$the_mounty_page_content_mask = '%%CONTENT%%';
					if (strpos($the_mounty_content, $the_mounty_page_content_mask) !== false) {
						$the_mounty_content = preg_replace(
									'/(\<p\>\s*)?'.$the_mounty_page_content_mask.'(\s*\<\/p\>)/i',
									sprintf('<div class="front_page_section_about_source">%s</div>',
												apply_filters('the_content', get_the_content())),
									$the_mounty_content
									);
					}
					the_mounty_show_layout($the_mounty_content);
				?></div><?php
			}
			?>
		</div>
	</div>
</div>
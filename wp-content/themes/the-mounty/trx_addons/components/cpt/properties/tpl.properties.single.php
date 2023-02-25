<?php
/**
 * The template to display the property's single page
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.22
 */

wp_enqueue_script('jquery-ui-accordion', false, array('jquery', 'jquery-ui-core'), null, true);
if (trx_addons_get_option('properties_single_style') == 'tabs')
	wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);

get_header();

while ( have_posts() ) { the_post();
	$trx_addons_meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'properties_page itemscope' ); trx_addons_seo_snippets('', 'Article'); ?>>

		<?php do_action('trx_addons_action_before_article', 'properties.single'); ?>
		
		<section class="properties_page_section properties_page_header"><?php
			// Image
			if ( !trx_addons_sc_layouts_showed('featured') && has_post_thumbnail() ) {
				?><div class="properties_page_featured"><?php
					the_post_thumbnail(
										apply_filters('trx_addons_filter_thumb_size', 'full', 'properties-single'),
										trx_addons_seo_image_params(array(
																		'alt' => the_title_attribute( array( 'echo' => false ) )
																		))
										);
				?></div><?php
				if (!empty($trx_addons_meta['gallery'])) {
					$trx_addons_gallery = explode('|', $trx_addons_meta['gallery']);
					if (is_array($trx_addons_gallery)) {
						?><div class="properties_page_gallery"><?php
							array_unshift($trx_addons_gallery, get_post_thumbnail_id($id));
							$i = 0;
							foreach($trx_addons_gallery as $trx_addons_image) {
								$i++;
								if ($trx_addons_image != '') {
									$trx_addons_thumb = trx_addons_get_attachment_url($trx_addons_image, trx_addons_get_thumb_size('tiny'));
									$trx_addons_image = trx_addons_get_attachment_url($trx_addons_image, trx_addons_get_thumb_size('huge'));
									if (!empty($trx_addons_thumb)) {
										$attr = trx_addons_getimagesize($trx_addons_thumb);
										?><span class="properties_page_gallery_item<?php if ((int)$i==1) echo " properties_page_gallery_item_active"; ?>" data-image="<?php echo esc_url($trx_addons_image); ?>"><?php
											?><img src="<?php echo esc_url($trx_addons_thumb); ?>" alt="<?php esc_attr_e( 'Image', 'the-mounty' ); ?>" <?php
												if (!empty($attr[3])) echo ' '.trim($attr[3]);
											?>><?php
										?></span><?php
									}
								}
							}
						?></div><?php
					}
				}
			}
			
			// Title
			if ( true || !trx_addons_sc_layouts_showed('title') ) {
				?><div class="properties_page_title_wrap">
                    <div class="inner inner_1">
                        <h4 class="properties_page_title"><?php the_title(); ?></h4>
                        <?php
                        // Address
                        if (!empty($trx_addons_meta['address'])) {
                            ?><div class="properties_page_title_address"><?php
                                trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.parts.address.php',
                                                                'trx_addons_args_properties_address',
                                                                array('meta' => $trx_addons_meta)
                                                            );
                            ?></div><?php
                        }
                    ?></div><div class="inner inner_2"><?php
                        // Meta
                        ?><div class="properties_page_title_meta"><?php
                            // Price
                            if (!empty($trx_addons_meta['price']) || !empty($trx_addons_meta['price2'])) {
                                ?><div class="properties_page_title_price"><?php
                                    trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.parts.price.php',
                                                                    'trx_addons_args_properties_price',
                                                                    array('meta' => $trx_addons_meta)
                                                                );
                                ?></div><?php
                            }
                        ?></div><?php
                        // Counters
                        the_mounty_show_post_meta(apply_filters('the_mounty_filter_post_meta_args', array(
                                'components' => 'counters',
                                'counters' => 'views,comments,likes',
                                'seo' => false
                            ), 'excerpt', 1)
                        );
                    ?></div><div class="inner inner_3"><?php
                        // Status
                        ?><div class="properties_page_status"><?php
                            trx_addons_show_layout(trx_addons_get_post_terms('', get_the_ID(), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_STATUS));
                        ?></div><?php
                    ?></div><?php
                ?></div><?php
			}
		?></section><?php

		
		// Section's titles
		$trx_addons_section_titles = array(
			'description' => esc_html__('Description', 'the-mounty'),
			'details' => esc_html__('Details', 'the-mounty'),
			'features' => esc_html__('Features', 'the-mounty'),
			'floor_plans' => esc_html__('Floor plans', 'the-mounty'),
			'attachments' => esc_html__('Attachments', 'the-mounty'),
			'video' => esc_html__('Video', 'the-mounty'),
			'virtual_tour' => esc_html__('Virtual tour', 'the-mounty'),
			'contacts' => esc_html__('Contacts', 'the-mounty'),
			'googlemap' => esc_html__('Google map', 'the-mounty')
		);
		$trx_addons_tabs_id = 'properties_page_tabs';

		// Tabs
		if (trx_addons_get_option('properties_single_style') == 'tabs') {
			if (empty($trx_addons_meta['floor_plans_enable'])
				|| empty($trx_addons_meta['floor_plans']) 
				|| !is_array($trx_addons_meta['floor_plans'])
				|| empty($trx_addons_meta['floor_plans'][0]['title']))
				unset($trx_addons_section_titles['floor_plans']);
			if (empty($trx_addons_meta['attachments']))
				unset($trx_addons_section_titles['attachments']);
			if (empty($trx_addons_meta['video']))
				unset($trx_addons_section_titles['video']);
			if (empty($trx_addons_meta['virtual_tour']))
				unset($trx_addons_section_titles['virtual_tour']);
			if (empty($trx_addons_meta['show_map'])
				|| empty($trx_addons_meta['location']))
				unset($trx_addons_section_titles['googlemap']);
			if (empty($trx_addons_meta['agent_type']) 
				|| $trx_addons_meta['agent_type']=='none' 
				|| ($trx_addons_meta['agent_type']!='author' && (int)$trx_addons_meta['agent']==0))
				unset($trx_addons_section_titles['contacts']);
			?><div class="trx_addons_tabs properties_page_tabs">
				<ul class="trx_addons_tabs_titles"><?php
					foreach ($trx_addons_section_titles as $trx_addons_section_slug => $trx_addons_section_title) {
						$trx_addons_tab_id = $trx_addons_tabs_id.'_'.$trx_addons_section_slug;
						$trx_addons_tab_active = trx_addons_get_value_gp('tab')==$trx_addons_section_slug
										? ' data-active="true"' 
										: '';
						?><li<?php
							if (trx_addons_get_value_gp('tab')==$trx_addons_section_slug)
								echo ' data-active="true"';
							?>><a href="<?php echo esc_url(trx_addons_get_hash_link('#'.$trx_addons_tab_id.'_content')); ?>"><?php
								echo esc_html($trx_addons_section_title);
							?></a></li><?php
					}
				?></ul><?php
		}


		// Post content
		?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_description'); ?>_content" class="properties_page_section properties_page_content entry-content"<?php trx_addons_seo_snippets('articleBody'); ?>><?php
			if (trx_addons_get_option('properties_single_style') == 'tabs') {
				?><h3 class="properties_page_section_title"><?php echo esc_html($trx_addons_section_titles['description']); ?></h3><?php
			}
			the_content( );
		?></section><!-- .entry-content --><?php
        // Features
		// Return string with terms links
		if (!function_exists('trx_addons_get_post_terms_with_icon_single')) {
			function trx_addons_get_post_terms_with_icon_single($delimiter=', ', $id=false, $taxonomy='category', $links=true) {
				$output = '';
				if (empty($id)) $id = get_the_ID();
				if (empty($taxonomy)) $taxonomy = trx_addons_get_post_type_taxonomy(get_post_type($id));
				$terms = get_the_terms($id, $taxonomy);
				if ( !empty( $terms ) && is_array($terms) ) {
					$cnt = count($terms);
					$i = 0;
					$output .= '<div class="trx_addons_columns_wrap">';
					foreach( $terms as $term ) {
						if (empty($term->term_id)) continue;
						$i++;
						$icon_name = get_term_meta( $term->term_id, 'icon')[0];
						$output .= '<div class="trx_addons_column-1_2">';
						$output .= ($links
										? '<a href="' . esc_url( get_term_link( $term->term_id, $taxonomy ) ) . '"'
										. ' title="' . sprintf( esc_attr__( 'View all posts in %s', 'the-mounty' ), esc_attr($term->name) ) . '"'
										. '>'
										: '<span>'
								)
								. (!empty($icon_name) ? '<span class="properties_list_icon '. esc_attr($icon_name) .'"></span>' : '')
								. esc_html( $term->name )
								. ($i<$cnt ? $delimiter : '')
								. ($links ? '</a>' : '</span>');
						$output .= '</div>';
					}
					$output .= '</div>';
				}
				return $output;
			}
		}
		if (!empty(trx_addons_get_post_terms_with_icon_single(' ', get_the_ID(), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES))){
        ?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_features'); ?>_content" class="properties_page_section properties_page_features">
        <h3 class="properties_page_section_title"><?php echo esc_html($trx_addons_section_titles['features']); ?></h3>
        <div class="properties_page_features_list">
            <?php trx_addons_show_layout(trx_addons_get_post_terms_with_icon_single(' ', get_the_ID(), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_FEATURES)); ?>
        </div>
        </section><!-- .properties_page_features --><?php }
		if (!empty($trx_addons_meta['id']) ||
			!empty($trx_addons_meta['area_size']) ||
			!empty($trx_addons_meta['land_size']) ||
			!empty($trx_addons_meta['bedrooms']) ||
			!empty($trx_addons_meta['bathrooms']) ||
			!empty($trx_addons_meta['garages']) ||
			!empty($trx_addons_meta['built']) ||
			!empty($trx_addons_meta['details_enable'])
		){
		// Details
		?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_details'); ?>_content" class="properties_page_section properties_page_details">
			<h3 class="properties_page_section_title"><?php echo esc_html($trx_addons_section_titles['details']); ?></h3>
            <div class="trx_addons_columns_wrap">
            <?php
            $number_columns = (the_mounty_sidebar_present() ? '2' : '3');
			// ID
			if (!empty($trx_addons_meta['id'])) {
				?><div class="trx_addons_column-1_<?php echo esc_attr($number_columns); ?>"><span class="properties_page_section_item">
					<span class="properties_page_label"><?php esc_html_e('Property ID:', 'the-mounty'); ?></span>
					<span class="properties_page_data"><?php trx_addons_show_layout($trx_addons_meta['id']); ?></span>
				</span></div><?php
			}
			// Area size
			if (!empty($trx_addons_meta['area_size'])) {
				?><div class="trx_addons_column-1_<?php echo esc_attr($number_columns); ?>"><span class="properties_page_section_item">
					<span class="properties_page_label"><?php esc_html_e('Area size:', 'the-mounty'); ?></span>
					<span class="properties_page_data"><?php
						trx_addons_show_layout($trx_addons_meta['area_size']
												. ($trx_addons_meta['area_size_prefix'] 
														? ' ' . trx_addons_prepare_macros($trx_addons_meta['area_size_prefix'])
														: ''
													)
												);
					?></span>
				</span></div><?php
			}
			// Land size
			if (!empty($trx_addons_meta['land_size'])) {
				?><div class="trx_addons_column-1_<?php echo esc_attr($number_columns); ?>"><span class="properties_page_section_item">
					<span class="properties_page_label"><?php esc_html_e('Land size:', 'the-mounty'); ?></span>
					<span class="properties_page_data"><?php
						trx_addons_show_layout($trx_addons_meta['land_size']
												. ($trx_addons_meta['land_size_prefix'] 
														? ' ' . trx_addons_prepare_macros($trx_addons_meta['land_size_prefix'])
														: ''
													)
												);
					?></span>
				</span></div><?php
			}
			// Bedrooms
			if (!empty($trx_addons_meta['bedrooms'])) {
				?><div class="trx_addons_column-1_<?php echo esc_attr($number_columns); ?>"><span class="properties_page_section_item">
					<span class="properties_page_label"><?php esc_html_e('Bedrooms:', 'the-mounty'); ?></span>
					<span class="properties_page_data"><?php echo esc_html($trx_addons_meta['bedrooms']); ?></span>
				</span></div><?php
			}
			// Bathrooms
			if (!empty($trx_addons_meta['bathrooms'])) {
				?><div class="trx_addons_column-1_<?php echo esc_attr($number_columns); ?>"><span class="properties_page_section_item">
					<span class="properties_page_label"><?php esc_html_e('Bathrooms:', 'the-mounty'); ?></span>
					<span class="properties_page_data"><?php echo esc_html($trx_addons_meta['bathrooms']); ?></span>
				</span></div><?php
			}
			// Garages
			if (!empty($trx_addons_meta['garages'])) {
				?><div class="trx_addons_column-1_<?php echo esc_attr($number_columns); ?>"><span class="properties_page_section_item">
					<span class="properties_page_label"><?php esc_html_e('Garages:', 'the-mounty'); ?></span>
					<span class="properties_page_data"><?php
						trx_addons_show_layout($trx_addons_meta['garages']
												. ($trx_addons_meta['garage_size'] 
														? ' (' . trx_addons_prepare_macros($trx_addons_meta['garage_size']) . ')'
														: ''
													)
												);
					?></span>
				</span></div><?php
			}
			// Year built
			if (!empty($trx_addons_meta['built'])) {
				?><div class="trx_addons_column-1_<?php echo esc_attr($number_columns); ?>"><span class="properties_page_section_item">
					<span class="properties_page_label"><?php esc_html_e('Year built:', 'the-mounty'); ?></span>
					<span class="properties_page_data"><?php trx_addons_show_layout($trx_addons_meta['built']); ?></span>
				</span></div><?php
			}
			// Additional details
			if (!empty($trx_addons_meta['details_enable']) && !empty($trx_addons_meta['details']) && is_array($trx_addons_meta['details'])) {
                foreach ($trx_addons_meta['details'] as $detail) {
					if (!empty($detail['title'])) {
						?><div class="trx_addons_column-1_<?php echo esc_attr($number_columns); ?>"><span class="properties_page_section_item">
							<span class="properties_page_label"><?php
								trx_addons_show_layout(trx_addons_prepare_macros($detail['title'])); 
							?></span>
							<span class="properties_page_data"><?php 
								trx_addons_show_layout(trx_addons_prepare_macros($detail['value'])); 
							?></span>
						</span></div><?php
					}
				}
            }
            ?></div><?php
        ?></section><!-- .properties_page_details --><?php }
    
        // Book
        if (!empty($trx_addons_meta['button_book_text']) && !empty($trx_addons_meta['button_book_link'])) {
            ?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_book'); ?>_content" class="properties_page_section properties_page_book">
                <a href="<?php echo esc_attr($trx_addons_meta['button_book_link']); ?>" class="sc_button color_style_default sc_button_default sc_button_size_normal sc_button_icon_left"><span class="sc_button_text"><span class="sc_button_title"><?php echo esc_html($trx_addons_meta['button_book_text']); ?></span></span></a>
            </section><!-- .properties_page_video --><?php
        }

		// Floor plans
		if (!empty($trx_addons_meta['floor_plans_enable']) && !empty($trx_addons_meta['floor_plans']) 
			&& is_array($trx_addons_meta['floor_plans']) && !empty($trx_addons_meta['floor_plans'][0]['title'])) {
			?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_floor_plans'); ?>_content" class="properties_page_section properties_page_floor_plans">
				<h3 class="properties_page_section_title"><?php echo esc_html($trx_addons_section_titles['floor_plans']); ?></h3>
				<div class="properties_page_floor_plans_list trx_addons_accordion" data-collapsible="true"><?php
					foreach ($trx_addons_meta['floor_plans'] as $plan) {
						?><div class="properties_page_floor_plans_list_item">
							<h5 class="properties_page_floor_plans_list_item_title"><?php
								// Plan's title
								?><span class="properties_page_floor_plans_list_item_title_part">
									<span class="properties_page_data"><?php echo esc_html($plan['title']); ?></span>
								</span><?php
								// Floor size
								if (!empty($plan['area'])) {
									?><span class="properties_page_floor_plans_list_item_title_part">
										<span class="properties_page_label"><?php esc_html_e('Size:', 'the-mounty'); ?></span>
										<span class="properties_page_data"><?php echo esc_html($plan['area']); ?></span>
									</span><?php
								}
								// Bedrooms
								if (!empty($plan['bedrooms'])) {
									?><span class="properties_page_floor_plans_list_item_title_part">
										<span class="properties_page_label"><?php esc_html_e('Bedrooms:', 'the-mounty'); ?></span>
										<span class="properties_page_data"><?php echo esc_html($plan['bedrooms']); ?></span>
									</span><?php
								}
								// Bathrooms
								if (!empty($plan['bathrooms'])) {
									?><span class="properties_page_floor_plans_list_item_title_part">
										<span class="properties_page_label"><?php esc_html_e('Bathrooms:', 'the-mounty'); ?></span>
										<span class="properties_page_data"><?php echo esc_html($plan['bathrooms']); ?></span>
									</span><?php
								}
							?></h5>
							<div class="properties_page_floor_plans_list_item_content"><?php
								// Image
								if (!empty($plan['image'])) {
									$trx_addons_image = trx_addons_get_attachment_url($plan['image'], trx_addons_get_thumb_size('huge'));
									if (!empty($trx_addons_image)) {
										?><div class="properties_page_floor_plans_list_item_image"><?php
											$attr = trx_addons_getimagesize($trx_addons_image);
											?><img src="<?php echo esc_url($trx_addons_image); ?>" alt="<?php esc_attr_e( 'Image', 'the-mounty' ); ?>" <?php
												if (!empty($attr[3])) echo ' '.trim($attr[3]);
											?>><?php
										?></div><?php
									}
								}
								// Description
								if (!empty($plan['description'])) {
									?><div class="properties_page_floor_plans_list_item_description"><?php
										echo wp_kses($plan['description'], 'the_mounty_kses_content');
									?></div><?php
								}
							?></div>
						</div><?php
					}
				?></div>
			</section><!-- .properties_page_floor_plans --><?php
		}

		// Attachments
		if (!empty($trx_addons_meta['attachments'])) {
			$trx_addons_meta['attachments'] = explode('|', $trx_addons_meta['attachments']);
			if (is_array($trx_addons_meta['attachments']) && count($trx_addons_meta['attachments'])>0) {
				?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_attachments'); ?>_content" class="properties_page_section properties_page_attachments">
					<h3 class="properties_page_section_title"><?php echo esc_html($trx_addons_section_titles['attachments']); ?></h3><?php
					if (!empty($trx_addons_meta['attachments_description'])) {
						?><div class="properties_page_section_description"><?php
							echo wp_kses(nl2br($trx_addons_meta['attachments_description']), 'the_mounty_kses_content');
						?></div><?php
					}
					?><div class="properties_page_attachments_list"><?php
						foreach ($trx_addons_meta['attachments'] as $file) {
							?><a href="<?php echo esc_url($file); ?>"><?php	echo esc_html(basename($file));	?></a><?php
						}
					?></div>
				</section><!-- .properties_page_attachments --><?php
			}
		}


		// Video promo
		if (!empty($trx_addons_meta['video'])) {
			?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_video'); ?>_content" class="properties_page_section properties_page_video">
				<h3 class="properties_page_section_title"><?php echo esc_html($trx_addons_section_titles['video']); ?></h3><?php
					if (!empty($trx_addons_meta['video_description'])) {
						?><div class="properties_page_section_description"><?php
							echo wp_kses(nl2br($trx_addons_meta['video_description']), 'the_mounty_kses_content');
						?></div><?php
					}
				?><div class="properties_page_video_wrap"><?php
					trx_addons_show_layout(trx_addons_get_video_layout(array(
																			'link' => $trx_addons_meta['video']
																		)));
				?></div>
			</section><!-- .properties_page_video --><?php
		}


		// Virtual tour
		if (!empty($trx_addons_meta['virtual_tour'])) {
			?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_virtual_tour'); ?>_content" class="properties_page_section properties_page_virtual_tour">
				<h3 class="properties_page_section_title"><?php echo esc_html($trx_addons_section_titles['virtual_tour']); ?></h3><?php
					if (!empty($trx_addons_meta['virtual_tour_description'])) {
						?><div class="properties_page_section_description"><?php
							echo wp_kses(nl2br($trx_addons_meta['virtual_tour_description']), 'the_mounty_kses_content');
						?></div><?php
					}
				?><div class="properties_page_virtual_tour_wrap"><?php
					if (strpos($trx_addons_meta['virtual_tour'], '<')===false) {
						?><iframe src="<?php
							echo esc_url($trx_addons_meta['virtual_tour']);
							?>" frameborder="0" width="1170" height="658"></iframe><?php
					} else
						trx_addons_show_layout($trx_addons_meta['virtual_tour']);
				?></div>
			</section><!-- .properties_page_virtual_tour --><?php
		}


		// Google map
		if (!empty($trx_addons_meta['show_map']) && !empty($trx_addons_meta['location'])) {
			?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_attachments'); ?>_content" class="properties_page_section properties_page_attachments">
				<h3 class="properties_page_section_title"><?php echo esc_html($trx_addons_section_titles['googlemap']); ?></h3><?php
				?><div class="properties_page_map"><?php
					trx_addons_show_layout(trx_addons_sc_properties(array(
																		'type' => 'googlemap',
																		'ids' => get_the_ID()
																		)));
				?></div>
			</section><!-- .properties_page_googlemap --><?php
		}


		// Agent info
		if (!empty($trx_addons_meta['agent_type']) 
			&& $trx_addons_meta['agent_type']!='none' 
			&& ($trx_addons_meta['agent_type']=='author' || $trx_addons_meta['agent']!=0)) {
			?><section id="<?php echo esc_attr($trx_addons_tabs_id.'_contacts'); ?>_content" class="properties_page_section properties_page_agent">
				<h3 class="properties_page_section_title"><?php echo esc_html($trx_addons_section_titles['contacts']); ?></h3>
				<div class="properties_page_agent_wrap"<?php trx_addons_seo_snippets('author', 'Person'); ?>><?php
					trx_addons_get_template_part(TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.parts.agent.php',
													'trx_addons_args_properties_agent',
													array('meta' => $trx_addons_meta)
												);
				?></div>
			</section><!-- .properties_page_agent --><?php
		}

		// Close tabs wrapper
		if (trx_addons_get_option('properties_single_style') == 'tabs') {
			?></div><!-- /.trx_addons_tabs properties_page_tabs --><?php
		}

		do_action('trx_addons_action_after_article', 'properties.single');

	?></article><?php
	
	
	// Related items
	$taxonomies = array();
	// Select objects in same city
	$terms = get_the_terms(get_the_ID(), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY);
	if ( !empty( $terms ) ) {
		$taxonomies[TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY] = array();
		foreach( $terms as $term )
			$taxonomies[TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_CITY][] = $term->term_id;
	}

	$trx_addons_related_style   = explode('_', trx_addons_get_option('properties_blog_style'));
	$trx_addons_related_type    = $trx_addons_related_style[0];
	$trx_addons_related_columns = empty($trx_addons_related_style[1]) ? 1 : max(1, $trx_addons_related_style[1]);
	
	trx_addons_get_template_part('templates/tpl.posts-related.php',
										'trx_addons_args_related',
										apply_filters('trx_addons_filter_args_related', array(
															'class' => 'properties_page_related sc_properties sc_properties_'.esc_attr($trx_addons_related_type),
															'posts_per_page' => $trx_addons_related_columns,
															'columns' => $trx_addons_related_columns,
															'template' => TRX_ADDONS_PLUGIN_CPT . 'properties/tpl.properties.'.trim($trx_addons_related_type).'-item.php',
															'template_args_name' => 'trx_addons_args_sc_properties',
															'post_type' => TRX_ADDONS_CPT_PROPERTIES_PT,
															'taxonomies' => $taxonomies
															)
													)
									);

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
?>
<article <?php post_class( 'post_item_single post_item_404 post_item_none_search' ); ?>>
	<div class="post_content">
		<h1 class="page_title"><?php esc_html_e( 'No results', 'the-mounty' ); ?></h1>
		<div class="page_info">
			<h3 class="page_subtitle"><?php
				// Translators: Add the query string
				echo esc_html(sprintf(__("We're sorry, but your search \"%s\" did not match", 'the-mounty'), get_search_query()));
			?></h3>
			<p class="page_description"><?php
				// Translators: Add the site URL to the link
				echo wp_kses_data( sprintf( __("Can't find what you need? Take a moment and do a search below or start from <a href='%s'>our homepage</a>.", 'the-mounty'), esc_url(home_url('/')) ) );
			?></p>
			<?php do_action('the_mounty_action_search', 'normal', 'page_search', false); ?>
		</div>
	</div>
</article>

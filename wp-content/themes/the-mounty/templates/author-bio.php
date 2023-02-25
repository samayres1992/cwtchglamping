<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */
?>

<div class="author_info scheme_default author vcard" itemprop="author" itemscope itemtype="//schema.org/Person">

	<div class="author_avatar" itemprop="image">
		<?php 
		$the_mounty_mult = the_mounty_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 150*$the_mounty_mult );
		?>
	</div><!-- .author_avatar -->

	<div class="author_description">
		<h4 class="author_title" itemprop="name"><?php
			// Translators: Add the author's name in the <span> 
			echo wp_kses_data(sprintf(__('About %s', 'the-mounty'), '<span class="fn">'.get_the_author().'</span>'));
		?></h4>

		<div class="author_bio" itemprop="description">
			<?php echo wp_kses(wpautop(get_the_author_meta( 'description' )), 'the_mounty_kses_content'); ?>
			<a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php
				// Translators: Add the author's name in the <span> 
				printf( esc_html__( 'View all posts by %s', 'the-mounty' ), '<span class="author_name">' . esc_html(get_the_author()) . '</span>' );
			?></a>
			<?php do_action('the_mounty_action_user_meta'); ?>
		</div><!-- .author_bio -->

	</div><!-- .author_description -->

</div><!-- .author_info -->

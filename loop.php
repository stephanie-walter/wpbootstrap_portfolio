<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage wpbootstrap
 * @since wpbootstrap 0.1
 */
?>
<?php 
	// Filters for adding classes to various functions
	$comments_link_attributes_css = 'btn small primary';
?>


<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
		
		<div class="page-header">
			<h1><?php _e( 'Not Found', 'twentyten' ); ?></h1>
		</div>
		
		<div class="alert-message block-message error">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyten' ); ?></p>
			<div class="alert-actions"
				<?php get_search_form(); ?>
			</div>
		</div>

<?php endif; ?>

<?php 
	global $sa_options;
	$sa_settings = get_option( 'sa_options', $sa_options );
?>

<?php
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>

<?php 
// Set the first post value to 1, outside the loop
if ( ( is_paged() == false && $sa_settings['compact_homepage'] == '1' ) || ( $sa_settings['compact_homepage'] == false ) ) { $firstpost  = '1'; }
?>

<?php while ( have_posts() ) : the_post(); ?>


			<?php
				if ( $firstpost == '1' ) :
			?>
	<article>
				<div class="page-header">
					<h1>
						<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h1>
				</div> <!-- /page-header -->
			<?php endif; ?>

			<?php
				if ( $firstpost == '' ) :
			?>
				<div class="page-header" style="margin-top: 50px;">
					<h2>
						<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h2>
				</div> <!-- /page-header -->
			<?php endif; ?>
	
			<?php
			// Compact home page if start
				if ( $firstpost == '1' ) :
			?>
			
			<div class="post_content clearfix">
				<?php if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) { the_post_thumbnail(array(300,300), array("class" => "alignleft post_thumbnail")); } ?>
				<?php if ( is_archive() || is_search() || is_home() )  : // Only display excerpts for archives and search. ?>
						<?php the_excerpt(); ?>
				<?php else : ?>
						<?php the_content( __( 'Continue reading &rarr;', 'twentyten' ) ); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'twentyten' ), 'after' => '' ) ); ?>
				<?php endif; ?>
			</div>

			<p class="muted">
				
				<?php if ( count( get_the_category() ) ) : ?>
					<span class="cat-links">
						<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-cat-links', get_the_category_list( ', ' ) ); ?>
					</span>
				<?php endif; ?>
				<?php
					$tags_list = get_the_tag_list( '', ', ' );
					if ( $tags_list ):
				?>
					<span class="tag-links">
						<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'twentyten' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list ); ?>
					</span>
				<?php endif; ?>
				
			</p>

			<hr />

	</article>

	<?php
	// Block this part of the loop by setting $firstpost to '0'
		if( $sa_settings['compact_homepage'] == '1' && is_home() == true) { $firstpost = ''; }
	?>
		
	<?php
	// Compact home page if end
	 endif; ?>



<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<div class="pagination">
		<ul>
			<li class="prev">
				<?php next_posts_link( __( '&larr; Older posts', 'twentyten' ) ); ?>
			</li>
			<li class="next">
				<?php previous_posts_link( __( 'Newer posts &rarr;', 'twentyten' ) ); ?>
			</li>
		</ul>
	</div>
<?php endif; ?>
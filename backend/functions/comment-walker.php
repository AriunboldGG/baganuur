<?php
	class baganuur_ut_comment_walker extends Walker_Comment {
		var $tree_type = 'comment';
		var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );
 
		// constructor – wrapper for the comments list
		function __construct() { ?>

			<section class="comments-list clearfix">

		<?php }

		// start_lvl – wrapper for child comments list
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>
			
			<section class="child-comments comments-list">

		<?php }
	
		// end_lvl – closing wrapper for child comments list
		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			</section>

		<?php }

		// start_el – HTML for comment template
		function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
                        $m_width = 870 - $depth * 50;
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); 
	
			if ( 'article' == $args['style'] ) {
				$tag = 'article';
				$add_below = 'comment';
			} else {
				$tag = 'article';
				$add_below = 'comment';
			} ?>

			<article <?php comment_class(empty( $args['has_children'] ) ? '' :'parent') ?> id="comment-<?php comment_ID() ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
				<div class="comment-content post-content" itemprop="text" style="max-width: <?php echo esc_html($m_width) ?>px">
                                        <figure class="gravatar"><?php echo get_avatar( $comment, 256 ); ?></figure>
                                        <div class="comment-meta post-meta" role="complementary">
                                                <div class="comment-author">
                                                        <a class="comment-author-link" href="<?php comment_author_url(comment_ID()); ?>" itemprop="author"><?php echo comment_author(); ?></a>
                                                </div>
                                                <time class="comment-meta-item" datetime="<?php comment_date('Y-m-d') ?>T<?php comment_time('H:iP') ?>" itemprop="datePublished"><?php comment_date('F j, Y / g:i a') ?></time>
                                                <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                                                <?php edit_comment_link('<p class="comment-meta-item pull-left">' . esc_html__('Edit', 'baganuur') . '</p>','',''); ?>
                                                <?php if ($comment->comment_approved == '0') : ?>
                                                <p class="comment-meta-item"><?php esc_html_e('Your comment is awaiting moderation.', 'baganuur'); ?></p>
                                                <?php endif; ?>
                                                <?php comment_text(); ?>
                                        </div>
				</div>

		<?php }

		// end_el – closing HTML for comment template
		function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>

			</article>

		<?php }

		// destructor – closing wrapper for the comments list
		function __destruct() { ?>

			</section>
		
		<?php }

	}
?>
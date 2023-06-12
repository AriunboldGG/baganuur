<?php
/*
  The template for displaying comments
 
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <div class="comments-title">
            <?php
            printf(_nx('1 Comment', '%1$s Comments', get_comments_number(), 'comment title', 'baganuur'), number_format_i18n(get_comments_number()));
            ?>
        </div>

        <?php baganuur_ut_comment_nav(); ?>

            <?php
            wp_list_comments(array(
                'walker' => new baganuur_ut_comment_walker(),
                'style' => 'ul',
                'short_ping' => true,
            ));
            ?>

        <?php baganuur_ut_comment_nav(); ?>

    <?php endif; // have_comments() ?>

    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
//    if ( !comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments' ) ) :
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
        ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'baganuur' ); ?></p>
    <?php endif; ?>

    <?php
    comment_form(
            array(
                'comment_field' => '<div class="row"><div class="col-md-12"><div class="comment-form-comment"><p class="comment-form-text">' . esc_html__('Comment', 'baganuur') . '</p><textarea name="comment" id="comment" class="required" rows="5" tabindex="4"></textarea></div></div></div>',
                'title_reply' => esc_html__('Leave a Comment', 'baganuur' ),
                'comment_notes_after' => '',
                'comment_notes_before' => '',
                'logged_in_as' =>  '',
                'fields'       => array(
                        'author' => '<div class="row"><div class="col-md-6"><div class="comment-form-author">' .
                                    '<p class="comment-form-text">' . esc_html__('Name', 'baganuur') . '</p>' .
                                    '<input id="author" name="author" type="text" value="" size="30" aria-required="true" /></div></div>',
                        'email'  => '<div class="col-md-6"><div class="comment-form-email">' .
                                    '<p class="comment-form-text">' . esc_html__('Email*', 'baganuur') . '</p>' .
                                    '<input id="email" name="email" type="text" value="" size="30" aria-required="true" /></div></div></div>',
                ),
                'class_submit' => 'comment-btn btn',
                'label_submit' => esc_html__('post comment', 'baganuur'),
            )
    );
    ?>

</div>

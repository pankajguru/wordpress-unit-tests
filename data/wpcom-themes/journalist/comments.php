<?php // Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

if (post_password_required()) {
	?>
		
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'journalist') ;?><p>
		
	<?php
	return;
}


function journalist_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li id="comment-<?php comment_ID() ?>" <?php comment_class(tj_comment_class()); ?>>
	<div id="div-comment-<?php comment_ID() ?>">
	<div class="comment_mod">
	<?php if ($comment->comment_approved == '0') : ?>
	<em><?php _e('Your comment is awaiting moderation.', 'journalist'); ?></em>
	<?php endif; ?>
	</div>
	
	<div class="comment_text">
	<?php comment_text() ?>
	</div>
	
	<div class="comment_author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<p><strong class="fn"><?php comment_author_link() ?></strong></p>
	<p><small>
		<?php printf(__('%s at %s','journalist'), get_comment_date(),
		    '<a href="#comment-'.get_comment_ID().'">'.get_comment_time().'</a>'); ?>
		<?php edit_comment_link(__('Edit','journalist'), ' ', ''); ?>
	</small></p>
	</div>
	<div class="clear"></div>
	
	<div class="reply">
		<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	</div>
<?php
}


?>

<a name="comments" id="comments"></a>

<?php if (have_comments()) : ?>
<h3 class="reply"><?php comments_number(__('No Responses Yet', 'journalist'), __('One Response', 'journalist'), __('% Responses', 'journalist') );?></h3> 
<p class="comment_meta"><?php printf( __('Subscribe to comments with <a href="%s">RSS</a>.', 'journalist'), get_post_comments_feed_link() ); ?></p>

<ol class="commentlist">
<?php wp_list_comments(array('callback'=>'journalist_comment')); ?>
</ol>
<div class="navigation">
	<div class="alignleft"><?php previous_comments_link() ?></div>
	<div class="alignright"><?php next_comments_link() ?></div>
</div>
<br />

	<?php if (!comments_open()) : ?> 
	<p class="nocomments"><?php _e('Comments are closed.','journalist'); ?></p>
	<?php endif; ?>
<?php endif; ?>


<?php if (comments_open()) : ?>
<div id="respond">

<h3 class="reply"><?php comment_form_title( __('Leave a Reply', 'journalist'), __('Leave a Reply to %s','journalist') ); ?></h3>
<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'journalist'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<div class="postinput">
<?php if ( $user_ID ) : ?>

<p class="logged"><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.', 'journalist'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', 'journalist'); ?>"><?php _e('Log out &raquo;', 'journalist'); ?></a></p>

<?php else : ?>
<p><input class="comment" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><?php _e('Name','journalist'); ?> <?php if ($req) echo __('(required)','journalist'); ?></small></label></p>

<p><input class="comment" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('E-mail (will not be published)','journalist'); ?> <?php if ($req) echo __('(required)','journalist'); ?></small></label></p>

<p><input class="comment" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website','journalist'); ?></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> <?php _e('You can use these tags:','journalist'); ?> <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input class="submit" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment', 'journalist'); ?>" title="<?php _e('Please review your comment before submitting', 'journalist'); ?>" />
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>
</div>
</form>

<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>

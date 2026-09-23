<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Пожалуйста, не загружайте данную страницу напрямую. Спасибо!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">Эта запись защищена пароль. Введите пароль, чтобы добавить комментарий</p>
	<?php
		return;
	}
?>
	
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p>Вы должны <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">войти</a>, чтобы добавить комментарий.</p>
	<script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>
	Также Вы можете войти используя:
	<noindex>
	<a href="https://loginza.ru/api/widget?token_url=<?php echo urlencode(get_permalink()); ?>" class="loginza">
		<img src="http://loginza.ru/img/providers/vkontakte.png" alt="Вконтакте" title="Вконтакте">
		<img src="http://loginza.ru/img/providers/twitter.png" alt="Twitter" title="Twitter">
		<img src="http://loginza.ru/img/providers/yandex.png" alt="Yandex" title="Yandex">
		<img src="http://loginza.ru/img/providers/google.png" alt="Google" title="Google Accounts">
		<img src="http://loginza.ru/img/providers/mailru.png" alt="Mail.ru" title="Mail.ru">	
		<img src="http://loginza.ru/img/providers/loginza.png" alt="Loginza" title="Loginza">
		<img src="http://loginza.ru/img/providers/myopenid.png" alt="MyOpenID" title="MyOpenID">
		<img src="http://loginza.ru/img/providers/openid.png" alt="OpenID" title="OpenID">
		<img src="http://loginza.ru/img/providers/webmoney.png" alt="WebMoney" title="WebMoney">
	</a>
	</noindex>
	<br><br><br><br><br>
	<?php else :?>
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<div class="h3"><?php comments_number();?></div>
		<div class="avatar"><?php echo get_avatar($user_ID,'50'); ?></div>
		<div class="addcomment">
		<?php if (!$user_ID ) : ?>
		<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
		<label for="author">Имя <?php if ($req) echo "(обязательный)"; ?></label>
		<br>
		<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
		<label for="email">Mail (не публикуется) <?php if ($req) echo "(обязательный)"; ?></label>
		<br>
		<?php endif; ?>
		<textarea name="comment" id="comment" tabindex="4"></textarea>
		<br><br>
		<?php comment_id_fields(); ?>
		<input name="submit" type="submit" tabindex="5" id="submitcomment" value="Отправить" />
		</div>
		<div class="clear"></div>
		<?php do_action('comment_form', $post->ID); ?>
	</form>
<?php endif;?>

<?php if ( have_comments() ) : ?>
	<?php wp_list_comments('type=comment&callback=modern_comment'); ?>
<?php endif;?>
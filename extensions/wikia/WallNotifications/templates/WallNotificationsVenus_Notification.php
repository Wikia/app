<li class="notification <?= $isUnread ?>">
	<a href="<?= $url ?>">
		<div class="avatars">
			<?= $authors[0]['avatar'] ?>
		</div>
		<div class="notification-message">
			<h4><?= $title ?></h4>
			<? if( $unread ): ?>
				<p><?= $msg ?></p>
			<? endif; ?>
			<time datetime="<?= $iso_timestamp ?>">timeage</time>
		</div>
	</a>
</li>
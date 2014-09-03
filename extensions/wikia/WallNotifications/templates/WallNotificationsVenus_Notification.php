<li class="notification <?= $isUnread ?>">
	<a href="<?= $url ?>">
		<div class="avatars">
			<?php foreach($authors as $key => $author): ?>
				<?= $author['avatar'] ?>
			<?php endforeach; ?>
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
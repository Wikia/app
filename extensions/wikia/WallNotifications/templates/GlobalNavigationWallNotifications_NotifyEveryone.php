<li class="notification <?= $isUnread ?> admin-notification">
	<a href="<?= $url ?>">
		<div class="notification-message">
			<h4><?= $title ?></h4>
			<p><?php echo wfMessage('wall-notifications-notifyeveryone', $authors[0])->text(); ?></p>
			<time datetime="<?= $iso_timestamp ?>"></time>
		</div>
	</a>
</li>

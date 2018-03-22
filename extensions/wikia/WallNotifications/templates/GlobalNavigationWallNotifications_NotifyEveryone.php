<li class="notification <?= $isUnread ?> admin-notification">
	<a href="<?= $url ?>">
		<div class="notification-message">
			<h4><?= $title ?></h4>
			<p><?= wfMessage( 'wall-notifications-notifyeveryone', $authors[0] )->escaped(); ?></p>
			<time datetime="<?= $iso_timestamp ?>"></time>
		</div>
	</a>
</li>

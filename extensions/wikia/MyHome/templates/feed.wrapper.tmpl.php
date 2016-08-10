<h2 class="dark_text_2"><?= $typeMessage ?></h2>
<?= $defaultSwitch ?>
<div id="myhome-<?= $type ?>-feed-content">
	<?= $content ?>
</div>
<?php if ( !empty( $showMore ) ): ?>
	<div class="myhome-feed-more">
		<a id="myhome-<?= $type ?>-feed-more" onclick="MyHome.fetchMore(this);" rel="nofollow">
			<?= wfMessage( 'myhome-activity-more' )->escaped(); ?>
		</a>
	</div>
<?php endif; ?>

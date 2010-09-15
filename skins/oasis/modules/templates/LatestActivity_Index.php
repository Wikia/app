<section class="WikiaActivityModule">
	<h1><?= wfMsg('oasis-activity-header') ?></h1>
	<?= View::specialPageLink('CreatePage', 'button-createpage', 'wikia-button createpage', 'blank.gif', 'oasis-create-page', 'osprite icon-add'); ?>
	<details class="tally">
		<em><?= $total ?></em> <?= wfMsg('oasis-total-articles-mainpage') ?>
	</details>
	<ul>
<?php
	foreach ($changeList as $item) {
?>
		<li>
			<img src="<?= $item['avatar_url'] ?>" class="avatar" height="20" width="20">
			<em><?= $item['page_href'] ?></em>
			<details><?= $item['time_ago'] ?> <?= wfMsg('myhome-feed-by', $item['user_href']) ?></details>
		</li>
<?php
	}
?>
	</ul>
	<?= View::specialPageLink('WikiActivity', 'oasis-more', 'more') ?>
</section>

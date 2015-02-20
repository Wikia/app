<section class="WikiaActivityModule module" id="WikiaRecentActivity">
	<h1 class="activity-heading"><?= $moduleHeader ?></h1>
	<ul>
<?php
	if(!empty($changeList)){
		foreach ($changeList as $item) {
?>
		<li>
			<img src="<?= $wg->BlankImgUrl ?>" class="sprite <?= $item['changeicon'] ?>" height="20" width="20">
			<em><?= $item['page_href'] ?></em>
			<div class="edited-by"><?= $item['changemessage'] ?></div>
		</li>
<?php
		}
	}
?>
	</ul>
	<?= Wikia::specialPageLink('WikiActivity', 'oasis-more', 'more') ?>
</section>

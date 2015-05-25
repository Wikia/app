<section class="WikiaActivityModule module" id="WikiaRecentActivity">
	<h2 class="activity-heading"><?= wfMessage( 'oasis-activity-header' )->escaped() ?></h2>
	<ul>
	<? foreach ( $changeList as $item ) { ?>
		<li>
			<img src="<?= $wg->BlankImgUrl ?>" class="sprite <?= $item['type'] ?>" height="20" width="20">
			<em><a href="<?= $item['url'] ?>"><?= $item['title'] ?></a></em>
			<div class="edited-by"><?= $item['change'] ?></div>
		</li>
	<? } ?>
	</ul>
	<?= Wikia::specialPageLink( 'WikiActivity', 'oasis-more', 'more' ) ?>
</section>

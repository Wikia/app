<section class="WikiaActivityModule module" id="<?= !empty( $userName ) ? 'WikiaRecentActivityUser' : 'WikiaRecentActivity'; ?>">
	<h2 class="activity-heading"><?= $moduleHeader ?></h2>
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
	elseif(!empty($userName)) {
		echo wfMsg( 'userprofilepage-recent-activity-default', $userName );
	}
?>
	</ul>

	<? if ( $userName && count($changeList) ) :?>
		<?= Wikia::specialPageLink('Contributions/' . $userName, 'userprofilepage-top-recent-activity-see-more', 'more') ;?>
	<? elseif(empty($userName)): ?>
		<?= Wikia::specialPageLink('WikiActivity', 'oasis-more', 'more') ?>
	<? endif ;?>
</section>

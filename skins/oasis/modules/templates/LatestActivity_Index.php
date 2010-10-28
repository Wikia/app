<section class="WikiaActivityModule <?= !empty( $userName ) ? 'UserProfileRailModule_RecentActivity' : ''; ?>">
	<? if (!$wgSingleH1) { ?>
		<h1 class="activity-heading"><?= $moduleHeader ?></h1>
	<? } else { ?>
		<div class="headline-div activity-heading"><?= $moduleHeader ?></div>
	<? } ?>
	<ul>
<?php
	if(!empty($changeList)){
		foreach ($changeList as $item) {
?>
		<li>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite <?= $item['changeicon'] ?>" height="20" width="20">
			<em><?= $item['changemessage'] ?></em>
			<details><?= $item['time_ago'] ?></details>
		</li>
<?php
		}
	}
?>
	</ul>

	<? if ( $isUserProfilePageExt && count($changeList) ) :?>
		<?= View::specialPageLink('Contributions/' . $userName, 'userprofilepage-top-recent-activity-see-more', 'more') ;?>
	<? else: ?>
		<?= View::specialPageLink('WikiActivity', 'oasis-more', 'more') ?>
	<? endif ;?>
</section>

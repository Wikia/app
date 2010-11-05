<section class="WikiaActivityModule module <?= !empty( $userName ) ? 'UserProfileRailModule_RecentActivity' : ''; ?>">
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
	elseif(!empty($userName)) {
		echo wfMsg( 'userprofilepage-recent-activity-default', $userName );
	}
?>
	</ul>

	<? if ( $userName && count($changeList) ) :?>
		<?= View::specialPageLink('Contributions/' . $userName, 'userprofilepage-top-recent-activity-see-more', 'more') ;?>
	<? elseif(empty($userName)): ?>
		<?= View::specialPageLink('WikiActivity', 'oasis-more', 'more') ?>
	<? endif ;?>
</section>

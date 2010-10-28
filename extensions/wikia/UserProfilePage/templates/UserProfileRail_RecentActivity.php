<section class="UserProfileRailModule_RecentActivity WikiaActivityModule">
	<h1 class="activity-heading"><?= wfMsg( 'userprofilepage-recent-activity-title', $userName, $wikiName ) ;?></h1>
	<ul class="activity_feed">
		<?if ( count($activityFeed) ) :?>

				<? foreach( $activityFeed as $row ) :?>
					<li>
						<img src="<?= wfBlankImgUrl() ?>" class="sprite <?= $row['changeicon'] ?>" height="20" width="20">
						<em><?= $row['changemessage'] ?></em>
						<details><?= $row['time_ago'] ?></details>
					</li>
				<? endforeach ;?>
		<? else :?>
			<li>
				<img src="<?= wfBlankImgUrl() ?>" class="sprite ok" height="20" width="20">
				<em><?= wfMsg( 'userprofilepage-recent-activity-default', $userName ) ;?></em>
				<details><?= $userRegistrationDate ?></details>
			</li>
		<? endif ;?>
	</ul>

	<?if ( count($activityFeed) ) :?>
		<a class="more view-all" href="<?= $specialContribsLink ;?>"><?= wfMsg( 'userprofilepage-top-recent-activity-see-more' ); ?> &gt;</a>
	<? endif ;?>
</section>

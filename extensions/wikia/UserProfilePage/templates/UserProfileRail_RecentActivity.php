<section class="WikiaActivityModule">
	<h1 class="activity-heading"><?= wfMsg( 'userprofilepage-recent-activity-title', $userName, $wikiName ) ;?></h1>
	<?if ( count($activityFeed) ) :?>
		<ul class="activity_feed">
			<? foreach( $activityFeed as $row ) :?>
				<li>
					<img src="<?= wfBlankImgUrl() ?>" class="sprite <?= $row['changeicon'] ?>" height="20" width="20">
					<em><?= $row['changemessage'] ?></em>
					<details><?= $row['time_ago'] ?></details>
				</li>
			<? endforeach ;?>
		</ul>

		<a class="more view-all" href="<?= $specialContribsLink ;?>"><?= wfMsg( 'userprofilepage-top-recent-activity-see-more' ); ?> &gt;</a>

	<? else :?>
		<?= wfMsg( 'userprofilepage-recent-activity-default', $userName ) ;?>
	<? endif ;?>
</section>

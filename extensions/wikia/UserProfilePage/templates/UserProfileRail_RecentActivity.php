<section class="WikiaActivityModule">
	<h1 class="activity-heading"><?= wfMsg( 'userprofilepage-recent-activity-title', $userName, $wikiName ) ;?></h1>
	<?if ( count($activityFeed) ) :?>
		<ul class="activity_feed">
			<? foreach( $activityFeed as $row ) :?>
				<li>
					<?= FeedRenderer::getSprite( $row, wfBlankImgUrl() ) ;?>
					<em><a href="<?= htmlspecialchars( $row['url'] ) ;?>" class="title" rel="nofollow"><?= htmlspecialchars( $row['title'] ) ;?></a></em>
					<details><?= FeedRenderer::formatTimestamp( $row['timestamp'] );?></details>
				</li>
			<? endforeach ;?>
		</ul>

		<a class="more view-all" href="<?= $specialContribsLink ;?>"><?= wfMsg( 'userprofilepage-top-recent-activity-see-more' ); ?> &gt;</a>
		
	<? else :?>
		<?= wfMsg( 'userprofilepage-recent-activity-default', $userName ) ;?>
	<? endif ;?>
</section>
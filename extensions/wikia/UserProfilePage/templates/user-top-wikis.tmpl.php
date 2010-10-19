<div id="profile-top-wikis-body">
	<?php foreach( $topData as $wikiId => $wikiData ): ?>
		<div class="uppWikiBox">
			<?php if($isOwner): ?>
				<a href="#" class="HideButton" title="<?=$wikiId;?>">[x]</a>
			<?php endif; ?>
			<a href="<?=$wikiData['wikiUrl'];?><?=$userPageUrl;?>" title="<?=$wikiData['wikiName'];?>">
				<img alt="<?=$wikiData['wikiName'];?>" src="<?=$wikiData['wikiLogo'];?>" width="102" height="73" align="middle" />
			</a>
			<div><?= $wikiData['wikiName']; ?> (<?= wfMsg( 'userprofilepage-wiki-edits', array( $wikiData['editCount'] ) ); ?>)</div>
			<!-- wordmark! -->
		</div>
	<?php endforeach; ?>
	<?php if($isOwner): ?>
		<!-- hidden top wikis -->
		<div id="profile-top-pages-hidden">
			<strong><?= wfMsg( 'userprofilepage-hidden-top-wikis-section-title' ); ?></strong><br />
			<?php foreach( $topDataHidden as $wikiId => $wikiData ): ?>
				<a class="UnhideButton" title="<?= $wikiId; ?>">[x]</a>&nbsp;
				<a href="<?=$wikiData['wikiUrl'];?><?= $wikiData['wikiName']; ?></a><br />
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

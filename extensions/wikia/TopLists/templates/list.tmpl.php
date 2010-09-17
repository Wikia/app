<div id="toplists-list-body">
	<?php if( !empty($relatedImage) ): ?>
		[[File:<?= $relatedImage[ 'name' ] ;?>|thumb]]
		<?/* if($relatedTitle instanceof Title) :?>
			<div class="thumbcaption">
				<div class="magnify">
					<a href="/wiki/File:Images234234234234.jpg" class="internal" title="Enlarge">
						<img src="http://images1.wikia.nocookie.net/__cb21710/common/skins/common/blank.gif" class="sprite details" width="16" height="16" alt="">
					</a>
				</div>
				<?= wfMsg( 'toplists-list-related-to' ); ?> <a href="<?= $relatedTitle->getLocalUrl(); ?>"><?= $relatedTitle->getText(); ?></a>
			</p>
		<? endif ;*/?>
	<?php elseif($relatedTitle instanceof Title): ?>
		<div class="ListRelatedArticle">
			<?= wfMsg( 'toplists-list-related-to' ); ?> <a href="<?= $relatedTitle->getLocalUrl(); ?>"><?= $relatedTitle->getText(); ?></a>
		</div>
	<?php endif; ?>

	<?php if($relatedTitle instanceof Title): ?>
	<?php endif; ?>
	<ul>
	<? foreach ( $list->getItems() as $index => $item ) :?>
		<li>
			<div class="ItemNumber">
				#<?= ( ++$index ) ;?>
				<div class="button item-vote-button" id="<?= $item->getTitleText() ;?>"><?= wfMsg( 'toplists-list-vote-up' ) ;?></div>
			</div>
			<div class="ItemContent">
				<?= $item->getArticle()->getContent() ;?>
				<p class="author"><?= wfMsg( 'toplists-list-created-by', array( $item->getCreatorUserName() )) ;?></p>
			</div>
			<div class="ItemVotes"><?= wfMsg( 'toplists-list-votes-num', array( $item->getVotesCount() ) ) ;?></div>
		</li>
	<? endforeach; ?>
	</ul>
</div>
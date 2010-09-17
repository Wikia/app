<div id="toplists-list-body">
	<?php if( !empty($relatedImage) ): ?>
		<div class="ListPicture">
			<a href="<?= $relatedUrl?>" class="image">
				<img src="<?= $relatedImage['url']; ?>" alt="<?= $relatedImage['name']; ?>" title="<?= $relatedImage['name']; ?>" />
			</a>
			<? if($relatedTitle instanceof Title) :?>
				<p>
					<?= wfMsg( 'toplists-list-related-to' ); ?> <a href="<?= $relatedTitle->getLocalUrl(); ?>"><?= $relatedTitle->getText(); ?></a>
				</p>
			<? endif ;?>
		</div>
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
				<a href="#" class="wikia-button item-vote-button" id="<?= $item->getTitleText() ;?>" ><?= wfMsg( 'toplists-list-vote-up' ) ;?></a>
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
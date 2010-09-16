<div id="toplists-list-body">
	<?php if( !empty($relatedImage) ): ?>
		<div class="ImageBrowser">
			<div class="frame">
			<a href="<?= $relatedUrl?>" class="image">
				<img id="toplists-related-article-img" src="<?= $relatedImage['url']; ?>" alt="<?= $relatedImage['name']; ?>" title="<?= $relatedImage['name']; ?>" class="thumbimage" />
			</a>
			</div>
		</div>
	<?php elseif($relatedTitle instanceof Title): ?>
		<div id="toplist-related-article">
			<?= wfMsg( 'toplists-list-related-to' ); ?> <a href="<?= $relatedTitle->getLocalUrl(); ?>"><?= $relatedTitle->getText(); ?></a>
		</div>
	<?php endif; ?>

	<?php if($relatedTitle instanceof Title): ?>
	<?php endif; ?>
	<ul>
	<? foreach ( $list->getItems() as $index => $item ) :?>
		<li>
			<strong>#<?= ( ++$index ) ;?></strong>
			<a href="#" class="wikia-button item-vote-button" id="<?= $item->getTitleText() ;?>" ><?= wfMsg( 'toplists-list-vote-up' ) ;?></a>
			<?= $item->getArticle()->getContent() ;?>
			<p><?= wfMsg( 'toplists-list-votes-num', array( $item->getVotesCount() ) ) ;?></p>
			<p><?= wfMsg( 'toplists-list-created-by', array( $item->getCreatorUserName() )) ;?></p>
		</li>
	<? endforeach; ?>
	</ul>
</div>
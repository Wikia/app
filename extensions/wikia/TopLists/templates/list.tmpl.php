<?php var_dump( $attribs ); ?>
<ul>
<? foreach ( $list->getItems() as $index => $item ) :?>
	<li>
		<strong>#<?= ( ++$index ) ;?></strong>
		<a href="#" class="wikia-button item-vote-button" id="<?= $item->getTitleText() ;?>" ><?= wfMsg( 'toplists-list-vote-up' ) ;?></a>
		<?= $item->getArticle()->getContent() ;?>
		<p id='item-votes-<?= $item->getArticle()->getId(); ?>'><?= wfMsg( 'toplists-list-votes-num', array( $item->getVotesCount() ) ) ;?></p>
		<p><?= wfMsg( 'toplists-list-created-by', array( $item->getCreatorUserName() )) ;?></p>
	</li>
<? endforeach; ?>
</ul>
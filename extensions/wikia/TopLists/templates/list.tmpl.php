<?php var_dump( $attribs ); ?>
<ul>
<?php foreach($list->getItems() as $index => $item ): ?>
	<li>
		<strong>#<?=( ++$index );?></strong>
		<a href="#" class="wikia-button item-vote-button" id="itemVoteUp<?= $index; ?>" title="<?= $index; ?>"><?= wfMsg( 'toplists-list-vote-up' ); ?></a>
		<?= $item->getTitle()->getSubpageText(); ?>
		<p><?= wfMsg( 'toplists-list-votes-num', array( $item->getVotesCount() ) ); ?></p>
		<p><?= wfMsg( 'toplists-list-created-by', array( $item->getCreatorUserName() )); ?></p>
	</li>
<?php endforeach; ?>
</ul>
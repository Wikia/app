<ul class="lvs-undo-list">
<? foreach ( $videos as $video ): ?>
	<li>
		<?= $video['createDate'] ?>
		[<a href="<?= $video['userLink'] ?>"><?= $video['userName'] ?></a>]
		<? if ( $video['statusSwap'] ): ?>
			<?= wfMessage( 'lvs-history-swapped', $video['titleLink'], $video['newTitleLink'] )->plain() ?>
		<? elseif ( $video['statusExact'] ): ?>
			<?= wfMessage( 'lvs-history-swapped-exact', $video['titleLink'] )->plain() ?>
		<? elseif ( $video['statusKeep'] ): ?>
			<?= wfMessage( 'lvs-history-kept', $video['titleLink'] )->plain() ?>
		<? endif; ?>
		(<a class="undo-link" href="<?= $video['undo'] ?>"><?= wfMessage($video['statusKeep'] ? 'lvs-undo-keep' : 'lvs-undo-swap')->plain() ?></a>)
	</li>
<? endforeach; ?>
</ul>

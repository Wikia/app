Swap History

<ul>
<? foreach ( $videos as $video ): ?>
	<li>
		<?= $video['createDate'] ?>
		[<a href="<?= $video['userLink'] ?>"><?= $video['userName'] ?></a>]
		<? if ( $video['statusSwap'] ): ?>
			<?= wfMessage( 'lvs-history-swapped', $video['titleLink'], $video['newTitleLink'] )->plain() ?>
		<? else: ?>
			<?= wfMessage( 'lvs-history-kept', $video['titleLink'] )->plain() ?>
		<? endif; ?>
		(<a href="<?= $video['undo'] ?>">undo</a>)
	</li>
<? endforeach; ?>
</ul>
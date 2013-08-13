<p><?= wfMessage( 'lvs-history-instructions' )->rawParams( $recentChangesLink )->parse() ?></p>

<ul class="lvs-undo-list">
<? foreach ( $videos as $video ): ?>
	<li>
		<?= $video['createDate'] ?>
		[<a href="<?= $video['userLink'] ?>"><?= $video['userName'] ?></a>]
		<?= $video['logMessage'] ?>
		(<a class="undo-link" href="<?= $video['undoLink'] ?>"><?= $video['undoText'] ?></a>)
	</li>
<? endforeach; ?>
</ul>

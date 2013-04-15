<div class="lyricfind-header plainlinks">
	<?= wfMessage('lyricfind-header', $artist, $song)->parse() ?>
</div>

<div class="lyricfind-credits" data-lyricfindid="<?= $gracenoteid ?>">
	<p>
		<?= wfMessage('lyricfind-songwrites') ?>: <em><?= $songwriter ?></em>
		<br>
		<?= wfMessage('lyricfind-publishers') ?>: <em><?= $publisher ?></em>
	</p>

	<noscript>
		<div class="lyricfind-header">
			You must enable javascript to view this page.  This is a requirement of our licensing agreement with music Gracenote.
		</div>
		<style>
			.lyricbox {
				display: none !important;
			}
		</style>
	</noscript>
</div>

<p><small><?= wfMessage('lyricfind-song-by', $artist)->parse() ?></small></p>

<div class="lyricbox">
	<p><?= $lyric ?></p>
</div>

<div class="lyricfind-branding">
	<?= wfMessage('lyricfind-copyright')->parse() ?>
</div>

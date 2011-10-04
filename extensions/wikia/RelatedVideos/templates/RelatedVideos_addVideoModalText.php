<div class="addRelatedVideos">
	<label>
		<?= wfMsg('related-videod-add-video-label-name') ?>
		<a class="remove" href="<?
			$oTitle = F::build( 'Title', array( 'Video_Embed_Tool', NS_HELP ), 'newFromText' );
			echo $oTitle->getFullURL();
		?>"><?= wfMsg('related-videod-add-video-label-all') ?></a>
		<br>
		<input type="text" name="videoUrl" value="">
		<table class="rv-error"><tr><td></td></tr></table>
	</label>
</div>
<div class="relatedVideosConfirm">
	<a class="button"><?= wfMsg('related-videod-add-video-ok') ?></a>
</div>
<div class="notifyHolder messageHolder"><?= wfMsg('related-videos-notify') ?></div>
<div class="somethingWentWrong messageHolder"><?= wfMsg('related-videos-something-went-wrong') ?></div>
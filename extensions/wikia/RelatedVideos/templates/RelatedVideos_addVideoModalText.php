<form class="rv-add-form WikiaForm" action="#">
<fieldset>
<div class="addRelatedVideos input-group required">
	<label>
		<?= wfMsg('related-videod-add-video-label-name') ?>
		<a class="remove" href="<?
			$oTitle = F::build( 'Title', array( 'Video_Embed_Tool', NS_HELP ), 'newFromText' );
			echo $oTitle->getFullURL();
		?>"><?= wfMsg('related-videod-add-video-label-all') ?></a>
		<br>
		<input type="text" name="videoUrl" class="videoUrl" value="">
		<button type="submit" class="button relatedVideosConfirm"><?= wfMsg('related-videod-add-video-ok') ?></button>
		<table class="rv-error"><tr><td></td></tr></table>
	</label>
</div>
</fieldset>
</form>
<div class="notifyHolder messageHolder"><?= wfMsg('related-videos-notify') ?></div>
<div class="somethingWentWrong messageHolder"><?= wfMsg('related-videos-something-went-wrong') ?></div>
<?
    if ( $wg->EnableRelatedVideosSuggestions ) {
        echo F::app()->sendRequest( "RelatedVideos", "getSuggestedVideos", array('pageTitle'=>$pageTitle) );
    }
?>
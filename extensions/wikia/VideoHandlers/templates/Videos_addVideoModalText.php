<form class="add-form WikiaForm" action="#">
<fieldset>
<div class="addRelatedVideos input-group required">
	<label>
		<?= wfMsg('videos-add-video-label-name') ?>
		<a class="remove" href="<?
			$oTitle = F::build( 'Title', array( 'Video_Embed_Tool', NS_HELP ), 'newFromText' );
			echo $oTitle->getFullURL();
		?>"><?= wfMsg('videos-add-video-label-all') ?></a>
		<br>
		<input type="text" name="videoUrl" class="videoUrl" value="">
		<button type="submit" class="button relatedVideosConfirm"><?= wfMsg('videos-add-video-ok') ?></button>
	</label>
</div>
</fieldset>
</form>
<div class="notifyHolder messageHolder"><?= wfMsg('videos-notify') ?></div>
<div class="somethingWentWrong messageHolder"><?= wfMsg('videos-something-went-wrong') ?></div>
<?
    if ( $wg->EnableRelatedVideosSuggestions && !$suppressSuggestions ) {
        echo F::app()->sendRequest( "RelatedVideos", "getSuggestedVideos", array('pageTitle'=>$pageTitle) );
    }

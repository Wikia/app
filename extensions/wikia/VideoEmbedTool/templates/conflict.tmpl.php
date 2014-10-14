<?php
// TODO: remove this.  It's no longer being used. 
$title = Title::newFromText( $name, NS_VIDEO );
$video_fake = new VideoPage( $title );
$video_real = new VideoPage( $title );

$video_fake->loadFromPars( $provider, $id, $metadata );
$video_real->load();

echo wfMsg( 'vet-conflict-inf', $name );
?>
<table cellspacing="0" id="VideoEmbedConflictTable">
	<tr>
		<td style="border-right: 1px solid #CCC;">
			<h2><?= wfMsg('vet-rename') ?></h2>
			<div style="margin: 5px 0;">
				<input type="text" id="VideoEmbedRenameName" value="<?= $name ?>" />
				<input type="button" value="<?= wfMsg('vet-insert') ?>" id="VideoEmbedRenameButton" class="vet-close" />
			</div>
		</td>
		<td>
			<h2><?= wfMsg('vet-existing') ?></h2>
			<div style="margin: 5px 0;">
				<input type="button" value="<?= wfMsg('vet-insert') ?>" id="VideoEmbedExistingButton" />
			</div>
		</td>
	</tr>
	<tr id="VideoEmbedCompare">
		<td style="border-right: 1px solid #CCC;">
			<?= $video_fake->getEmbedCode( '200' ) ?>
		</td>
		<td>
			<input type="hidden" id="VideoEmbedExistingName" value="<?= $name ?>" />
			<?= $video_real->getEmbedCode( '200' ) ?>
		</td>
	</tr>
</table>
<div style="margin-top:25px;"><a id="VideoEmbedConflictOverwriteButton" class="wikia-button v-float-right" id="VideoEmbedOverrideButton" href="#"><?= wfMsg('vet-overwrite') ?></a></div>

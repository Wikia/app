<?php
if ( !$validUser ) {
?>
<form action="<?= htmlspecialchars( $pageUrl ) ?>" method="GET" id="ImageReviewForm" class="coppa-image-review">
	<label for="wpUserName"><?= wfMessage( 'coppaimagereview-label-username' )->escaped(); ?></label>
	<input type="text" name="username" id="wpUserName" size="30" autofocus="autofocus" value="<?= htmlspecialchars( $userName ) ?>" />

	<input type="submit" value="<?= wfMessage( 'coppaimagereview-button-getimages' )->escaped(); ?>" />
</form>

<?php if( !empty( $userName ) ) { ?>
<p class="error"><?= wfMessage( 'coppaimagereview-nonexistentuser' )->escaped() ?></p>
<?php
	}
} elseif ( is_array( $imageList ) && count( $imageList ) > 0 ) {
?>
<form action="" method="POST" id="ImageReviewForm" class="coppa-image-review">
	<ul class="image-review-list">
<?php
	foreach ( $imageList as $n => $image ) {
		$id = "img-{$image['wikiId']}-{$image['pageId']}";
?>

			<li>
				<div class="img-container">
					<img id="<?= $id ?>" src="<?= htmlspecialchars( $image['src'] ) ?>" <? if ( empty( $image['isthumb'] ) ) { ?>width="230" <?php } ?>/>
				</div>
				<a href="<?= htmlspecialchars( $image['url'] ) ?>" target="_blank" class="internal sprite details magnify" title="<?= wfMessage( 'imagereview-gotoimage' )->escaped(); ?>"></a>

				<?php if ( !empty( $image['wiki_url'] ) ) { ?>
				<span class="image-wiki-url"><a href="<?= htmlspecialchars( $image['wiki_url'] ) ?>"><?= htmlspecialchars( $image['wiki_url'] ) ?></a></span>
				<?php } ?>

				<label title="<?= wfMessage( 'imagereview-label-ok' )->escaped(); ?>"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewStatuses::STATE_APPROVED ?>" checked><?= wfMessage( 'imagereview-option-ok' )->escaped(); ?></label>
				<label title="<?= wfMessage( 'imagereview-label-delete' )->escaped(); ?>"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewStatuses::STATE_DELETED ?>"><?= wfMessage( 'imagereview-option-delete' )->escaped(); ?></label>
			</li>
<?php
	}
?>
	</ul>
	<input type="hidden" value="<?= htmlspecialchars( $userName ) ?>" name="username" id="wpUserName" />
	<input type="hidden" value="<?= htmlspecialchars( $editToken ) ?>" name="token" id="wpEditToken" />
	<input type="hidden" value="<?= htmlspecialchars( $nextPage ) ?>" name="from" />

	<footer>
		<a href="javascript:history.back()" class="wikia-button secondary"><?= wfMessage( 'coppaimagereview-previous' )->escaped(); ?></a>
		<input id="nextButton" type="submit" class="wikia-button secondary" value="<?= wfMessage( 'coppaimagereview-next' )->escaped(); ?>" />
	</footer>
</form>
<?php
} else {
?>
<p><?= wfMessage( 'imagereview-noresults' )->escaped(); ?></p>

<?php
}
?>

<header>
	<div style="float: right; text-align: left">
<?php if ( $accessStats ) { ?>
		<div class="tally">
			<em><?= $imageCount['unreviewed']?></em> <span>awaiting<br>review</span>
		</div>
<?php } ?>

<?php if ( $accessQuestionable ) { ?>
		<div class="tally" style="clear: both">
			<a href="<?= $submitUrl ?>/questionable"><em><?= $imageCount['questionable']?></em> <span>questionable<br>images</span></a>
		</div>
<?php } ?>

		<div class="tally" style="clear: both">
			<em><?= $imageCount['reviewer']?></em> <span>reviewed<br>by you</span>
		</div>
	</div>

	<p>Click on images to mark them for deletion or as questionable (for staff review). When you're done with the batch, click "Review" below to get the next batch.</p>
</header>

<?php
	#var_dump($imageList);
?>

<form action="<?= $submitUrl ?>" method="post" id="ImageReviewForm">
	<table width=="980" cellspacing="5">
		<colspan>
			<col width="245">
			<col width="245">
			<col width="245">
			<col width="245">
		</colspan>

		<tr>
<?php
if (is_array($imageList) && count($imageList) > 0):
	$cells = 20;
	$perRow = 4;

	foreach($imageList as $n => $image) {
		$id = "img-{$image['wikiId']}-{$image['pageId']}";
		$stateId = intval($image['state']);
?>
			<td class="state-<?= $stateId ?>">
				<div class="img-container">
					<img src="<?= htmlspecialchars($image['src']) ?>">
				</div>
				<a href="<?= htmlspecialchars($image['url']) ?>" target="_blank" class="internal sprite details magnify" title="Go to image page"></a>

				<label title="Mark as OK"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewHelper::STATE_APPROVED ?>"<?= ($stateId == ImageReviewHelper::STATE_APPROVED || $stateId == ImageReviewHelper::STATE_IN_REVIEW || $stateId == ImageReviewHelper::STATE_QUESTIONABLE_IN_REVIEW || $stateId == ImageReviewHelper::STATE_UNREVIEWED ? ' checked' :'') ?>>OK</label>
				<label title="Delete"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewHelper::STATE_DELETED ?>"<?= ($stateId == ImageReviewHelper::STATE_DELETED ? ' checked' :'') ?>>Del</label>
				<label title="Questionable"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewHelper::STATE_QUESTIONABLE ?>"<?= ($stateId == ImageReviewHelper::STATE_QUESTIONABLE || $stateId == ImageReviewHelper::STATE_QUESTIONABLE_IN_REVIEW ? ' checked' :'') ?>>Q</label>
			</td>
<?php
		if ($n % $perRow == $perRow - 1) {
			echo "\t\t</tr><tr>\n";
		}
	}
endif;
?>
		</tr>
	</table>

	<footer>
		<a href="javascript:history.back()" class="wikia-button secondary">Back to previous batch</a>
		<input type="submit" class="wikia-button" value="Review & get next batch" />
	</footer>
</form>

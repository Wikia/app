<header>
	<div class="tally" style="float:right">
		<span style="float: left">You reviewed<br>images</span> <em>250K</em>
	</div>

	<?php if ( $accessQuestionable ) { ?>
		<a href="<?= $submitUrl ?>/questionable" class="wikia-button">View questionable images</a>
	<?php } ?>

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

				<label title="Mark as OK"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewHelper::STATE_APPROVED ?>"<?= ($stateId == ImageReviewHelper::STATE_APPROVED || $stateId == ImageReviewHelper::STATE_IN_REVIEW || $stateId == ImageReviewHelper::STATE_UNREVIEWED ? ' checked' :'') ?>>OK</label>
				<label title="Delete"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewHelper::STATE_DELETED ?>"<?= ($stateId == ImageReviewHelper::STATE_DELETED ? ' checked' :'') ?>>Del</label>
				<label title="Questionable"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewHelper::STATE_QUESTIONABLE ?>"<?= ($stateId == ImageReviewHelper::STATE_QUESTIONABLE ? ' checked' :'') ?>>Q</label>
			</td>
<?php
		if ($n % $perRow == $perRow - 1) {
			echo "\t\t</tr><tr>\n";
		}
	}
?>
		</tr>
	</table>

	<footer>
		<a href="javascript:history.back()" class="wikia-button secondary">Back to previous batch</a>
		<input type="submit" class="wikia-button" value="Review & get next batch" />
	</footer>
</form>

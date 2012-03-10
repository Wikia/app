<script>
$(function() {
	// cycle through radio fields on each image click
	var images = $('#ImageReviewForm img');
	images.bind('click', function(ev) {
		var img = $(this),
			cell = img.closest('td'),
			fields = cell.find('input'),
			selectedField = fields.filter(':checked'),
			selectedIndex = Math.max(0, fields.index(selectedField));

		// select the next radio
		var stateId = (selectedIndex + 1) % fields.length;

		fields.eq(stateId).click();
		cell.attr('class', 'state-' + fields.eq(stateId).val());
	});

	// do the same for checkboxes
	var checkboxes = $('#ImageReviewForm input');
	checkboxes.bind('click', function(ev) {
		var checkbox = $(this),
			cell = checkbox.closest('td');

		var stateId = checkbox.val();

		cell.attr('class', 'state-' + stateId);
	});
});
</script>

<style>
	#ImageReviewForm table {
		margin: 20px 0;
	}

	#ImageReviewForm td {
		border: solid 1px #ccc;
	}

	/* Del */
	#ImageReviewForm .state-4 {
		background-color: red;
	}

	/* Q */
	#ImageReviewForm .state-5 {
		background-color: yellow;
	}

	#ImageReviewForm div {
		text-align: center;
		line-height: 230px;
	}

	#ImageReviewForm img {
		max-height: 230px;
		max-width: 230px;
	}

	#ImageReviewForm a {
		float: right;
	}
</style>

<?php
	#var_dump($imageList);
?>

<form action="<?= $submitUrl ?>/submit" method="post" id="ImageReviewForm">
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
				<div>
					<img src="<?= htmlspecialchars($image['src']) ?>">
				</div>
				<small><a href="<?= htmlspecialchars($image['url']) ?>" target="_blank">link</a></small>

				<label title="Ok"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewSpecialController::STATE_APPROVED ?>"<?= ($stateId == ImageReviewSpecialController::STATE_APPROVED || $stateId == ImageReviewSpecialController::STATE_IN_REVIEW || $stateId == ImageReviewSpecialController::STATE_UNREVIEWED ? ' checked' :'') ?>>Ok</label>
				<label title="Delete"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewSpecialController::STATE_DELETED ?>"<?= ($stateId == ImageReviewSpecialController::STATE_DELETED ? ' checked' :'') ?>>Del</label>
				<label title="Questionable"><input type="radio" name="<?= $id ?>" value="<?= ImageReviewSpecialController::STATE_QUESTIONABLE ?>"<?= ($stateId == ImageReviewSpecialController::STATE_Q ? ' checked' :'') ?>>Q</label>
			</td>
<?php
		if ($n % $perRow == $perRow - 1) {
			echo "\t\t</tr><tr>\n";
		}
	}
?>
		</tr>
	</table>

	<input type="submit" value="Review and get next batch &raquo;" />
</form>

<script>
$(function() {
	var images = $('#ImageReviewForm img');

	// cycle through radio fields on each image click
	images.bind('click', function(ev) {
		var img = $(this),
			cell = img.parent(),
			fields = cell.find('input'),
			selectedField = fields.filter(':checked'),
			selectedIndex = fields.index(selectedField);

		// select the next radio
		var stateId = (selectedIndex + 1) % fields.length; 
		
		fields.eq(stateId).click();
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
	
	#ImageReviewForm .state-1 {
		background-color: red;
	}
	
	#ImageReviewForm .state-2 {
		background-color: yellow;
	}

	#ImageReviewForm img {
		display: block;
		max-height: 230px;
		max-width: 230px;
	}

	#ImageReviewForm a {
		float: right;
	}
</style>
<?php
	var_dump($imageList);
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

	for ($n=0; $n<$cells; $n++) {
?>
			<td>
				<img src="http://images4.wikia.nocookie.net/__spotlights/images/0654911ff943af82aa614c6a44ded605.png">
				<small><a href="#" target="_blank">link</a></small>

				<label title="Ok"><input type="radio" name="<?= $n ?>" value="0" checked="checked">Ok</label>
				<label title="Delete"><input type="radio" name="<?= $n ?>" value="1">Del</label>
				<label title="Questionable"><input type="radio" name="<?= $n ?>" value="2">Q</label>
			</td>
<?php
		if ($n % $perRow == $perRow - 1) {
			echo '</tr><tr>';
		}
	}
?>
		</tr>
	</table>

	<input type="submit" value="Review and get next batch &raquo;" />
</form>
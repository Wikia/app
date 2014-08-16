<form action="" method="post"
      enctype="multipart/form-data" onsubmit='$("#SpecialMetaForm div.errorbox").hide();' id="SpecialMetaForm">
	<div style="width:50%">
	<label for="meta">Please provide CSV file containing metadata for articles:</label><br/>
			<input type="submit" name="submit" value="Upload" style="display: inline-block"> <input type="file" name="meta" id="meta">
	</div>
	<?php if (isset($errMsg)): ?>
	<div class="errorbox">
		<?=$errMsg?>
	</div>
	<? endif ?>


</form>
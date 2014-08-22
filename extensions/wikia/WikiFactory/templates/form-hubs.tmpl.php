<!-- s:<?= __FILE__ ?> -->
<h2>
    Hub
</h2>
<div id="wk-wf-category">
<?php
	if( !is_null( $info ) ):
		echo $info;
	endif;
?>
	<div>
		<form id="wf-category" action="<?php echo $title->getFullUrl() ?>" method="post">
			<fieldset>
				<input type="hidden" name="wpWikiID" value="<?php echo $wiki->city_id ?>" />
				<label> Vertical </label>
				<select name="wpWikiVertical">
				<?php foreach( $verticals as $id => $data ): ?>
					<option value="<?php echo $id ?>" <?php if( $id == $vertical_id ) echo "selected=\"selected\"" ?>><?php echo $data["name"] ?></option>
				<?php endforeach ?>
				</select><br/>
				<label> Categories </label><br/>
				<div class="row">
<!--					<select multiple size=<?=count($all_categories);?> name="wpWikiCategory">  -->
					<?php foreach( $all_categories as $id => $data ): ?>
					<?php if($id > 1 && ($id-1) % 7 == 0) echo '</div>' ?>
					<?php if(($id-1) % 7 == 0) echo '<div class="small-3 columns">' ?>
						<input type="checkbox" name='wpWikiCategory[]' value="<?= $id ?>" <?php if( in_array($id, $wiki_categoryids ) ) echo "checked" ?>><?php echo $data["name"] ?></checkbox></br>
<!--						<option value="<?php echo $id ?>" <?php if( in_array($id, $wiki_categoryids ) ) echo "selected=\"selected\"" ?>><?php echo $data["name"] ?></option> -->
<!--					<?php if(($id-1) % 7 == 0) echo '</div>' ?> -->
					<?php endforeach ?>
<!--					</select> -->
				</div>
				<label> Reason </label>
				<input type="text" name="wpReason" /><br/>
				<input type="submit" name="wpSubmit" value="Update" />
			</fieldset>
		</form>
	</div>
</div>
<!-- e:<?= __FILE__ ?> -->

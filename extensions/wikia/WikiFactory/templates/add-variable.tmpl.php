<a href='<?php echo $title->getFullUrl(); ?>'>&larr; Back to WikiFactory</a>
<h2>
	Add a variable to WikiFactory
</h2>
<?php
	// Prevent errors from uninitialized form values
	if(!isset($cv_name))
		$cv_name = "";
	if(!isset($cv_variable_type))
		$cv_variable_type = "";
	if(!isset($cv_access_level))
		$cv_access_level = "";
	if(!isset($cv_variable_group))
		$cv_variable_group = "";
	if(!isset($cv_description))
		$cv_description = "";
?>
<form action="<?php echo $title->getFullUrl() ?>/add.variable" method="post">
	<div>
		<input type="hidden" name="wpAction" value="addwikifactoryvar" />
		This form is for adding a new variable to be managed using WikiFactory.<br/>
		<br/>
		
		Name for the variable: <input type="text" name="cv_name" value="<?php print $cv_name; ?>"/><br/>
		
		Variable type: <select id="cv_variable_type" name="cv_variable_type">
		 	<?php foreach ($types as $varType): ?>
			<option value="<?php echo $varType ?>"<?php print (($cv_variable_type==$varType)?" selected='selected'":""); ?>>
				<?php echo $varType ?>
			</option>
			<?php endforeach ?>
		</select><br/>
		
		Access-level: <select id="cv_access_level" name="cv_access_level">
			<?php foreach($accesslevels as $index => $level): ?>
			<option value="<?php echo $index ?>"<?php print (($cv_access_level==$index)?" selected='selected'":""); ?>>
				<?php echo $level ?>
			</option>
			<?php endforeach ?>
		</select><br/>
		
		Pick a group for this variable: <select id="wk-group-select" name="cv_variable_group">
			<?php foreach ($groups as $key => $value): ?>
			<option value="<?php echo $key ?>"<?php print (($cv_variable_group==$key)?" selected='selected'":""); ?>>
				<?php echo $value ?>
			</option>
			<?php endforeach ?>
		</select><br/>
                Is unique: <input value="1" <? if(!empty($cv_is_unique)) { ?> checked="checked" <? } ?> type="checkbox" id="cv_is_unique" name="cv_is_unique" /> <br/>
		Description of what this variable does:<br/>
		<textarea name="cv_description" value=""><?php print $cv_description; ?></textarea><br/>

		<input type="submit" name="submit" value="Create Variable" />
	</div>
</form>

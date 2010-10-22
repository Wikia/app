<h2>
	Change variable settings in WikiFactory
</h2>
<?php
	// Prevent errors from uninitialized form values
	if(!isset($error_message))
		$error_message = "";
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
<form method="post">
	<div>
		<?php print $error_message; ?>
		<input type="hidden" name="wpAction" value="changewikifactoryvar" />
		<input type="hidden" id="wk-change-cv_variable_id" value="<?php echo $cv_variable_id ?>" />
		This form is for changing the properties of a variable itself, not for changing the value of the variable.<br/>
		<br/>

		Name for the variable: <input type="text" id="wk-change-cv_name" name="cv_name" value="<?php print $cv_name; ?>"/><br/>

		Variable type: <select id="wk-change-cv_variable_type" name="cv_variable_type" disabled='disabled'>
		 	<?php foreach ($types as $varType): ?>
			<option value="<?php echo $varType ?>"<?php print (($cv_variable_type==$varType)?" selected='selected'":""); ?>>
				<?php echo $varType ?>
			</option>
			<?php endforeach ?>
		</select> (not changable at the moment because that would mess with all of the existing variables that were set)<br/>
	
		Access-level: <select id="wk-change-cv_access_level" name="cv_access_level">
			<?php foreach($accesslevels as $index => $level): ?>
			<option value="<?php echo $index ?>"<?php print (($cv_access_level==$index)?" selected='selected'":""); ?>>
				<?php echo $level ?>
			</option>
			<?php endforeach ?>
		</select><br/>
		
		Pick a group for this variable: <select id="wk-change-cv_variable_group" name="cv_variable_group">
			<?php foreach ($groups as $key => $value): ?>
			<option value="<?php echo $key ?>"<?php print (($cv_variable_group==$key)?" selected='selected'":""); ?>>
				<?php echo $value ?>
			</option>
			<?php endforeach ?>
		</select><br/>

		Description of what this variable does:<br/>
		<textarea id="wk-change-cv_description" name="cv_description" value="" rows="4" cols="75"><?php print $cv_description; ?></textarea><br/>

		<input type="submit" name="submit" value="Change Variable" onclick='javascript:$Factory.Variable.submitChangeVariable(this, [ "wk-variable-select", 1]);return false;' />
		&nbsp;&nbsp;&nbsp;
		<input type="submit" name="submit" value="Cancel" onclick='javascript:$Factory.Variable.select(this, [ "wk-variable-select", 1]);return false;'/>
	</div>
</form>

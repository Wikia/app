<h2>
	Add a variable to WikiFactory
</h2>
<form action="<?php echo $title->getFullUrl() ?>" method="post">
	<div>
		<input type="hidden" name="wpAction" value="addwikifactoryvar" />
		This form is for adding a new variable to be managed using WikiFactory.<br/>
		<br/>
		
		Name for the variable: <input type="text" name="cv_name" value=""/><br/>
		
		Variable type: <select id="cv_variable_type">
		 	<?php foreach ($types as $varType): ?>
			<option value="<?php echo $varType ?>">
				<?php echo $varType ?>
			</option>
			<?php endforeach ?>
		</select><br/>
		
		Access-level: <select id="cv_access_level">
			<?php for($index=0; $index < count($accesslevels); $index++): ?>
			<option value="<?php echo $index ?>">
				<?php echo $accesslevels[$index] ?>
			</option>
			<?php endfor ?>
		</select><br/>
		
		Pick a group for this variable: <select id="wk-group-select">
			<?php foreach ($groups as $key => $value): ?>
			<option value="<?php echo $key ?>">
				<?php echo $value ?>
			</option>
			<?php endforeach ?>
		</select><br/>

		Description of what this variable does:<br/>
		<textarea name="cv_description" value=""></textarea><br/>

		<input type="submit" name="submit" value="Create Variable" />
	</div>
</form>

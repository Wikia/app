<h1><?= wfMsg('tasks-title') ?></h1>

<p><?= wfMessage('tasks-description', "{$flowerUrl}/tasks?limit=100", 'Flower') ?></p>

<form id="task_edit_form" action="#">
	<div class="task_selector" id="class_selector">
		<h3><?= wfMsg('tasks-class') ?></h3>
		<select name="task_class">
			<option value="" selected="selected"><?= wfMsg('tasks-class-select') ?></option>
			<?php
			foreach ($createableTaskList as $class) {
				echo "<option value='{$class['name']}'>{$class['value']}</a>";
			}
			?>
		</select>
	</div>

	<div class="task_selector hidden" id="method_selector">
		<h3><?= wfMsg('tasks-method') ?></h3>
		<select name="task_method">
			<option value="" selected="selected"><?= wfMsg('tasks-method-select') ?></option>
		</select>
	</div>

	<div class="clear"></div>

	<div id="task_editor" class="hidden">
		<pre></pre>
		<div id="task_edit_fields"></div>
		<input type="submit" value="Create Task" />
	</div>
</form>

<div id="task_progress_container" class="hidden">
	<h1><?= wfMsg('tasks-progress') ?></h1>
	<table width="100%">
		<tr>
			<th><?= wfMsg('tasks-method') ?></th>
			<th><?= wfMsg('tasks-state') ?></th>
			<th><?= wfMsg('tasks-result') ?></th>
		</tr>
	</table>
</div>
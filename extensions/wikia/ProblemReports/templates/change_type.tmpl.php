<!-- change problem type -->
<fieldset id="problem_type_form">
    <legend><?= wfMsg('pr_what_problem_change') ?></legend>

<select id="problem_type_chooser" onchange="reportProblemChangeType(<?= $problem['id'] ?>, this)">
<?php foreach($problemTypes as $id => $type): ?>
	<option value="<?= $id ?>"<?= ($id == $problem['type']) ? ' selected="selected"' : '' ?>><?= $type ?></option>
<?php endforeach ?>
</select>
</fieldset>
<!-- /change problem type -->
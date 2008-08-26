<!-- s:<?= __FILE__ ?> -->
<h2>
	Configuration Variables
</h2>
<div>
    <form id="wk-wf-variables-select">
            <div style="float: left">
                <select size="16" style="width: 22em;" id="wk-variable-select">
                <?php foreach($variables as $variable): ?>
                    <option value="<?php echo $variable->cv_id ?>">
                        <?php echo $variable->cv_name ?>
                    </option>
                <?php endforeach ?>
                </select>
            </div>
            <div>
                <input type="checkbox" name="wfOnlyDefined" id="wf-only-defined" />
                <label for="wf-only-defined">show only set variables</label><br />
                <input type="checkbox" name="wfOnlyditable" id="wf-only-editable" />
                <label for="wf-only-editable">show only editable </label><br />
                <select id="wk-group-select">
                    <option value="0" selected="selected">
                        All groups
                    </option>
                    <? foreach ($groups as $key => $value): ?>
                    <option value="<?php echo $key ?>">
                        <?php echo $value ?>
                    </option>
                    <? endforeach ?>
                </select>
				<br />
				<label for="wf-only-withstring">variable name contains</label>
				<br />
				<input type="text" name="wfOnlyWithString" id="wfOnlyWithString" size="12" />
            </div>
    </form>
    <hr style="clear: both">
    <div id="wk-variable-form"></div>
</div>
<!-- e:<?= __FILE__ ?> -->

<!-- s:<?= __FILE__ ?> -->
<h2>Variable Data - <?php echo $variable->cv_name ?>  <small>[<a href='#' id="wk-variable-change" title="Click here to edit this variable" onclick='javascript:$Factory.Variable.change(this, [ "wk-variable-select", 1]);return false;'>edit</a>]</small></h2>
<div style="margin:.5em 0;"><?php echo $variable->cv_description ?></div>
<table border='1' cellpadding='2' cellspacing='0'>
	<thead class="wf-tinyhead">
		<tr>
			<th>id</th>
			<th>Type</th>
			<th>Access</th>
			<th>Group</th>
			<th>Unique</th>
		</tr>
	</thead>

	<tr>
		<td><?php echo $variable->cv_id ?></td>
		<td><?php echo $variable->cv_variable_type ?></td>
		<td><abbr title="<?php echo $accesslevels[ $variable->cv_access_level ] ?>"><?php echo $variable->cv_access_level ?></abbr></td>
		<td><abbr title="<?php echo $variable->cv_variable_group; ?>"><?php echo $groups[$variable->cv_variable_group]; ?></abbr></td>
		<td><?php echo ($variable->cv_is_unique == 1 ? "yes":"no"); ?></td>
	</tr>
</table>
<ul>
	<li><?php $WIEbase = "http://community.wikia.com/wiki/Special:WhereIsExtension?var=" . $variable->cv_id; ?>
		Where is... <small><a href="<? echo $WIEbase ?>&val=2">Any value</a><?php
		if( $variable->cv_variable_type == 'boolean' ) {
			print " &middot; <a href='{$WIEbase}&val=0'>True</a>";
			print " &middot; <a href='{$WIEbase}&val=1'>False</a>";
		}
		?></small></li>
	<li>
		Manual: <small>
		&nbsp;<a href="http://www.mediawiki.org/wiki/Manual:$<?php echo $variable->cv_name ?>" title='link to manual page at mediawiki.org'>MediaWiki</a>
		&nbsp;<a href="http://contractor.wikia-inc.com/wiki/Manual:$<?php echo $variable->cv_name ?>" title='link to manual page at contractor.wikia'>Wikia</a></small>
	</li>
	<li>
		<a href="<?php echo "{$wikiFactoryUrl}/{$variable->cv_city_id}/variables/{$variable->cv_name}"; ?>">permalink</a>
	</li>
</ul>
<h2>
    Variable value
    <span style="font-size: small;">
        <!-- [<a id="wk-var-remove" title="Remove value" href="#">remove value</a>] -->
    </span>
</h2>

<div style="width: 45%; float: left">
Current value:
<?php if( !isset( $variable->cv_value ) || is_null( $variable->cv_value ) ): ?>
    <strong>Value is not set</strong>
<?php else: ?>
	<input type="button" class="wikia-button red" id="wk-submit-remove" name="remove-submit" value="Remove value" onclick="$Factory.Variable.tagCheck('remove');" /><br/>
    <pre><?php echo var_export( unserialize( $variable->cv_value ) ) ?></pre>
<?php endif ?>
</div>

<div style="width: 45%; float: right">
Default value:
<?php
$name = $variable->cv_name;
global $$name;
if( isset( $preWFValues[$name] ) ) {
	// was modified, spit out saved default
	echo "<pre>" . var_export( $preWFValues[$name], true ) . "</pre>";
} elseif( isset( $$name ) ) {
	// was not modified, spit out actual value
	echo "<pre>" . var_export( $$name, true ) . "</pre>";
} else {
	// no value set
	echo "<strong>No default value set.</strong>";
} ?>
</div>

<div style="margin-top: 2em; clear: both;">
<?php if( $variable->cv_access_level > 1 ): ?>
New value:
<form id="wf-variable-form" name="wf-variable-form" class="wf-variable-form">
	<input type="hidden" name="cityid" value="<?php echo $cityid ?>" />
	<input type="hidden" name="varCityid" value="<?php echo $variable->cv_city_id ?>" />
	<input type="hidden" name="varType" value="<?php echo $variable->cv_variable_type ?>" />
	<input type="hidden" name="varName" value="<?php echo $variable->cv_name ?>" />
	<input type="hidden" name="varId" value="<?php echo $variable->cv_variable_id ?>" />

<?php if( $variable->cv_variable_type === "boolean" ): ?>

	<select name="varValue" id="varValue">
	<?php   if( unserialize( $variable->cv_value === true ) ): ?>
		<option value="1" selected="selected">true</option>
		<option value="0">false</option>
	<?php   else: ?>
		<option value="1">true</option>
		<option value="0" selected="selected">false</option>
	<?php   endif ?>
	</select>

<?php elseif( $variable->cv_variable_type == "integer"): ?>

	<input type="text" name="varValue" id="varValue" value="<?php echo unserialize( $variable->cv_value ) ?>" size="40" maxlength="255" />

<?php elseif( $variable->cv_variable_type == "string"): ?>

	<input type="text" name="varValue" id="varValue" value="<?php echo unserialize( $variable->cv_value ) ?>" size="100" class="input-string" /><br />

<?php elseif ($variable->cv_variable_type == "array" && !empty($wgDevelEnvironment)): ?>

	<textarea name="varValue" id="varValue"><?php if( isset( $variable->cv_value ) ) echo var_export( unserialize( $variable->cv_value ), 1) ?></textarea><br />

<?php else: ?>

	 <textarea name="varValue" id="varValue"><?php if( isset( $variable->cv_value ) ) echo var_export( unserialize( $variable->cv_value ), 1) ?></textarea><br />

<?php endif ?>
	&nbsp;<span id="wf-variable-parse">&nbsp;</span>
	&nbsp;<span id="wf-tag-parse">&nbsp;</span>
	<br/>By tag: <input type="text" name="tagName" id="tagName" value="" size="30" /> (Apply this value to wikis with this tag)
	<br/>Reason: <input type="text" id="wk-reason" name="reason" value="" size="30" /> (optional, reason text or ticket number)
	<br/><input type="button" id="wk-submit" name="submit" value="Parse &amp; Save changes" onclick="$Factory.Variable.tagCheck();" />
</form>
<?php else: ?>
<em>read only</em>
<?php endif ?>
</div>

<?php if (!empty($related)): ?>
<h2>Related Variables</h2>
<div id="wf-related-variables">
<?php $form_id = 0; ?>
<?php foreach ($related as $rel_var): ?>
<?php $form_id++; ?>
<h3><?= $rel_var->cv_name ?></h3>
<?php echo $rel_var->cv_description ?>

<div>
<?php if( $rel_var->cv_access_level > 1 ): ?>
<form id="wf-variable-form-<?= $form_id ?>" name="wf-variable-form-<?= $form_id ?>" class="wf-variable-form">
	<input type="hidden" name="formId" value="<?= $form_id ?>" />
	<input type="hidden" name="cityid" value="<?php echo $cityid ?>" />
	<input type="hidden" name="varCityid" value="<?php echo $rel_var->cv_city_id ?>" />
	<input type="hidden" name="varType" value="<?php echo $rel_var->cv_variable_type ?>" />
	<input type="hidden" name="varName" value="<?php echo $rel_var->cv_name ?>" />
	<input type="hidden" name="varId" value="<?php echo $rel_var->cv_variable_id ?>" />

<?php if( $rel_var->cv_variable_type === "boolean" ): ?>

	<select name="varValue" id="varValue">
	<?php   if( unserialize( $rel_var->cv_value === true ) ): ?>
		<option value="1" selected="selected">true</option>
		<option value="0">false</option>
	<?php   else: ?>
		<option value="1">true</option>
		<option value="0" selected="selected">false</option>
	<?php   endif ?>
	</select>

<?php elseif( $rel_var->cv_variable_type == "integer"): ?>

	<input type="text" name="varValue" id="varValue" value="<?php echo unserialize( $rel_var->cv_value ) ?>" size="40" maxlength="255" />

<?php elseif( $rel_var->cv_variable_type == "string"): ?>

	<input type="text" name="varValue" id="varValue" value="<?php echo unserialize( $rel_var->cv_value ) ?>" size="160" class="input-string" />

<?php else: ?>

	 <textarea name="varValue" id="varValue"><?php if( isset( $rel_var->cv_value ) ) echo var_export( unserialize( $rel_var->cv_value ), 1) ?></textarea><br />

<?php endif ?>
	<input type="button" id="wk-submit" name="submit" value="Parse &amp; Save changes" onclick="$Factory.Variable.submit($(this).parent().attr('id'));" />
	<input type="button" id="wk-submit-remove" name="remove-submit" value="Remove value" onclick="$Factory.Variable.remove_submit(true, $(this).parent().attr('id'));" />
	&nbsp;<span id="wf-variable-parse-<?= $form_id ?>">&nbsp;</span>
</form>
<?php else: ?>
<em>read only</em>
<?php endif ?>
</div>

<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (!empty($related_pages)): ?>
<h2>Related Pages</h2>
<div id="wf-related-pages">
<?php foreach ($related_pages as $rel_page): ?>
<h3><?= $rel_page["name"] ?></h3>

<div>
<?= Xml::element("a", array("class" => "wikia-button", "href" => $rel_page["script"] . "?" . http_build_query(array("title" => $rel_page["name"], "action" => "edit"))), "Edit") ?>
</div>

<?php endforeach; ?>
</div>
<?php endif; ?>

<!-- e:<?= __FILE__ ?> -->

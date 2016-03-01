<!-- s:<?= __FILE__ ?> -->
<h2>Variable Data - <?php echo $variable->cv_name ?>  <small>[<a href='#' id="wk-variable-change" title="Click here to edit this variable's settings" onclick='javascript:$Factory.Variable.change(this, [ "wk-variable-select", 1]);return false;'>edit</a>]</small></h2>
<div style="margin:.5em 0;"><?php echo $variable->cv_description ?></div>
<table class="WikiaTable">
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
		<td><abbr title="<?php echo $variable->cv_access_level; ?>"><?php echo $accesslevels[ $variable->cv_access_level ]; ?></abbr></td>
		<td><abbr title="<?php echo $variable->cv_variable_group; ?>"><?php echo $groups[$variable->cv_variable_group]; ?></abbr></td>
		<td><?php echo ($variable->cv_is_unique == 1 ? "yes":"no"); ?></td>
	</tr>
</table>
<ul><?php $WIEbase = "http://community.wikia.com/wiki/Special:WhereIsExtension?var=" . $variable->cv_id; ?>
	<li>
		Where is... <a href="<? echo $WIEbase ?>&val=2">Any value</a><?php
		if( $variable->cv_variable_type == 'boolean' ) {
			print " &middot; <a href='{$WIEbase}&val=0'>True</a>";
			print " &middot; <a href='{$WIEbase}&val=1'>False</a>";
		}
		?></li>
	<?php global $wgEnableWikiFactoryReporter;
		if( !empty($wgEnableWikiFactoryReporter) ): ?><li>
		<a href="http://community.wikia.com/wiki/Special:WikiFactoryReporter?varid=<?php echo $variable->cv_id ?>">Values Reporter</a>
	</li><?php endif; ?>
	<li>
		Manual:
		&nbsp;<a href="http://www.mediawiki.org/wiki/Manual:$<?php echo $variable->cv_name ?>" title='link to manual page at mediawiki.org'>MediaWiki</a>
		&nbsp;<a href="http://contractor.wikia-inc.com/wiki/Manual:$<?php echo $variable->cv_name ?>" title='link to manual page at contractor.wikia'>Wikia</a>
	</li>
	<li>
		<a href="<?php echo "{$wikiFactoryUrl}/{$variable->cv_city_id}/variables/{$variable->cv_name}"; ?>">permalink</a>
	</li>
	<li>
		<a href="<?php echo "{$wikiFactoryUrl}/{$variable->cv_city_id}/clog?variable={$variable->cv_id}"; ?>" target="_blank">changelog</a>
	</li>
</ul>
<h2>
	Variable value
</h2>

<div style="width: 45%; float: left">
Current value:
<?php if( !isset( $variable->cv_value ) || is_null( $variable->cv_value ) ): ?>
    <strong>Value is not set</strong>
<?php else: ?>
    <pre><?php echo WikiFactory::renderValue( $variable ) ?></pre>
<?php endif ?>
</div>

<div style="width: 45%; float: right">
Value on community (possibly default value):
<?php
	$value = WikiFactory::renderValueOnCommunity( $variable->cv_name, $variable->cv_variable_type );
	if ( $value !== "" ) {
		echo "<pre>{$value}</pre>";
	} else {
		echo "<strong>Value is not set</strong>";
	}
?>
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
	<?php   if( unserialize( $variable->cv_value ) === true ): ?>
		<option value="1" selected="selected">true</option>
		<option value="0">false</option>
	<?php   else: ?>
		<option value="1">true</option>
		<option value="0" selected="selected">false</option>
	<?php   endif ?>
	</select>

<?php elseif( $variable->cv_variable_type == "integer"): ?>

	<input type="text" name="varValue" id="varValue" value="<?php echo WikiFactory::renderValue( $variable ) ?>" size="40" maxlength="255" />

<?php elseif( $variable->cv_variable_type == "string"): ?>

	<input type="text" name="varValue" id="varValue" value="<?php echo WikiFactory::renderValue( $variable ) ?>" size="100" class="input-string" /><br />

<?php else: ?>

	<textarea name="varValue" id="varValue"><?php echo WikiFactory::renderValue( $variable ) ?></textarea><br />

<?php endif ?>
	<div class="clearfix">
		<div class="wf-variable-form-inline-group wf-variable-form-left">
			<label for="reason">
			<?= wfMessage( 'wikifactory-label-reason' )->parse(); ?></label>
			<input type="text" id="wk-reason" name="reason" value="" size="30" />
		</div>
		<div class="wf-variable-form-inline-group wf-variable-form-right">
			<label for="tagName">
			<strong>By tag</strong> (apply this value to wikis with this tag) :</label>
			<input type="text" name="tagName" id="tagName" value="" size="30" />
		</div>
	</div>
	<br/><input type="button" id="wk-submit" name="submit" value="<?= wfMsg('wikifactory-button-saveparse'); ?>" onclick="$Factory.Variable.tagCheck();" />
	&nbsp;<input type="button" class="wikia-button red" id="wk-submit-remove" name="remove-submit" value="Remove value" onclick="$Factory.Variable.tagCheck('remove');" /><br/>
	&nbsp;<span id="wf-variable-parse">&nbsp;</span>
	&nbsp;<span id="wf-tag-parse">&nbsp;</span>
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

	<input type="text" name="varValue" id="varValue" value="<?php echo WikiFactory::renderValue( $rel_var ) ?>" size="40" maxlength="255" />

<?php elseif( $rel_var->cv_variable_type == "string"): ?>

	<input type="text" name="varValue" id="varValue" value="<?php echo WikiFactory::renderValue( $rel_var ) ?>" size="160" class="input-string" />

<?php else: ?>

	 <textarea name="varValue" id="varValue"><?php echo WikiFactory::renderValue( $rel_var ) ?></textarea><br />

<?php endif ?>
	<input type="button" id="wk-submit" name="submit" value="<?= wfMsg('wikifactory-button-saveparse'); ?>" onclick="$Factory.Variable.submit($(this).parent().attr('id'));" />
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
<?= Xml::element("a", array(
						"class" => "wikia-button",
						"href" => $rel_page["url"] . "?" . http_build_query( array(
																				"action" => "edit"
																				)
																			)
							), "Edit") ?>
</div>

<?php endforeach; ?>
</div>
<?php endif; ?>

<!-- e:<?= __FILE__ ?> -->

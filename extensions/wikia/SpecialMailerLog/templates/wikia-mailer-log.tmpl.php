<?php global $wgScriptPath, $wgStylePath ?>
<div class="wikia-mailer-log">
	<style type="text/css">
/*<![CDATA[*/
<?php
        if (Wikia::isOasis()) {
                $css = wfGetSassUrl('extensions/wikia/WikiFactory/css/oasis.scss');
                echo "@import url('{$css}');\n\n";
        }

        // TODO: move these CSS rules to oasis.scss
?>

#cityselect {z-index:9000} /* for IE z-index of absolute divs inside relative divs issue */
#mailer-wiki-name {z-index:0} /* abs for ie quirks */

#MailerLogDomainSelector {position: relative; z-index: 10}

#MailerLogDomainSelector .autocomplete { background: white; border-color: #D9D9D9; border-style: solid; border-width: 1px 2px 2px; margin-top: 2px; overflow: hidden; position: relative; top: 3px; }

#mailer-wiki-name, #mailer-email, #mailer-subject, #mailer-body {width: 300px}

.wk-form-row { list-style-type: none; display: inline; margin:0; }
.wk-form-row li { display: inline; }
.wk-form-row label { width: 8em; float: left; text-align: left; vertical-align: middle; margin: 5px 0 0 0; }

.mailer-log-table { width: 980px; }
.mailer-log-table td { margin-left: 0px; margin-right: 0px; border-left: 0px; border-right: 0px; border-spacing: 0px 0px; }
.mailer-log-row-top td { border-top: solid 2px #444444; }

/** overwrite some pager styles **/
table.TablePager { border: 1px solid gray;}
/*]]>*/
	</style>

	<form id="MailerLogCreatedSelector" class="clearfix" method="post" action="<?= $scriptURL ?>?<?= $query_string ?>">
		<div id="mailer-search-dates" style="float: right">
		<div class="wk-form-row<?= array_key_exists('CreatedNum', $filter_roster) ? ' filter-on' : '' ?>">
 			<ul>
 				<li><label>Created</label></li>
				<li>
					<select name="new_created_type">
						<option value="exactly"<?= array_key_exists('CreatedTypeExact', $filter_roster) ? ' selected="selected"' : '' ?>>exactly</option>
						<option value="after"<?= array_key_exists('CreatedTypeAfter', $filter_roster) ? ' selected="selected"' : '' ?>>sooner than</option>
					</select>
					<input type="text" size="2" maxlength="2" name="new_created_number" id="mailer-created-num" value="<?= array_key_exists('CreatedNum', $filter_roster) ? $filter_roster['CreatedNum'] : '' ?>" />
					<select name="new_created_unit">
						<option value="day"<?= array_key_exists('CreatedUnitDays', $filter_roster) ? ' selected="selected"' : '' ?>>days</option>
						<option value="week"<?= array_key_exists('CreatedUnitWeeks', $filter_roster) ? ' selected="selected"' : '' ?>>weeks</option>
					</select>
					ago
				</li>
				<li><button style="z-index:9002" onclick="$('#mailer-created-num').val('');">Clear</button></li>
			</ul>
		</div>

		<div class="wk-form-row<?= array_key_exists('AttemptedNum', $filter_roster) ? ' filter-on' : '' ?>">
 			<ul>
 				<li><label>Attempted</label></li>
				<li>
					<select name="new_attempted_type">
						<option value="exactly"<?= array_key_exists('AttemptedTypeExact', $filter_roster) ? ' selected="selected"' : '' ?>>exactly</option>
						<option value="after"<?= array_key_exists('AttemptedTypeAfter', $filter_roster) ? ' selected="selected"' : '' ?>>sooner than</option>
					</select>
					<input type="text" size="2" maxlength="2" name="new_attempted_number" id="mailer-attempted-num" value="<?= array_key_exists('AttemptedNum', $filter_roster) ? $filter_roster['AttemptedNum'] : '' ?>" />
					<select name="new_attempted_unit">
						<option value="day"<?= array_key_exists('AttemptedUnitDays', $filter_roster) ? ' selected="selected"' : '' ?>>days</option>
						<option value="week"<?= array_key_exists('AttemptedUnitWeeks', $filter_roster) ? ' selected="selected"' : '' ?>>weeks</option>
					</select>
					ago
				</li>
				<li><button style="z-index:9002" onclick="$('#mailer-attempted-num').val('');">Clear</button></li>
			</ul>
		</div>

		<div class="wk-form-row <?= array_key_exists('TransmittedNum', $filter_roster) ? ' filter-on' : '' ?>">
 			<ul>
 				<li><label>Transmitted</label></li>
				<li>
					<select name="new_transmitted_type">
						<option value="exactly"<?= array_key_exists('TransmittedTypeExact', $filter_roster) ? ' selected="selected"' : '' ?>>exactly</option>
						<option value="after"<?= array_key_exists('TransmittedTypeAfter', $filter_roster) ? ' selected="selected"' : '' ?>>sooner than</option>
					</select>
					<input type="text" size="2" maxlength="2" name="new_transmitted_number" id="mailer-transmitted-num" value="<?= array_key_exists('TransmittedNum', $filter_roster) ? $filter_roster['TransmittedNum'] : '' ?>" />
					<select name="new_transmitted_unit">
						<option value="day"<?= array_key_exists('TransmittedUnitDays', $filter_roster) ? ' selected="selected"' : '' ?>>days</option>
						<option value="week"<?= array_key_exists('TransmittedUnitWeeks', $filter_roster) ? ' selected="selected"' : '' ?>>weeks</option>
					</select>
					ago
				</li>
				<li><button style="z-index:9002" onclick="$('#mailer-transmitted-num').val('');">Clear</button></li>
			</ul>
		</div>
		</div>

		<div id="mailer-search-text" style="float: left">
		<div id="MailerLogDomainSelector">
			<div class="wk-form-row<?= array_key_exists('Wiki', $filter_roster) ? ' filter-on' : '' ?>">
 				<ul>
 					<li><label>Domain name</label></li>
					<li><input type="hidden" name="off_filter_wiki_id" id="mailer-off-wiki-id"><input type="text" name="new_filter_wiki_name" id="mailer-wiki-name" value="<?= array_key_exists('Wiki', $filter_roster) ? $filter_roster['Wiki']['value'] : '' ?>" size="16" maxlength="255" /></li>
					<li><button style="z-index:9002" onclick="$('#mailer-off-wiki-id').val(1);">Clear</button></li>
				</ul>
			</div>
		</div>

		<div class="wk-form-row<?= array_key_exists('Email', $filter_roster) ? ' filter-on' : '' ?>">
 			<ul>
 				<li><label>Email Address</label></li>
				<li><input type="text" name="new_filter_dst" id="mailer-email" value="<?= array_key_exists('Email', $filter_roster) ? $filter_roster['Email']['value'] : '' ?>" size="24" maxlength="255" /></li>
				<li><button style="z-index:9002" onclick="clearFilter(form, 'mailer-email');">Clear</button></li>
			</ul>
		</div>

		<div class="wk-form-row<?= array_key_exists('Subject', $filter_roster) ? ' filter-on' : '' ?>">
 			<ul>
 				<li><label>Subject</label></li>
				<li><input type="text" name="new_filter_subject" id="mailer-subject" value="<?= array_key_exists('Subject', $filter_roster) ? $filter_roster['Subject'] : '' ?>" size="24" maxlength="255" /></li>
				<li><button style="z-index:9002" onclick="clearFilter(form, 'mailer-subject');">Clear</button></li>
			</ul>
		</div>

		<div class="wk-form-row<?= array_key_exists('Body', $filter_roster) ? ' filter-on' : '' ?>">
 			<ul>
 				<li><label>Body</label></li>
				<li><input type="text" name="new_filter_body" id="mailer-body" value="<?= array_key_exists('Body', $filter_roster) ? $filter_roster['Body'] : '' ?>" size="24" maxlength="255" /></li>
				<li><button style="z-index:9002" onclick="clearFilter(form, 'mailer-body');">Clear</button></li>
			</ul>
		</div>
		</div>
		<br />
		<div class="search-controls" style="clear: both; display: block;" >
			<button style="z-index:9002" onclick="window.location.href='<?= $scriptURL ?>'; return false">Clear All</button>
			<button style="z-index:9002">Search</button>
		</div>
	</form>



	<script type="text/javascript">
/*<![CDATA[*/
	$.loadJQueryAutocomplete(function() {
		$('#mailer-wiki-name').autocomplete({
			serviceUrl: wgServer + wgScript + '?action=ajax&rs=axWFactoryDomainQuery',
			onSelect: function(v, d) {
				window.location.href = "<?= $scriptURL ?>?<?= $query_string ?>&new_filter_wiki_id=" + d;
			},
			appendTo: '#MailerLogDomainSelector',
			deferRequestBy: 0,
			maxHeight: 300,
			minChars: 3,
			width: 350
		});
	});
	
	function clearFilter ( form, filter_id ) {
		filter = $('#' + filter_id);
		filter.val('');
		form.submit();
	}
/*]]>*/
	</script>

	<div class="wikia-mailer-controls">
		<div class="mailer-log-page-size" style="float: left">
			Show:
   <?php foreach (array(10, 50, 100, 200) as $limit): ?>
       <?php if ($cur_limit == $limit): ?>
       		<b><?= $limit ?></b>
       <?php else: ?>
       		<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_limit=<?= $limit ?>"><?= $limit ?></a>
       <?php endif; ?>
       		<?= $limit != 200 ? '|' : '' ?> 
   <?php endforeach; ?>
   		( <?= $num_rows ?> total )
   		</div>
   	</div>
	<div class="mailer-log-pagination clearfix" style="float: right">
		<?php if ($cur_offset): ?><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_offset=<?= $cur_offset - $cur_limit > 0 ? $cur_offset - $cur_limit : 0 ?>">&lt; Prev</a><?php else: ?><b>&lt; Prev</b><?php endif; ?> | <?php if ($cur_offset+$cur_limit < $num_rows): ?><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_offset=<?= $cur_offset + $cur_limit < $num_rows ? $cur_offset + $cur_limit : $num_rows ?>">Next &gt;</a><?php else: ?><b>Next &gt;</b><?php endif ?>
	</div>
   	<br />
	<table class="mailer-log-table">
		<tr>
			<th>ID<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=id&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=id&new_sort_dir=desc">desc</a></th>
			<th>Created<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=created&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=created&new_sort_dir=desc">desc</a></th>
			<th>Wiki<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=city_id&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=city_id&new_sort_dir=desc">desc</a></th>
			<th>To<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=dst&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=dst&new_sort_dir=desc">desc</a></th>
			<th>Attempted</th>
			<th>Transmitted<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=transmitted&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=transmitted&new_sort_dir=desc">desc</a></th>
			<th>Error</th>
		</tr>
		<?php foreach ($records as $row): ?>
		<tr class="mailer-log-row-top">
			<td><?= $row['id'] ?></td>
			<td><?= $row['created'] ?></td>
			<td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_wiki_id=<?= $row['city_id'] ?>"><?= $row['wiki_name'] ?></a></td>
			<td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_dst=<?= $row['to'] ?>"><?= $row['to'] ?></a></td>
			<td><?= $row['attempted'] ?></td>
			<td><?= $row['transmitted'] ?></td>
			<td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_error=1"><?= $row['error_msg'] ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td style="background-color: #DDDDDD"><b>Subject:</b></td>
			<td style="background-color: #DDDDDD" colspan="5"><?= $row['subject'] ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td style="background-color: #DDDDDD"><b>Body:</b></td>
			<td style="background-color: #DDDDDD" colspan="5"><?= $row['msg_short'] ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>


<!-- s:<?php echo __FILE__ ?> -->

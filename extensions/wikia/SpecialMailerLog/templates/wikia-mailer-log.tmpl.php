<?php global $wgScriptPath, $wgStylePath ?>
<div class="wikia-mailer-log">
	<style type="text/css">
/*<![CDATA[*/

#cityselect {z-index:9000} /* for IE z-index of absolute divs inside relative divs issue */
#mailer-wiki-name {z-index:0;} /* abs for ie quirks */

#MailerLogDomainSelector {position: relative; z-index: 10}
#mailer-wiki-name {width: 350px}

.wk-form-row { list-style-type: none; display: inline; margin:0; }
.wk-form-row li { display: inline; }
.wk-form-row label { width: 10em; float: left; text-align: left; vertical-align: middle; margin: 5px 0 0 0; }

/** overwrite some pager styles **/
table.TablePager { border: 1px solid gray;}
/*]]>*/
	</style>

	<form id="MailerLogCreatedSelector" method="post" action="<?= $scriptURL ?>?<?= $query_string ?>">
		<div class="wk-form-row">
 			<ul>
 				<li><label>Created</label></li>
				<li><input type="text" size="4" maxsize="4" name="new_filter_wiki_name" id="mailer-wiki-name" value="<?= array_key_exists('Wiki', $filter_roster) ? $filter_roster['Wiki']['value'] : '' ?>" size="24" maxlength="255" /></li>
				<li><button style="z-index:9002">Apply</button></li>
				<li><button style="z-index:9002" onclick="$('#mailer-off-wiki-id').val(1);">Clear</button></li>
			</ul>
		</div>
	</form>

	<form id="MailerLogDomainSelector" method="post" action="<?= $scriptURL ?>?<?= $query_string ?>">
		<div class="wk-form-row">
 			<ul>
 				<li><label>Domain name</label></li>
				<li><input type="hidden" name="off_filter_wiki_id" id="mailer-off-wiki-id"><input type="text" name="new_filter_wiki_name" id="mailer-wiki-name" value="<?= array_key_exists('Wiki', $filter_roster) ? $filter_roster['Wiki']['value'] : '' ?>" size="24" maxlength="255" /></li>
				<li><button style="z-index:9002">Apply</button></li>
				<li><button style="z-index:9002" onclick="$('#mailer-off-wiki-id').val(1);">Clear</button></li>
			</ul>
		</div>
	</form>

	<form id="MailerLogEmailSelector" method="post" action="<?= $scriptURL ?>?<?= $query_string ?>">
		<div class="wk-form-row">
 			<ul>
 				<li><label>Email Address</label></li>
				<li><input type="text" name="new_filter_dst" id="mailer-email" value="<?= array_key_exists('Email', $filter_roster) ? $filter_roster['Email']['value'] : '' ?>" size="24" maxlength="255" /></li>
				<li><button style="z-index:9002">Apply</button></li>
				<li><button style="z-index:9002" onclick="clearFilter(form, 'mailer-email');">Clear</button></li>
			</ul>
		</div>
	</form>
	
	<form id="MailerLogSubjectSelector" method="post" action="<?= $scriptURL ?>?<?= $query_string ?>">
		<div class="wk-form-row">
 			<ul>
 				<li><label>Subject</label></li>
				<li><input type="text" name="new_filter_subject" id="mailer-subject" value="<?= array_key_exists('Subject', $filter_roster) ? $filter_roster['Subject'] : '' ?>" size="24" maxlength="255" /></li>
				<li><button style="z-index:9002">Apply</button></li>
				<li><button style="z-index:9002" onclick="clearFilter(form, 'mailer-subject');">Clear</button></li>
			</ul>
		</div>
	</form>

	<form id="MailerLogBodySelector" method="post" action="<?= $scriptURL ?>?<?= $query_string ?>">
		<div class="wk-form-row">
 			<ul>
 				<li><label>Body</label></li>
				<li><input type="text" name="new_filter_body" id="mailer-body" value="<?= array_key_exists('Body', $filter_roster) ? $filter_roster['Body'] : '' ?>" size="24" maxlength="255" /></li>
				<li><button style="z-index:9002">Apply</button></li>
				<li><button style="z-index:9002" onclick="clearFilter(form, 'mailer-body');">Clear</button></li>
			</ul>
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
	<table>
		<tr>
			<th>ID<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=id&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=id&new_sort_dir=desc">desc</a></th>
			<th>Created<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=created&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=created&new_sort_dir=desc">desc</a></th>
			<th>Wiki<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=city_id&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=city_id&new_sort_dir=desc">desc</a></th>
			<th>To<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=dst&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=dst&new_sort_dir=desc">desc</a></th>
			<th>Subject</th>
			<th>Message</th>
			<th>Attempted</th>
			<th>Transmitted<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=transmitted&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=transmitted&new_sort_dir=desc">desc</a></th>
			<th>Error</th>
		</tr>
		<?php foreach ($records as $row): ?>
		<tr><td><?= $row['id'] ?></td><td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_created=<?= $row['created'] ?>"><?= $row['created'] ?></a></td><td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_wiki_id=<?= $row['city_id'] ?>"><?= $row['wiki_name'] ?></a></td><td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_dst=<?= $row['to'] ?>"><?= $row['to'] ?></a></td><td><?= $row['subject'] ?></td><td><?= $row['msg_short'] ?></td><td>---</td><td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_transmitted=<?= $row['transmitted'] ?>"><?= $row['transmitted'] ?></a></td><td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_error=1"><?= $row['error_msg'] ?></td></tr>
		<?php endforeach; ?>
	</table>
</div>


<!-- s:<?php echo __FILE__ ?> -->

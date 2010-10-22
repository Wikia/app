<?php global $wgScriptPath, $wgStylePath ?>
<div class="wikia-mailer-log">
	<div class="wikia-mailer-filters">
	<?php if (isset($filter_roster) && count($filter_roster)): ?>Filters: <?php endif; ?>
	<?php foreach ($filter_roster as $label => $info): ?>
		<span style="border: solid 2px #AAAAAA"><?= $label ?>: <?= $info['value'] ?> [<a href="<?= $scriptURL ?>?<?= $query_string ?>&<?= $info['off'] ?>=1">off</a>]</span>
	<?php endforeach; ?>
	</div>
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
		<tr><th>ID<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=id&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=id&new_sort_dir=desc">desc</a></th><th>Created<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=created&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=created&new_sort_dir=desc">desc</a></th><th>Wiki<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=city_id&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=city_id&new_sort_dir=desc">desc</a></th><th>To<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=dst&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=dst&new_sort_dir=desc">desc</a></th><th>Subject</th><th>Message </th></th><th>Attempted</th><th>Transmitted<br /><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=transmitted&new_sort_dir=asc">asc</a>/<a href="<?= $scriptURL ?>?<?= $query_string ?>&new_sort=transmitted&new_sort_dir=desc">desc</a></th><th>Error</th></tr>
		<?php foreach ($records as $row): ?>
		<tr><td><?= $row['id'] ?></td><td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_created=<?= $row['created'] ?>"><?= $row['created'] ?></a></td><td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_wiki_id=<?= $row['city_id'] ?>"><?= $row['wiki_name'] ?></a></td><td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_dst=<?= $row['to'] ?>"><?= $row['to'] ?></a></td><td><?= $row['subject'] ?></td><td><?= $row['msg_short'] ?></td><td>---</td><td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_transmitted=<?= $row['transmitted'] ?>"><?= $row['transmitted'] ?></a></td><td><a href="<?= $scriptURL ?>?<?= $query_string ?>&new_filter_error=1"><?= $row['error_msg'] ?></td></tr>
		<?php endforeach; ?>
	</table>
</div>
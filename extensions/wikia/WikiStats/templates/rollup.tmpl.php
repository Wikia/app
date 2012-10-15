<div id="ws-rollup">
	<form id="ws-form" action="<?= $mTitle->getLocalUrl() ?>/<?=$mAction?>" method="get">
	Stats for:
	<?php if ($wiki_select): ?>
			<input type="text" name="wswiki" value="<?= $wiki_name ?>" />	<?php else: ?>
		<?= $wiki_name ?>
	<?php endif; ?>
		<input type="radio" name="wsperiod" value="monthly"<?= $wsperiod == "monthly" ? ' checked="checked"' : '' ?>> Monthly
		<input type="radio" name="wsperiod" value="daily"<?= $wsperiod != "monthly" ? ' checked="checked"' : '' ?>> Daily	
		<input type="submit" name="filter" value="Go" />
	</form>
	<!-- $data[$start_date][$oRow->page_ns][$oRow->event_type] = $oRow->cnt; -->
	
	<table class="display" cellspacing="0">
		<tr><th>Period</th><th>Namespace</th><th>Err</th><th>Edits</th><th>Creates</th><th>Deletes</th><th>Undeletes</th></tr>
	<?php
		 $date_row = 1;
		 foreach (array_keys($data) as $period):
			$date_row++;
			$row = 1;
			$sorted_ns = array_keys($data[$period]);
			sort($sorted_ns);
			foreach ($sorted_ns as $page_ns):
	?>
		<tr class="row_selected <?= $date_row % 2 == 0 ? 'even' : 'odd' ?>">
			<td><?php echo ($row == 1 ? $period : '&nbsp'); $row++ ?></td>
			<td><?php $label = $page_ns ? MWNamespace::getCanonicalName($page_ns) : 'Main'; echo ($label ? $label : 'Unknown')." ($page_ns)" ?></td>
			<td><?= array_key_exists('0', $data[$period][$page_ns]) ? $data[$period][$page_ns][0] : '-' ?></td>
			<td><?= array_key_exists('1', $data[$period][$page_ns]) ? $data[$period][$page_ns][1] : '-' ?></td>
			<td><?= array_key_exists('2', $data[$period][$page_ns]) ? $data[$period][$page_ns][2] : '-' ?></td>
			<td><?= array_key_exists('3', $data[$period][$page_ns]) ? $data[$period][$page_ns][3] : '-' ?></td>
			<td><?= array_key_exists('4', $data[$period][$page_ns]) ? $data[$period][$page_ns][4] : '-' ?></td>
		</tr>
		<?php endforeach; ?>
	<?php endforeach; ?>
	</table>
</div>
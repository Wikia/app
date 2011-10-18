<div class="report_form">
	<form name="custom_reports" action="<?= $action ?>" method="get">
		<ul>
			<li>
				<b>Report:</b> 
				<select name="report">
					<?php foreach(array_keys($reports) as $r) { ?>
					<option value="<?= $r ?>" <?= (isset($report) && $r==$report) ? 'selected' : '' ?>><?= wfMsg('report-name-'.$r) ?></option>
					<?php } ?>
				</select>
			</li>
			<li>
				<b>Days:</b>
				<select name="days">
					<?php foreach($opt_days as $d) { ?>
					<option value="<?=$d?>" <?= (isset($days) && $days==$d) ? 'selected' : '' ?>><?=$d?></option>
					<?php } ?>
				</select>
			</li>
			<li>
				<input type="submit" value="Submit" />
			</li>
		</ul>
	</form>
</div>

<?= $charts ?>
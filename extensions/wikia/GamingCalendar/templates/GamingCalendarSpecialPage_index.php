<h2><?= $typeName ?> Calendar</h2>
<? if ($date) { ?>
<h3> <?= date('F Y', $date) ?></h3>
<? } ?>
<form name="getEntries" action="">
	Type: <select name="type">
<? foreach ($types as $typeShort=>$typeName) { ?>
		<option value="<?=$typeShort?>"<? if ($typeShort==$type) {?> selected<? } ?>><?=$typeName?></option>
<? } ?>
	</select>
	Year: <select name="year">
<? $firstYear = 2011; $lastYear = 2015;
for ($i=$firstYear; $i<=$lastYear; $i++) { ?>
		<option value="<?= $i ?>"<? if ($i==$year) {?> selected<? } ?>><?= $i ?></option>
<? } ?>
	</select>
	Month: <select name="month">
<? $months = array(1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec');
foreach ($months as $moIdx=>$moName) {?>
		<option value="<?=$moIdx?>"<? if ($moIdx==$month) {?> selected<? } ?>><?=$moName?></option>
<? } ?>
	</select>
	<input type="submit" value="Get entries" />
</form>
<div class="entries">
<? if (!empty($entries)) { ?>
	<ul>
	<? foreach ($entries as $entry) { ?>
		<li><a href="/wiki/Special:GamingCalendar?method=getEntriesForDate&type=<?=$type?>&date=<?= $entry['releaseDate']?>"><?= date('M j', $entry['releaseDate']) ?></a>, <?= $entry['gameTitle'] ?><? if (!empty($entry['gameSubtitle'])) {?> <?= $entry['gameSubtitle'] ?><?} ?></li>
<?	} ?>
	</ul>
<? } else { ?>
	<?= wfMsg('gamingcalendar-no-entries') ?>
<? } ?>
</div>
<div class="createEntries">
<?= wfMsg('gamingcalendar-create-entries-for-date')?>
<form name="createEntries" action="">
	Type: <select name="type">
<? foreach ($types as $typeShort=>$typeName) { ?>
		<option value="<?=$typeShort?>"<? if ($typeShort==$type) {?> selected<? } ?>><?=$typeName?></option>
<? } ?>
	</select>
	Year: <select name="year">
<? $firstYear = 2010; $lastYear = 2015;
for ($i=$firstYear; $i<=$lastYear; $i++) { ?>
		<option value="<?= $i ?>"<? if ($i==$year) {?> selected<? } ?>><?= $i ?></option>
<? } ?>
	</select>
	Month: <select name="month">
<? $months = array(1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dec');
foreach ($months as $moIdx=>$moName) {?>
		<option value="<?=$moIdx?>"<? if ($moIdx==$month) {?> selected<? } ?>><?=$moName?></option>
<? } ?>
	</select>
	Day: <select name="day">
<? for ($i=1; $i<=31; $i++) {?>
		<option value="<?=$i?>"><?=$i?></option>
<? } ?>
	</select>
	<input type="hidden" name="method" value="getEntriesForDate" />
	<input type="submit" value="Start creating entries" />
</form>
</div>
<h2><?= $typeName ?> Calendar</h2>
<? if ($date) { ?>
<h3> <?= date('F d, Y', $date) ?></h3>
<? } ?>
<section class="EditGamingCalendarEntries" id="EditGamingCalendarEntries" data-calendarentriesdate="<?=$date?>">
	<form>
	<ul>
		<li class="new-item">
				<div class="details">
					<div>
						<label><?= wfMsg('gamingcalendar-title') ?></label>
						<input type="text" name="title[]">
					</div>
					<div>
						<label><?= wfMsg('gamingcalendar-subtitle') ?></label>
						<input type="text" name="subtitle[]">
					</div>
					<div>
						<label><?= wfMsg('gamingcalendar-description') ?></label>
						<input type="text" name="description[]">
					</div>
					<div>
						<label><?= wfMsg('gamingcalendar-systems') ?></label>
						<input type="text" name="systems[]">
					</div>
					<div>
						<label><?= wfMsg('gamingcalendar-image') ?></label>
						<input type="text" name="image[]">
					</div>
					<div>
						<label><?= wfMsg('gamingcalendar-rating') ?></label>
						<input type="text" name="rating[]">
					</div>
					<div>
						<label><?= wfMsg('gamingcalendar-moreinfourl') ?></label>
						<input type="text" name="moreinfourl[]">
					</div>
					<div>
						<label><?= wfMsg('gamingcalendar-preorderurl') ?></label>
						<input type="text" name="preorderurl[]">
					</div>
				</div>
				<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
				<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
	<? foreach ($entries as $n=>$entry) { ?>
		<li>
			<label class="order"><?= "#".($n+1)?></label>
			<div class="details">
				<div>
					<label><?= wfMsg('gamingcalendar-title') ?></label>
					<input type="text" name="title[]" value="<?= htmlspecialchars($entry['gameTitle']) ?>">
				</div>
				<div>
					<label><?= wfMsg('gamingcalendar-subtitle') ?></label>
					<input type="text" name="subtitle[]" value="<?= htmlspecialchars($entry['gameSubtitle']) ?>">
				</div>
				<div>
					<label><?= wfMsg('gamingcalendar-description') ?></label>
					<input type="text" name="description[]" value="<?= htmlspecialchars($entry['description']) ?>">
				</div>
				<div>
					<label><?= wfMsg('gamingcalendar-systems') ?></label>
					<input type="text" name="systems[]" value="<?= htmlspecialchars(implode(', ', $entry['systems'])) ?>">
				</div>
				<div>
					<label><?= wfMsg('gamingcalendar-image') ?></label>
					<input type="text" name="image[]" value="<?= !empty($entry['image']['src']) ? htmlspecialchars($entry['image']['src']) : '' ?>">
				</div>
				<div>
					<label><?= wfMsg('gamingcalendar-rating') ?></label>
					<input type="text" name="rating[]" value="<?= htmlspecialchars($entry['rating']) ?>">
				</div>
				<div>
					<label><?= wfMsg('gamingcalendar-moreinfourl') ?></label>
					<input type="text" name="moreinfourl[]" value="<?= htmlspecialchars($entry['moreInfoUrl']) ?>">
				</div>
				<div>
					<label><?= wfMsg('gamingcalendar-preorderurl') ?></label>
					<input type="text" name="preorderurl[]" value="<?= htmlspecialchars($entry['preorderUrl']) ?>">
				</div>
			</div>
			<img src="<?= $wgBlankImgUrl ?>" class="sprite trash">
			<img src="<?= $wgBlankImgUrl ?>" class="sprite drag">
		</li>
	<? } ?>
	</ul>
	<div class="add-new">
		<a href="#" class="wikia-button secondary">+</a><?= wfMsg('gamingcalendar-addtitle') ?>
	</div>
	
	<div class="toolbar">
		<input type="button" value="<?= wfMsg('gamingcalendar-cancel') ?>" class="cancel secondary">
		<input type="button" value="<?= wfMsg('gamingcalendar-publish') ?>" class="create">
	</div>
	<input type="hidden" name="type" value="<?=$type?>">
	<input type="hidden" name="date" value="<?=$date?>">
	</form>
</section>
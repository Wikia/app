<div id="ws-upload">
	<div id="ws-progress-bar"></div>
	<div class="formblock ws-select-stats">
		<ul>
			<li><?= wfMsg("wikistats_info") ?>: <input name="ws-domain" id="ws-domain" value="<?=$domain?>" onfocus="ws_focus(event,'ws-domain','axWFactoryDomainQuery');" /></li>
		</ul>
		<ul>
			<li><span><?= wfMsg('wikistats_daterange_from') ?></span>
			<select name="ws-date-month-from" id="ws-date-month-from">
<?php foreach ($dateRange['months'] as $id => $month) { $selected = ( $fromMonth == ($id+1) ) ? " selected=\"selected\" " : ""; ?>
				<option value="<?= ($id+1) ?>" <?=$selected?>><?= ucfirst($month) ?></option>
<?php } ?>
				</select>
				<select name="ws-date-year-from" id="ws-date-year-from">
<?php 
$minYear = intval($dateRange['minYear']); $maxYear = intval($dateRange['maxYear']);
while ( $minYear <= $maxYear ) { $selected = ($fromYear == $minYear) ? " selected=\"selected\" " : ""; ?>
				<option <?= $selected ?> value="<?= $minYear ?>"><?= $minYear ?></option>
<?php $minYear++; } ?>
				</select>
			</li>	
			<li><span><?= wfMsg('wikistats_daterange_to') ?></span>
				<select name="ws-date-month-to" id="ws-date-month-to">
<?php foreach ($dateRange['months'] as $id => $month) { $k = $id+1; $selected = ($curMonth == $k) ? " selected=\"selected\" " : ""; ?>
				<option <?= $selected ?> value="<?= $k ?>"><?= ucfirst($month) ?></option>
<?php } ?>
				</select>
				<select name="ws-date-year-to" id="ws-date-year-to">
<?php 
$minYear = intval($dateRange['minYear']); $maxYear = intval($dateRange['maxYear']);
while ($minYear <= $maxYear) { $selected = ($curYear == $minYear) ? " selected=\"selected\" " : ""; ?>
				<option <?= $selected ?> value="<?= $minYear ?>"><?= $minYear ?></option>
<?php $minYear++; } ?>
				</select>
			</li>
		</ul>
		<ul>
			<li><span><?=wfMsg('wikistats_wikicategory')?></span></li>
			<li><select name="ws-category" id="ws-category">
<?php if (!empty($categories) && is_array($categories) ): ?>
				<option value=""></option>
<?php foreach ($categories as $iCat => $sCatName) : ?>
				<option value="<?php echo $iCat ?>"><?php echo $sCatName?></option>
<?php endforeach ?>
				<option value="9"><?=wfMsg('wikistats_other')?></option>
<?php endif ?>
				</select>
			</li>
			<li><span><?=wfMsg('wikistats_wikilang')?></span></li>
			<li><select name="ws-language" id="ws-language">
				<option value=""></option>
<?php if (!empty($topLanguages) && is_array($topLanguages)) : ?>
				<optgroup label="<?= wfMsg('wikistats_language_top', count($topLanguages)) ?>">
<?php foreach ($topLanguages as $sLang) : ?>
				<option value="<?=$sLang?>"><?=$sLang?>: <?=$aLanguages[$sLang]?></option>
<?php endforeach ?>
				</optgroup>
<?php endif ?>
				<optgroup label="<?= wfMsg('wikistats_language_all') ?>">
<?php if (!empty($aLanguages) && is_array($aLanguages)) : ?>
<?php ksort($aLanguages); foreach ($aLanguages as $sLang => $sLangName) : ?>
				<option value="<?=$sLang?>"><?=$sLang?>: <?=$sLangName?></option>
<?php endforeach ?>
				</optgroup>
<?php endif ?>
				</select>
			</li>
		</ul>
		<ul>
			<li><input type="button" id="ws-show-stats" name="ws-show-stats" value="<?= wfMsg("wikistats_showstats_btn") ?>" /></li>
			<!--<li><input type="button" id="ws-show-charts" value="<?= wfMsg("wikistats_showcharts") ?>" name="ws-show-charts" /></li>-->
			<li><input type="button" id="ws-export-xls" value="<?= wfMsg("wikistats_export_xls") ?>" name="ws-export-xls" /></li>
		</ul>
	</div>
	<div class="ws-info-generated">
		<?=wfMsg("wikistats_date_of_generate", ( !empty($updateDate) ) ? $updateDate : " - " );?>
	</div>	
</div>

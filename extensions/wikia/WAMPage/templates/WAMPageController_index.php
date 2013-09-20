<ul class="wam-tabs">
	<? foreach($tabs as $tab): ?>
		<li>
			<a 
				href="<?= $tab['url'] ?>"
				<?php if( !empty($tab['selected']) ): ?>
					class="selected"
				<?php endif; ?>
			>
				<?= $tab['name'] ?>
			</a>
		</li>
	<? endforeach; ?>
</ul>
<div class="wam-header">
	<div class="wam-cards">
		<? 	$i = 1;
			foreach($visualizationWikis as $k => $wiki): ?>
			<a href="http://<?= $wiki['url'] ?>" class="wam-card card<?= $i++ ?>">
				<figure>
					<? if(!empty($wiki['wiki_image'])): ?>
						<img src="<?= $wiki['wiki_image'] ?>" alt="<?= $wiki['title'] ?>" title="<?= $wiki['title'] ?>" />
					<? endif ?>
					<span><?= $wiki['title'] ?></span>
				</figure>
				<div class="wam-score vertical-<?= $wiki['hub_id'] ?> wam-<?= $wiki['change'] ?>">
					<?= $wg->ContLang->formatNum(number_format($wiki['wam'], WAMPageModel::SCORE_ROUND_PRECISION)) ?>
				</div>
				<span class="wam-vertical"><?= $wiki['hub_name'] ?></span>
			</a>
		<? endforeach ?>
	</div>
	
    <h2><?= $subpageText ?></h2>
</div>
<div class="wam-progressbar"></div>
<div class="wam-content">
	<h2><?= wfMessage('wampage-header-wam')->text(); ?></h2>
	<?= wfMessage(
		'wampage-content',
		$faqPage
	)->parse(); ?>
</div>

<div class="wam-index" id="wam-index">
	<form method="get" action="" class="wam-index-search" id="wam-index-search">
		<div class="filtering">
			<label for="verticalId"><?= wfMessage('wam-index-filter-sort-label')->text() ?></label>
			<select name="verticalId" id="verticalId">
				<option value=""><?= wfMessage('wam-index-filter-vertical-default')->text() ?></option>
				<? foreach ($filterVerticals as $verticalId => $verticalName): ?>
				<option value="<?=$verticalId?>"<? if ($selectedVerticalId == $verticalId): ?>selected="selected"<? endif ?>><?=$verticalName?></option>
				<? endforeach ?>
			</select>
			<label for="WamFilterDate"><?= wfMessage('wam-index-filter-date-label')->text() ?></label>
			<input type="text" name="date" id="WamFilterDate" value="<?=$selectedDate?>" placeholder="<?= $wg->Lang->date(time()); ?>"/>
			<label for="langCode"><?= wfMessage('wam-index-filter-lang-label')->text() ?></label>
			<select name="langCode" id="langCode">
				<option value=""><?= wfMessage('wam-index-filter-language-default')->text() ?></option>
				<? foreach ($filterLanguages as $langCode): ?>
				<option value="<?=$langCode?>"<? if ($selectedLangCode == $langCode): ?>selected="selected"<? endif ?>><?= $wg->ContLang->getLanguageName( $langCode )?></option>
				<? endforeach ?>
			</select>
		</div>
		<div class="searching">
			<input type="text" name="searchPhrase" value="<?=$searchPhrase?>" placeholder=" <?= wfMessage('wam-index-filter-search-placeholder')->text() ?>" />
			<button type="submit" value="<?= wfMessage('wam-index-search-button')->text() ?>" class="secondary">
				<img src="<?= $wg->BlankImgUrl ?>" />
			</button>
		</div>
	</form>
	<table>
		<tr>
			<th></th>
			<th><?= wfMessage('wam-index-header-score')->text() ?></th>
			<th><?= wfMessage('wam-index-header-rank')->text() ?></th>
			<th><?= wfMessage('wam-index-header-peak-rank')->text() ?></th>
			<th><?= wfMessage('wam-index-header-wiki-name')->text() ?></th>
			<th><?= wfMessage('wam-index-header-vertical')->text() ?></th>
			<th><?= wfMessage('wam-index-header-vertical-rank')->text() ?></th>
            <th><?= wfMessage('wam-index-header-admins')->text() ?></th>
		</tr>

		<? if($indexWikis['wam_index']): ?>
			<? foreach ($indexWikis['wam_index'] as $wiki): ?>
				<tr>
					<td><?=$wiki['index']?>.</td>
					<td class="score <?=$wiki['change']?>">
						<?= $wg->Lang->formatNum(number_format($wiki['wam'], WAMPageModel::SCORE_ROUND_PRECISION))?>
					</td>
					<td><?=$wiki['wam_rank']?></td>
					<td><?=$wiki['peak_wam_rank']?></td>
					<td><a href="http://<?=$wiki['url']?>"><?=$wiki['url']?></a></td>
					<td><?=$wiki['hub_name']?></td>
					<td><?=$wiki['hub_wam_rank']?></td>
					<td class="admins">
						<? if(!empty($wiki['admins'])): ?>
							<ul>
							<? foreach($wiki['admins'] as $admin): ?>
								<li><a href="<?= $admin['userPageUrl'] ?>">
									<img src="<?= $admin['avatarUrl'] ?>" alt="<?= $admin['name'] ?>" title="<?= $admin['name'] ?>" />
								</a></li>
							<? endforeach ?>
							</ul>
						<? endif ?>
					</td>
				</tr>
			<? endforeach ?>
		<? else: ?>
			<tr class="no-results"><td colspan="8">
				<p class="plainlinks">
					<?= wfMessage('wam-index-no-results')->parse(); ?>
				</p>
			</td></tr>
		<? endif; ?>
	</table>
	<?php if( !empty($paginatorBar) ): ?>
		<?= $paginatorBar; ?>
	<?php endif; ?>
</div>

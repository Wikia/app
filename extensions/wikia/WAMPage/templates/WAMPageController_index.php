<div class="wam-header">
	<div class="wam-top-gainers-cards">
		<h2 class="wam-top-gainers-header"><?= wfMessage('wampage-top-gainers-header')->escaped(); ?><? if ( $isSingleVertical ) : ?>: <span class="vertical-<?= $verticalsShorts[ $selectedVerticalId ] ?>"><?= $filterVerticals[ $selectedVerticalId ] ?></span><? endif; ?></h2>
		<div class="wam-cards">
			<? 	$i = 1;
				foreach( $visualizationWikis as $k => $wiki ): ?>
				<a href="http://<?= $wiki['url'] ?>" class="wam-card card<?= $i++ ?>">
					<figure>
						<? if(!empty($wiki['wiki_image'])): ?>
							<img src="<?= $wiki['wiki_image'] ?>" alt="<?= $wiki['title'] ?>" title="<?= $wiki['title'] ?>" />
						<? endif ?>
						<span><?= $wiki['title'] ?></span>
					</figure>
					<div class="wam-score vertical-bg-<?= $verticalsShorts[ $wiki['vertical_id'] ] ?> wam-<?= $wiki['change'] ?>">
						<?= $wg->ContLang->formatNum( number_format( $wiki['wam'], WAMPageModel::SCORE_ROUND_PRECISION ) ) ?>
					</div>
					<span class="wam-vertical"><?= $wiki['vertical_name'] ?></span>
				</a>
			<? endforeach ?>
		</div>
	</div>
	<ol class="wam-top-gainers-list">
	<?	foreach( $visualizationWikis as $k => $wiki ): ?>
			<li class="wam-top-gainers-list-item"><?= $wiki['title'] ?></li>
	<?	endforeach; ?>
	</ol>
</div>

<div class="wam-content">
	<div class="wam-content-logo"></div>
	<div class="wam-content-text">
		<h2><?= wfMessage( 'wampage-header-wam' )->escaped(); ?></h2>
		<h3><?= wfMessage( 'wampage-subheader-wam' )->escaped(); ?></h3>
		<p><?= wfMessage( 'wampage-content' )->parse(); ?></p>
		<span class="wam-content-faq-link"><?= wfMessage( 'wampage-content-faq-link', $faqPage )->parse(); ?></span>
	</div>
</div>

<div class="wam-index" id="wam-index">
	<form method="get" action="" class="wam-index-search" id="wam-index-search">
		<div class="wam-verticals-tabs">
			<ul>
			<? foreach ( $filterVerticals as $verticalId => $verticalName ) : ?>
				<li class="wam-filtering-tab <? if ( $verticalId == $selectedVerticalId ) : ?> selected<? endif; ?>" data-vertical-id="<?= $verticalId ?>">
					<a>
						<span class="icon-vertical icon-vertical-<?= $verticalsShorts[ $verticalId ] ?>"></span>
						<?= $verticalName ?>
					</a>
				</li>
			<? endforeach; ?>
			</ul>
		</div>
		<div class="filtering">
			<input type="hidden" name="verticalId" class="wam-filtering-vertical-id" value="<?= $selectedVerticalId ?>"/>
			<label for="langCode"><?= wfMessage('wam-index-filter-lang-label')->escaped() ?></label>
			<select name="langCode" id="langCode">
				<option value=""><?= wfMessage('wam-index-filter-language-default')->escaped() ?></option>
				<? foreach ($filterLanguages as $langCode): ?>
				<option value="<?=$langCode?>"<? if ($selectedLangCode == $langCode): ?>selected="selected"<? endif ?>><?= $wg->ContLang->getLanguageName( $langCode )?></option>
				<? endforeach ?>
			</select>
			<input type="hidden" name="date" id="WamFilterDate" value="<?=$selectedDate?>"/>
			<label for="WamFilterDate"><?= wfMessage('wam-index-filter-date-label')->escaped() ?></label>
			<input type="text" id="WamFilterHumanDate" value="<?= $wg->Lang->date($selectedDate); ?>" placeholder="<?= $wg->Lang->date(time()); ?>"/>
		</div>
		<div class="searching">
			<input type="text" name="searchPhrase" value="<?=$searchPhrase?>" placeholder=" <?= wfMessage('wam-index-filter-search-placeholder')->escaped() ?>" />
			<button type="submit" value="<?= wfMessage('wam-index-search-button')->escaped() ?>" class="secondary">
				<img src="<?= $wg->BlankImgUrl ?>" />
			</button>
		</div>
	</form>
	<div class="wam-index-table-wrapper">
		<table>
			<tr>
				<th><?= wfMessage('wam-index-header-rank')->escaped() ?></th>
				<th><?= wfMessage('wam-index-header-score')->escaped() ?></th>
				<th><?= wfMessage('wam-index-header-peak-rank')->escaped() ?></th>
				<th><?= wfMessage('wam-index-header-wiki-name')->escaped() ?></th>
				<? if ( !$isSingleVertical ) : ?>
					<th><?= wfMessage('wam-index-header-vertical')->escaped() ?></th>
					<th><?= wfMessage('wam-index-header-vertical-rank')->escaped() ?></th>
				<? endif; ?>
				<th><?= wfMessage('wam-index-header-admins')->escaped() ?></th>
			</tr>

			<? if($indexWikis['wam_index']): ?>
				<? foreach ($indexWikis['wam_index'] as $wiki): ?>
					<tr>
						<? if ( !$isSingleVertical ) : ?>
							<td><?=$wiki['wam_rank']?></td>
						<? else: ?>
							<td><?=$wiki['vertical_wam_rank']?></td>
						<? endif; ?>
						<td class="score <?=$wiki['change']?>">
							<?= $wg->Lang->formatNum(number_format($wiki['wam'], WAMPageModel::SCORE_ROUND_PRECISION))?>
						</td>
						<td><?=$wiki['peak_vertical_wam_rank']?></td>
						<td><a href="http://<?=$wiki['url']?>"><?=$wiki['url']?></a></td>
						<? if ( $selectedVerticalId == 0 ) : ?>
							<td><?=$wiki['vertical_name']?></td>
							<td><?=$wiki['vertical_wam_rank']?></td>
						<? endif; ?>
						<td class="admins">
							<? if(!empty($wiki['admins'])) : ?>
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
</div>

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
					<?= $wg->Lang->formatNum(number_format($wiki['wam'], WAMPageModel::SCORE_ROUND_PRECISION)) ?>
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

<div class="wam-index">
	<table>
		<tr>
			<th><?= wfMessage('wam-index-header-rank')->text() ?></th>
			<th><?= wfMessage('wam-index-header-score')->text() ?></th>
			<th><?= wfMessage('wam-index-header-wiki-name')->text() ?></th>
			<th><?= wfMessage('wam-index-header-vertical')->text() ?></th>
			<th><?= wfMessage('wam-index-header-vertical-rank')->text() ?></th>
			<th><?= wfMessage('wam-index-header-peak-rank')->text() ?></th>
		</tr>

		<? foreach ($indexWikis['wam_index'] as $wiki): ?>
			<tr>
				<td><?=$wiki['wam_rank']?>.</td>
				<td class="score <?=$wiki['change']?>">
					<?= $wg->Lang->formatNum(number_format($wiki['wam'], WAMPageModel::SCORE_ROUND_PRECISION))?>
				</td>
				<td><a href="http://<?=$wiki['url']?>"><?=$wiki['url']?></a></td>
				<td><?=$wiki['hub_name']?></td>
				<td><?=$wiki['hub_wam_rank']?></td>
				<td><?=$wiki['peak_wam_rank']?></td>
			</tr>
		<? endforeach ?>
	</table>
</div>

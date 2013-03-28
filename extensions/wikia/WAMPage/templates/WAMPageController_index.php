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
			foreach($visualizationWikis as $k => $wiki) { ?>
			<a href="http://<?= $wiki['url'] ?>" class="wam-card card<?= $i++ ?>">
				<figure>
					<img src="<?= $wiki['wiki_image'] ?>" alt="<?= $wiki['title'] ?>" title="<?= $wiki['title'] ?>" />
					<span><?= $wiki['title'] ?></span>
				</figure>
				<div class="wam-score vertical-<?= $wiki['hub_id'] ?> wam-<?= $wiki['change'] ?>"><?= $wiki['wam'] ?></div>
				<span class="wam-vertical"><?= $wiki['hub_name'] ?></span>
			</a>
		<? } // end foreach ?>
	</div>
	
    <h2><?= wfMessage('wampage-header')->text(); ?></h2>
</div>
<div class="wam-progressbar"></div>
<div class="wam-content">
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

		<? $i = 1; ?>
		<? foreach ($indexWikis['wam_index'] as $wiki): ?>
			<tr>
				<td><?=$i++ ?>.</td>
				<td class="score <?=$wiki['change']?>"><?=$wiki['wam']?></td>
				<td><a href="http://<?=$wiki['url']?>"><?=$wiki['url']?></a></td>
				<td><?=$wiki['hub_name']?></td>
				<td><?=$wiki['peak_hub_wam_rank']?></td>
				<td><?=$wiki['peak_wam_rank']?></td>
			</tr>
		<? endforeach ?>
	</table>
</div>

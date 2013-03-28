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
		<tr>
			<td>1.</td>
			<td class="score up">99.91</td>
			<td><a href="http://www.wikia.com">runescape.wikia.com</a></td>
			<td>Video Games</td>
			<td>1</td>
			<td>1</td>
		</tr>
		<tr>
			<td>2.</td>
			<td class="score down">99.91</td>
			<td><a href="http://www.wikia.com">runescape.wikia.com</a></td>
			<td>Video Games</td>
			<td>1</td>
			<td>1</td>
		</tr>
		<tr>
			<td>3.</td>
			<td class="score nochange">99.91</td>
			<td><a href="http://www.wikia.com">runescape.wikia.com</a></td>
			<td>Video Games</td>
			<td>1</td>
			<td>1</td>
		</tr>
	</table>
</div>

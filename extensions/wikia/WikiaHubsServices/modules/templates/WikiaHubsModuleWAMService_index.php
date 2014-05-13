<div class="wam-content">
	<div class="title">
		<img src="<?= $wg->BlankImgUrl; ?>" class="logo" />
		<h2>
			<?= wfMessage('wikiahubs-wam-header')->text(); ?>
		</h2>
		<a href="<?= $wamPageUrl; ?>" class="read-more">
			<?= wfMessage('wikiahubs-wam-see-full-wam-ranking')->text(); ?>
		</a>
	</div>
	<h3>
		<?= wfMessage('wikiahubs-wam-top-wikis-headline', $verticalName)->text(); ?>
	</h3>
	<?php if( !empty($ranking) ): ?>
		<table class="score-table">
			<thead>
				<tr>
					<th><?= wfMessage('wikiahubs-wam-rank')->text() ?></th>
					<th><?= wfMessage('wikiahubs-wam-score')->text() ?></th>
					<th></th>
					<th><?= wfMessage('wikiahubs-wam-wiki-url')->text() ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($ranking as $wiki): ?>
					<tr data-rank="<?= $wiki['rank']; ?>">
						<td class="rank"><?= $wiki['rank']; ?>.</td>
						<td class="score">
							<img src="<?= $wg->BlankImgUrl; ?>" class="<?= $scoreChangeMap[$wiki['change']]; ?>" />
							<?= number_format( $wiki['wamScore'], WikiaHubsModuleWAMService::WAM_SCORE_DECIMALS ); ?>
						</td>
						<td>
							<a href="<?= $wiki['wikiUrl']; ?>" class="wiki-thumb">
								<img
									src="<?= ($wiki['imageUrl']) ? $wiki['imageUrl'] : $wg->BlankImgUrl; ?>"
									width="<?= $imagesWidth; ?>px" height="<?= $imagesHeight; ?>px"
								/>
							</a>
						</td>
						<td class="url">
							<a href="<?= $wiki['wikiUrl']; ?>" class="wiki-name"><?= $wiki['wikiName']; ?></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>

<div>
	<div class="social-links">
		<a href="#"><img src="<?= $wg->BlankImgUrl; ?>" class="facebook" /></a>
		<a href="#"><img src="<?= $wg->BlankImgUrl; ?>" class="twitter" /></a>
		<a href="#"><img src="<?= $wg->BlankImgUrl; ?>" class="gplus" /></a>
	</div>
	<div class="search">
		<form method="get" action="index.php?title=Special:Search" class="WikiaSearch" id="WikiaSearch">
			<input type="text" value="" accesskey="f" autocomplete="off" placeholder="<?= wfMessage('wikiahubs-search-placeholder')->text(); ?>" name="search" id="HubSearch" />
			<input type="hidden" value="0" name="fulltext" />
			<input type="submit" />
			<button class="wikia-button">
				<img width="21" height="17" class="sprite search" src="<?= $wg->BlankImgUrl; ?>" />
			</button>
		</form>
	</div>
</div>
<div class="wam-content">
	<div class="title">
		<img src="<?= $wg->BlankImgUrl; ?>" class="logo" />
		<h2>
			<?= wfMessage('wikiahubs-wam-header')->text(); ?>
		</h2>
		<a href="<?= $wamPageUrl; ?>">
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
					<tr>
						<td class="rank"><?= $wiki['rank']; ?>.</td>
						<td class="score">
							<img src="<?= $wg->BlankImgUrl; ?>" class="
								<?
									switch ($wiki['change']) {
										case '-1':
											echo 'down';
											break;
										case '0':
											echo 'nochange';
											break;
										case '1':
											echo 'up';
											break;
									}
								?>
							" />
							<?= $wiki['wamScore']; ?>
						</td>
						<td>
							<img src="<?= $wiki['imageUrl']; ?>" />
						</td>
						<td class="url">
							<a href="<?= $wiki['wikiUrl']; ?>" target="_blank"><?= $wiki['wikiName']; ?></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>

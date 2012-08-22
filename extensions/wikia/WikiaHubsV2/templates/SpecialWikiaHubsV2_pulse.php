	<span class="social">
		<a href="<?= $socialmedia['facebook'] ?>" id="facebook"></a>
		<a href="<?= $socialmedia['twitter'] ?>" id="twitter"></a>
		<a href="<?= $socialmedia['googleplus'] ?>" id="google"></a>
	</span>
	<h2><?= wfMsgExt(
		'wikiahubs-pulse',
		array('parseinline'),
		$title['href'],
		$title['anchor']
	) ?></h2>
	<div class="pulse-content">
		<div class="boxes">
			<? if (is_array($boxes)): ?>
				<? foreach($boxes as $box): ?>
					<div class="box">
						<h5>
							<strong><a href="<?= $box['headline']['href'] ?>">
								<?= $box['headline']['anchor'] ?>
							</a></strong>
						</h5>
						<strong><?= $box['number'] ?><?= !empty($box['unit'])?' ' . $box['unit']:''; ?></strong>
						<br />
						<a href="<?= $box['link']['href'] ?>">
							<?= $box['link']['anchor'] ?>
						</a>
					</div>
				<? endforeach; ?>
			<? endif; ?>
		</div>
		<div class="search">
			<div class="buttons">
				<label for="HubSearch"><?= wfMsg('wikiahubs-pulse-whats-your-game') ?></label>
				<?= F::app()->renderView('Search','index') ?>
			</div>
		</div>
	</div>
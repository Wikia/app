<h2>
	<?= $headline ?>
	<? if (!F::app()->checkSkin('wikiamobile')): ?>
		<button id="suggestArticle" class="wikia-button secondary">
			<?= wfMsg('wikiahubs-from-community-promoted') ?>
		</button>
	<? endif; ?>
</h2>
<ul class="wikiahubs-ftc-list">
	<? foreach($entries as $entry): ?>
		<li class="wikiahubs-ftc-item">
			<div class="floatleft">
				<a href="<?= $entry['blogurl'] ?>">
					<img alt="<?= $entry['image'] ?>" src="<?= $entry['imagethumb'] ?>" width="570" height="300" />
				</a>
			</div>
			<div class="wikiahubs-ftc-title">
				<p>
					<a class="text" href="<?= $entry['article']['href'] ?>">
						<?= $entry['article']['anchor']; ?>
					</a>
				</p>
			</div>
			<div class="wikiahubs-ftc-subtitle">
				<p class="plaintext">
					<?= wfMsgExt(
						'wikiahubs-from-community-caption',
						array('parseinline'),
						$entry['contributor']['href'],
						$entry['contributor']['name'],
						$entry['wikilink']['href'],
						$entry['wikilink']['anchor']
					) ?>
				</p>
			</div>
			<div class="wikiahubs-ftc-creative">
				<p>
					<b><?= $entry['subtitle'] ?></b><br />
				</p>
				<?= $entry['content'] ?>
			</div>
		</li>
	<? endforeach; ?>
</ul>
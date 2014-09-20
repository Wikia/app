<h2>
	<?= $headline ?>
	<? if (!F::app()->checkSkin('wikiamobile')): ?>
		<button id="suggestArticle" class="wikia-button secondary">
			<?= $button ?>
		</button>
	<? endif; ?>
</h2>
<ul class="wikiahubs-ftc-list">
	<? foreach($entries as $entry): ?>
		<li class="wikiahubs-ftc-item">
			<div class="floatleft">
				<a href="<?= $entry['articleUrl'] ?>">
					<img alt="<?= $entry['imageAlt'] ?>" src="<?= $entry['imageUrl'] ?>" />
				</a>
			</div>
			<div class="wikiahubs-ftc-title">
				<p>
					<a class="text" href="<?= $entry['articleUrl'] ?>">
						<?= $entry['articleTitle']; ?>
					</a>
				</p>
			</div>
			<div class="wikiahubs-ftc-subtitle">
				<p class="plaintext plainlinks">
					<?= wfMessage(
						'wikiahubs-v3-from-community-caption',
						$entry['userUrl'],
						$entry['userName'],
						$entry['articleUrl'],
						$entry['wikiUrl']
					)->parse(); ?>
				</p>
			</div>
			<div class="wikiahubs-ftc-creative">
				<?= $entry['quote'] ?>
			</div>
		</li>
	<? endforeach; ?>
</ul>

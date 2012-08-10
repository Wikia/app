<h2>
	<?= $headline ?>
	<button id="suggestArticle" class="wikia-button secondary">Get Promoted </button>
</h2>
<ul class="wikiahubs-ftc-list">
	<? foreach($entries as $entry): ?>
		<li class="wikiahubs-ftc-item">
			<div class="floatleft">
				<a href="http://assassinscreed.wikia.com/wiki/User_blog:Master_Sima_Yi/Assassinews_07/09_-_Assassin%27s_Creed_film_news">
					<img alt="<?= $entry['image'] ?>" src="<?= $entry['imagethumb'] ?>" width="570" height="300" />
				</a>
			</div>
			<div class="wikiahubs-ftc-title">
				<p>
					<a class="text" href="<?= $entry['article']['href'] ?>">
						<?= $entry['article']['title']; ?>
					</a>
				</p>
			</div>
			<div class="wikiahubs-ftc-subtitle">
				<p>
					From <a  class="text" href="<?= $entry['contributor']['href'] ?>">
						<?= $entry['contributor']['name'] ?>
					</a>
					on <a  class="text" href="<?= $entry['wikilink']['href'] ?>">
						<?= $entry['wikilink']['title'] ?>
					</a>
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
<section class="grid-2 alpha wikiahubs-top-wikis">
	<h2>
		<span class="mw-headline" id="Top_Gaming_Wikis"><?= $headline; ?></span>
	</h2>
	<div class="description">
		<?= $description; ?>
	</div>
	<div class="top-wikis-content">
		<ol>
			<? if(is_array($wikis)): ?>
				<? foreach($wikis as $wiki): ?>
				<li>
					<a  class="text" title="<?= $wiki['title']; ?>" href="<?= $wiki['href']; ?>"><?= $wiki['title']; ?></a>
				</li>
				<? endforeach; ?>
			<? endif; ?>
		</ol>
	</div>
</section>
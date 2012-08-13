<h2><?= $headline; ?></h2>

<p class="description">
	<?= $description; ?>
</p>

<div class="top-wikis-content">
	<ol>
		<? if(is_array($wikis)): ?>
			<? foreach($wikis as $wiki): ?>
			<li>
				<a  class="text" title="<?= $wiki['anchor']; ?>" href="<?= $wiki['href']; ?>"><?= $wiki['anchor']; ?></a>
			</li>
			<? endforeach; ?>
		<? endif; ?>
	</ol>
</div>

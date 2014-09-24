<ul class="second">
	<? foreach ($nodes as $i2 => $node2): ?>
		<li>
			<a href="<?= $node2['href']; ?>">
				<?= $node2['text']; ?>
				<span class="overlay"><?= $node2['text']; ?></span>
			</a>
			<span class="more"></span>
		</li>
	<? endforeach; ?>
</ul>

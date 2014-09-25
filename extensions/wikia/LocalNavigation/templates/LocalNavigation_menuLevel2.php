<ul class="second dropdown">
	<? foreach ($nodes as $i2 => $node2): ?>
		<li>
			<a href="<?= $node2['href']; ?>" data-content="<?= $node2['text']; ?>" class="has-more">
				<span><?= $node2['text']; ?></span>
				<span class="more"></span>
			</a>
		</li>
	<? endforeach; ?>
</ul>

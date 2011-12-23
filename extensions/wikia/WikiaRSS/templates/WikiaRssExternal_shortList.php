<div class="wikiaRss">
	<ul>
		<?php foreach($items as $item): ?>
			<li>
				<a href="<?= $item['href']; ?>" title="<?= $item['attrTitle']; ?>"><?= $item['title']; ?></a>
				<?php if( $item['date'] ): ?>
					(<?= $item['date']; ?>)
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
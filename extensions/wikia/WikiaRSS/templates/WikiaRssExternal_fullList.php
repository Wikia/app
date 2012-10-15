<div class="wikiaRss">
	<dl>
		<?php foreach($items as $item): ?>
			<dt>
				<a href="<?= $item['href']; ?>"><b><?= $item['title']; ?></b></a>
				<?php if( !empty($item['date']) ): ?>
					(<?= $item['date']; ?>)
				<?php endif; ?>
			</dt>
			
			<?php if( $item['text'] ): ?>
				<dd>
					<?= $item['text']; ?>
					<b>[<a href="<?= $item['href']; ?>">?</a>]</b>
				</dd>
			<?php endif; ?>
		<?php endforeach; ?>
	</dl>
</div>
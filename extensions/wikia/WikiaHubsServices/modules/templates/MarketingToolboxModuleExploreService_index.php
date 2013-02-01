<h2><?= $headline ?></h2>

<div class="explore-content">
	<? if( !empty($image) ): ?>
	<figure>
		<img src="<?= $image; ?>" class="image" />
	</figure>
	<? endif; ?>

	<? if( !empty($linkgroups) ): ?>
	<? foreach( $linkgroups as $linkgroup ): ?>
		<h4><?= $linkgroup['headline']; ?></h4>

		<? if( !empty($linkgroup['links']) ): ?>
			<ul>
				<? foreach ($linkgroup['links'] as $singlelink): ?>
				<li>
					<?php if( !empty($singlelink['href']) ): ?>
					<a href="<?= $singlelink['href']; ?>"><?= $singlelink['anchor']; ?></a>
					<?php else: ?>
					<?= $singlelink['anchor']; ?>
					<?php endif; ?>
				</li>
				<? endforeach; ?>
			</ul>
			<? endif; ?>
		<? endforeach; ?>
	<? endif; ?>
</div>
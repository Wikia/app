<h2><?= $headline ?></h2>

<div class="explore-content">
	<? if (!empty($article)): ?>
	<? if (!empty($image)): ?>
		<figure>
			<img src='<?= $image; ?>' class='image'/>
		</figure>
		<? endif; ?>

	<p>
		<?= $article; ?>
	</p>
	<? endif; ?>

	<? if (!empty($linkgroups)): ?>
	<? foreach ($linkgroups as $linkgroup): ?>
		<? if (!empty($linkgroup['links'])): ?>
			<h4><?= $linkgroup['headline']; ?></h4>

			<ul>
				<? foreach ($linkgroup['links'] as $singlelink): ?>
				<li>
					<a href='<?= $singlelink['href']; ?>'><?= $singlelink['anchor']; ?></a>
				</li>
				<? endforeach; ?>
			</ul>

			<? endif; ?>
		<? endforeach; ?>

	<? if (!empty($link)): ?>
		<p class='text'>
			<a href='<?= $link['href']; ?>'><?= $link['anchor']; ?></a>
		</p>
		<? endif; ?>
	<? endif; ?>
</div>
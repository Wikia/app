<section class='grid-1 alpha wikiahubs-explore wikiahubs-module plainlinks'>
	<h2><?= $headline ?></h2>

	<? if (!empty($article)): ?>
	<div class="explore-content">
		<? if (!empty($image)): ?>
		<figure>
			<img src='<?= $image; ?>' class='image'/>
		</figure>
		<? endif; ?>

		<p>
			<?= $article; ?>
		</p>
	</div>
	<? endif; ?>

	<? if (!empty($linkgroups)): ?>
	<div class="explore-content">
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
	</div>
	<? endif; ?>

	<?php
	/*
	   $this->headline = $exploreData['headline'];
	   $this->article = $exploreData['article'];
	   $this->image = $exploreData['image'];
	   $this->link = $exploreData['link'];
	   */
	?>
</section>
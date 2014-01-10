<section class="module">
	<div class="bopfm-contents">
		<h1 class="bopfm-headline">
			bop.fm
		</h1>
		<?php
			// A bunch of data to pass to the widget
			// TODO: ONCE THIS IS WORKING, MOVE THESE TO THE CONTROLLER... THAT'S WHERE VARS SHOULD BE SET.
			$id = "bopfm_1"; // TODO: Add a unique id? What should it be... the article-id? amg-id?
			$width = "298"; // this gets passed to bop.fm so that they know how wide to render their widget
			//$artist = "{{ARTIST}}";
			//$songName = "{{SONG}}";
			
			$artist="Cake";$songName="Dime"; // TODO: REMOVE
			$pageUrl = urlencode($wg->Title->getFullURL());
		?><a id="<?= $id ?>" data-width="<?= $width ?>" data-bop-link href="http://www.bop.fm/embed/<?= $artist ?>/<?= $songName ?>/<?= $pageUrl ?>">
			<?= $artist ?> - <?= $songName ?>
		</a>
		<script async src="http://assets.bop.fm/embed.js"></script>
	</div>
</section>

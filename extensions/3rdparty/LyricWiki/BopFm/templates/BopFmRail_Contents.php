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
		?><a id="<?= $id ?>" data-width="<?= $width ?>" data-bop-link href="http://www.bop.fm/embed/<?= $artist ?>/<?= $songName ?>">
			<?= $artist ?> - <?= $songName ?>
		</a><?php
			// NOTE: This is the correct URL for the widget and we should revert to it when we can. At the
			// moment, there is an incompatibility between our AMD implementation and that script.
			//$scriptUrl = "http://assets.bop.fm/embed.js";
			
			// Temporary fix, to allow us to use a modified version of Bop.fm's code.
			$scriptUrl = $wg->ScriptPath."/extensions/3rdparty/LyricWiki/BopFm/js/bopfm_embed.js";
		?><script async src="<?= $scriptUrl; ?>"></script>
	</div>
</section>

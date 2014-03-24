<section class="module">
	<div class="bopfm-contents">
		<?php
		
		// Some display-specific constants.
		$id = "bopfm_1";
		$width = "100%"; // this gets passed to bop.fm so that they know how wide to render their widget
		
		?><a id="<?= $id ?>" data-width="<?= $width ?>" data-bop-link href="http://www.bop.fm/embed/<?= rawurlencode($artist) ?>/<?= rawurlencode($songName) ?>">
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

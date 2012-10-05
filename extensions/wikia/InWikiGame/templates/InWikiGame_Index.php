<div id="InWikiGameWrapper" class="InWikiGameWrapper"></div>

<?php

echo F::build('JSSnippets')->addToStack(
	array('/extensions/wikia/InWikiGame/js/InWikiGame.js'),
	null,
	'InWikiGame.init',
	null
);

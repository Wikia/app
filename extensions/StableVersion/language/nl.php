<?php
/**
 * Dutch language file for the 'StableVersion' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
			'stableversion_this_is_stable' => 'Dit is de stabiele versie van deze pagina. U kunt ook de <a href="$1">laatste werkversie</a> bekijken.',
			'stableversion_this_is_stable_nourl' => 'Dit is de stabiele versie van deze pagina.',
			'stableversion_this_is_draft_no_stable' => 'U ziet een werkversie van deze pagina; er is nog geen stabiele versie van deze pagina.',
			'stableversion_this_is_draft' => 'Dit is een werkversie van deze pagina. U kunt ook de <a href="$1">stabiele versie</a> bekijken.',
			'stableversion_this_is_old' => 'Dit is een oude versie van deze pagina. U kunt ook de <a href="$1">stabiele versie</a> of de <a href="$2">laatste werkversie</a> bekijken.',
			'stableversion_reset_stable_version' => 'Klik <a href="$1">hier</a> om deze stabiele versie te verwijderen!',
			'stableversion_set_stable_version' => 'Klik <a href="$1">hier</a> om dit als stabiele versie in te stellen!',
			'stableversion_set_ok' => 'Het instellen van de stabiele versie is geslaagd.',
			'stableversion_reset_ok' => 'Het verwijderen van de stabiele versie is geslaagd. Deze pagina heeft nu geen stabiele versie.',
			'stableversion_return' => 'Keer terug naar <a href="$1">$2</a>',
			
			'stableversion_reset_log' => 'Stabiele versie is verwijderd.',
			'stableversion_logpage' => 'Logboek stabiele versie',
			'stableversion_logpagetext' => 'Dit is een logboek met wijzigingen aan stabiele versies',
			'stableversion_log' => 'Versie #$1 is nu de stabiele versie.',
			'stableversion_before_no' => 'Er was nog geen stabiele versie.',
			'stableversion_before_yes' => 'De laatste stabiele versie was #$1.',
			'stableversion_this_is_stable_and_current' => 'Dit is zowel de stabiele als de meest recente versie.',
			'stableversion_noset_directional' => '(Kan niet (opnieuw) instellen in de directionele geschiedenis)',
	)
);



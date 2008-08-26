<?php
/**
 * German language file for the 'StableVersion' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
			'stableversion_this_is_stable' => 'Dies ist eine stabile Version dieser Seite. Du kannst auch die aktuelle <a href="$1">Entwurfsversion</a> betrachten.',
			'stableversion_this_is_draft_no_stable' => 'Du betrachtest eine Entwurfsversion dieser Seite; bisher gibt es keine stabile Version.',
			'stableversion_this_is_draft' => 'Dies ist eine Entwurfsversion dieser Seite. Du kannst auch die <a href="$1">stabile Version</a> betrachten.',
			'stableversion_reset_stable_version' => 'Klicke <a href="$1">hier</a>, um die Markierung als stabile Version zu entfernen!',
			'stableversion_set_stable_version' => 'Klicke <a href="$1">hier</a>, um diese Seite als stabile Version zu kennzeichnen!',
			'stableversion_set_ok' => 'Die stabile Version wurde erfolgreich gesetzt.',
			'stableversion_reset_ok' => 'Die stabile Version wurde erfolgreich entfernt. Diese Seite hat aktuell keine stabile Version mehr.',
			'stableversion_return' => 'Zurück zu <a href="$1">$2</a>',
			
			'stableversion_reset_log' => 'Stabile Version wurde entfernt.',
			'stableversion_logpage' => 'Stabile-Version-Logbuch',
			'stableversion_logpagetext' => 'Dies ist ein Logbuch für Änderungen an stabilen Versionen.',
			'stableversion_logentry' => '',
			'stableversion_log' => 'Änderung #$1 ist nun eine stabile Version.',
			'stableversion_before_no' => 'Es gab bisher keine stabile Version.',
			'stableversion_before_yes' => 'Die letzte stablie Version war #$1.',
			'stableversion_this_is_stable_and_current' => "Das ist die stabile sowie auch die aktuellste Version.",
	)
);

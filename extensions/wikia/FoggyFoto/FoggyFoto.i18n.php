<?php
/**
 * Internationalisation file for Special:FoggyFoto extension / game.
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'foggyfoto' => 'Foggy Foto game',
	'foggyfoto-desc' => 'Creates a page where the Foggy Foto game can be played in HTML5 + Canvas. It will be accessible via Nirvana\'s APIs',
	'foggyfoto-score' => 'Score: <span>$1</span>',
	'foggyfoto-progress' => 'Photos: <span>$1</span>',
	'foggyfoto-progress-numbers' => '$1/$2',
	'foggyfoto-continue-correct' => 'CORRECT!',
	'foggyfoto-continue-timeup' => 'TIME IS UP!',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'foggyfoto' => 'Special page name for "Foggy Foto" game.',
	'foggyfoto-desc' => '{{desc}}',
	'foggyfoto-progress' => 'Parameters:
* $1 is replaced with {{msg-wikia|foggyfoto-progress-numbers}}.',
	'foggyfoto-progress-numbers' => 'This is the format of the numbers that will be substituted into the "$1" portion of {{msg-wikia|foggyfoto-progress}}. Parameters:
* $1 is what number photo the player is on (starting with 1)
* $2 is the total number of photos in a round of the game.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'foggyfoto' => 'Матна слика',
	'foggyfoto-desc' => 'Создава страница кајшто се игра играта „Матна слика“ (Foggy Foto) во HTML5 + Canvas. Ќе биде достапна преку прилозите (API) на Nirvana',
	'foggyfoto-score' => 'Бодови: <span>$1</span>',
	'foggyfoto-progress' => 'Слики: <span>$1</span>',
	'foggyfoto-progress-numbers' => '$1/$2',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'foggyfoto' => 'Foggy Fotospel',
	'foggyfoto-desc' => "Maakt een pagina aan het Foggy Fotospel gespeeld kan worden in HTML5 met Canvas. Dit is beschikbaar via Nirvana's API's",
	'foggyfoto-score' => 'Score: <span>$1</span>',
	'foggyfoto-progress' => "Foto's: <span>$1</span>",
	'foggyfoto-progress-numbers' => '$1/$2',
);


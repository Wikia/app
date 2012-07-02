<?php
/**
 * Internationalization file for the Vote extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 */
$messages['en'] = array(
	'voteny-desc' => 'JavaScript-based voting with the <tt>&lt;vote&gt;</tt> tag',
	'vote-link' => 'Vote',
	'vote-unvote-link' => 'unvote',
	'vote-community-score' => 'community score: $1',
	'vote-ratings' => '{{PLURAL:$1|one rating|$1 ratings}}',
	'vote-remove' => 'remove',
	'vote-gave-this' => 'you gave this a $1',
	'vote-votes' => '{{PLURAL:$1|one vote|$1 votes}}',
	// Special:TopRatings
	'topratings' => 'Top rated pages',
	'topratings-no-pages' => 'No top rated pages.',
	// For Special:ListGroupRights
	'right-vote' => 'Vote pages',
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'vote-link' => 'Äänestä',
	'vote-unvote-link' => 'poista ääni',
	'vote-community-score' => 'yhteisön antama pistemäärä: $1',
	'vote-ratings' => '{{PLURAL:$1|yksi arvostelu|$1 arvostelua}}',
	'vote-remove' => 'poista',
	'vote-gave-this' => 'annoit tälle {{PLURAL:$1|yhden tähden|$1 tähteä}}',
	'vote-votes' => '{{PLURAL:$1|yksi ääni|$1 ääntä}}',
	'topratings' => 'Huippusivut',
	'topratings-no-pages' => 'Ei huippusivuja.',
	'right-vote' => 'Äänestää sivuja',
);

/** French (Français)
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fr'] = array(
	'vote-link' => 'Voter',
	'vote-unvote-link' => 'supprimer vote',
	'vote-remove' => 'supprimer',
	'vote-votes' => '{{PLURAL:$1|un vote|$1 votes}}',
	'right-vote' => 'Voter pages',
);

/** Dutch (Nederlands)
 * @author Mitchel Corstjens
 */
$messages['nl'] = array(
	'vote-link' => 'Stem',
	'vote-unvote-link' => 'stem terugtrekken',
	'vote-community-score' => 'gemeenschap score: $1',
	'vote-remove' => 'verwijder',
	'vote-gave-this' => 'je gaf dit een $1',
	'vote-votes' => '{{PLURAL:$1|een stem|$1 stemmen}}',
	'topratings' => 'Meest gewaardeerde pagina\'s',
	'topratings-no-pages' => 'Er zijn nog geen meest gewaardeerde pagina\'s',
	'right-vote' => 'Stem paginas',
);

/** Polish (Polski)
 * @author Misiek95
 */
$messages['pl'] = array(
	'vote-link' => 'Głosuj',
	'vote-unvote-link' => 'Anuluj',
	'vote-community-score' => 'Wynik wśród społeczności: $1',
	'vote-ratings' => '{{PLURAL:$1|1 głos|$1 głosy|$1 głosów}}',
	'vote-remove' => 'usuń',
	'vote-gave-this' => 'Oceniłeś to na $1',
	'vote-votes' => '{{PLURAL:$1|1 głos|$1 głosy|$1 głosów}}',
	'right-vote' => 'Udział w głosowaniach',
);
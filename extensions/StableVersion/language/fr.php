<?php
/**
 * French language file for the 'StableVersion' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
			'stableversion_this_is_stable' => 'Ceci est la version stable de l’article. Vous pouvez aussi consulter la <a href="$1">dernière version de travail</a>.',
			'stableversion_this_is_stable_nourl' => 'Ceci est la version stable de l’article.',
			'stableversion_this_is_draft_no_stable' => 'Vous consultez actuellement une version de travail de l’article ; il n’y a pas encore de version stable pour cet article.',
			'stableversion_this_is_draft' => 'Ceci est une version de travail de l’article. Vous pouvez également consulter la <a href="$1">version stable</a>.',
			'stableversion_this_is_old' => 'Ceci est une anciene version de l’article. Vous pouvez également consulter la <a href="$1">version stable</a>, ou la <a href="$2">dernière version de travail</a>.',
			'stableversion_reset_stable_version' => '<a href="$1">Cliquez ici</a> pour ne plus définir cett version comme stable !',
			'stableversion_set_stable_version' => '<a href="$1">Cliquez ici</a> pour définir cette version comme stable !',
			'stableversion_set_ok' => 'La version stable a été définie avec succès.',
			'stableversion_reset_ok' => 'La version stable a été enlevée avec succès. L’article n’a plus de version stable à présent.',
			'stableversion_return' => 'Revenir à <a href="$1">$2</a>',
			
			'stableversion_reset_log' => 'La version stable a été enlevée.',
			'stableversion_logpage' => 'Historique des versions stables',
			'stableversion_logpagetext' => 'Ceci est un historique des changements de versions stables',
			'stableversion_logentry' => '',
			'stableversion_log' => 'La version #$1 est maintenant la version stable.',
			'stableversion_before_no' => 'Il n’y avait aucune version stable auparavant.',
			'stableversion_before_yes' => 'La dernière version stable était #$1.',
			'stableversion_this_is_stable_and_current' => 'Cette version est à la fois la version stable et la dernière version.',
			'stableversion_noset_directional' => '(Cannot set or reset in directional history)',
	)
);



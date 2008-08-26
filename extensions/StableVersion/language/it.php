<?php
/**
 * Italian language file for the 'StableVersion' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
			'stableversion_this_is_stable' => 'Questa è la versione consolidata della voce. È possibile consultarne la <a href="$1">bozza più recente</a>.',
			'stableversion_this_is_stable_nourl' => 'Questa è la versione consolidata della voce.',
			'stableversion_this_is_draft_no_stable' => 'Questa è una bozza della voce. Al momento non è disponibile una versione consolidata.',
			'stableversion_this_is_draft' => 'Questa è una bozza della voce. È possibile consultarne la <a href="$1">versione consolidata</a>.',
			'stableversion_this_is_old' => 'Questa è una vecchia versione della voce. È possibile consultarne la <a href="$1">versione consolidata</a> e la <a href="$2">bozza più recente</a>.',
			'stableversion_reset_stable_version' => 'Fare clic <a href="$1">qui</a> per rimuovere l\'indicazione di versione consolidata.',
			'stableversion_set_stable_version' => 'Fare clic <a href="$1">qui</a> per impostare l\'indicazione di versione consolidata.',
			'stableversion_set_ok' => 'L\'indicazione di versione consolidata è stata impostata.',
			'stableversion_reset_ok' => 'L\'indicazione di versione consolidata è stata rimossa. La voce è al momento priva di versione consolidata.',
			'stableversion_return' => 'Ritorna a <a href="$1">$2</a>',
			
			'stableversion_reset_log' => 'L\'indicazione di versione consolidata è stata eliminata.',
			'stableversion_logpage' => 'Registro delle versioni consolidate',
			'stableversion_logpagetext' => 'Di seguito viene presentato il registro delle modifiche alle versioni consolidate',
			'stableversion_logentry' => '',
			'stableversion_log' => 'L\'indicazione di versione consolidata è stata impostata alla revisione #$1.',
			'stableversion_before_no' => 'Nessuna versione era indicata come consolidata in precedenza.',
			'stableversion_before_yes' => 'La precedente versione indicata come consolidata era #$1.',
			'stableversion_this_is_stable_and_current' => 'Questa è la versione consolidata e anche la più recente.',
			'stableversion_noset_directional' => '(Impossibile modificare l\'impostazione nella cronologia direzionale)',
	)
);



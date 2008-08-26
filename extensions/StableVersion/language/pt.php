<?php
/**
 * Portuguese language file for the 'StableVersion' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
			'stableversion_this_is_stable' => 'Esta é a versão estável para este artigo. Você também pode ver a <a href="$1">mais recente versão de rascunho</a>.',
			'stableversion_this_is_stable_nourl' => 'Esta é a versão estável para este artigo.',
			'stableversion_this_is_draft_no_stable' => 'Você está acessando a versão de rascunho deste artigo; não há até o momento uma versão estável para este artigo.',
			'stableversion_this_is_draft' => 'Você está acessando a versão de rascunho deste artigo. Você também pode ver a <a href="$1">versão estável</a>.',
			'stableversion_this_is_old' => 'Esta é uma versão anterior para este artigo. Você também pode ver tanto a <a href="$1">versão estável</a>, quanto <a href="$2">o rascunho mais recente</a>.',
			'stableversion_reset_stable_version' => 'Clique <a href="$1">aqui</a> para que esta deixe de ser a versão estável.',
			'stableversion_set_stable_version' => 'Clique <a href="$1">aqui</a> para que esta seja identificada como a versão estável',
			'stableversion_set_ok' => 'A versão estável foi definida com êxito.',
			'stableversion_reset_ok' => 'A versão estável foi removida com êxito. Com isto, este artigo deixou de ter uma versão estável.',
			'stableversion_return' => 'Voltar para <a href="$1">$2</a>',
			
			'stableversion_reset_log' => 'A versão estável foi removida com êxito.',
			'stableversion_logpage' => 'Registo de versões estáveis',
			'stableversion_logpagetext' => 'Este é um registo de modificações em versões estáveis',
			'stableversion_logentry' => '',
			'stableversion_log' => 'A revisão #$1 é a partir de agora a versão estável.',
			'stableversion_before_no' => 'Não há uma revisão estável precedente.',
			'stableversion_before_yes' => 'A última revisão estável é #$1.',
			'stableversion_this_is_stable_and_current' => 'Esta é simultâneamente a versão mais recente e a versão estável.',
/*			'stableversion_noset_directional' => '(Cannot set or reset in directional history)', */
	)
);



<?php
/**
 * Russian language file for the 'StableVersion' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
			'stableversion_this_is_stable' => 'Это стабильная версия статьи. Вы также можете просмотреть <a href="$1">последнюю черновую версию</a>.',
			'stableversion_this_is_stable_nourl' => 'Это стабильная версия статьи.',
			'stableversion_this_is_draft_no_stable' => 'Вы просматриваете черновую версию статьи, стабильной версии статьи пока не существует.',
			'stableversion_this_is_draft' => 'Это черновая версия статьи. Вы также можете просмотреть <a href="$1">стабильную версию</a>.',
			'stableversion_this_is_old' => 'Это старая версия статьи. Вы можете просмотреть <a href="$1">стабильную версию</a> этой статьи, или <a href="$2">последнюю черновую</a>.',
			'stableversion_reset_stable_version' => 'Нажмите <a href="$1">здесь</a>, чтобы убрать отметку стабильной версии!',
			'stableversion_set_stable_version' => 'Нажмите <a href="$1">здесь</a>, чтобы отметить эту версию как стабильную!',
			'stableversion_set_ok' => 'Стабильная версия была успешно установлена.',
			'stableversion_reset_ok' => 'Отметка стабильной версии была успешно удалена. Эта статья сейчас не имеет стабильной версии.',
			'stableversion_return' => 'Вернуть к <a href="$1">$2</a>',
			
			'stableversion_reset_log' => 'Убрана стабильная версия.',
			'stableversion_logpage' => 'Журнал стабильных версий',
			'stableversion_logpagetext' => 'Это журнал изменений отметок стабильных версий',
			'stableversion_logentry' => '',
			'stableversion_log' => 'Версия №$1 сейчас считается стабильной.',
			'stableversion_before_no' => 'Ренее не было стабильной версии.',
			'stableversion_before_yes' => 'Последней стабильной версией была №$1.',
			'stableversion_this_is_stable_and_current' => 'Эта версия является одновременно и последней, и стабильной.',
			'stableversion_noset_directional' => '(Невозможно установить или сбросить в направленной истории)',
	)
);



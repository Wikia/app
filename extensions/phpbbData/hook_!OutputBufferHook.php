<?php
/** \file
* \brief Contains code for the MediaWiki phpbbData Extension - Creates BeforePageDisplay hook in phpBB3.
*/

class OutputBufferHook {
	function hookTemplateDisplay(&$hook, $handle, $include_once = true) {
		$result = $hook->previous_hook_result(array('template', 'display'));

		ob_start();
		return $result['result'];
	}

	function hookExitHandler(&$hook) {
		$outputCache = ob_get_contents();
		ob_end_clean();
		
		$result = $hook->previous_hook_result('exit_handler');

		global $phpbb_hook;
		if ( !empty($hook) && $hook->call_hook('BeforePageDisplay', $outputCache) ) {
			if ($hook->hook_return('BeforePageDisplay')) {
				$hookReturn = $hook->hook_return_result('BeforePageDisplay');
				if ($hookReturn) {
					//return $hookReturn;
					$outputCache =  $hookReturn;
				}
			}
		}

		eval(' ?>' . $outputCache . '<?php ');
		
		return $result['result'];
	}
}

$phpbb_hook->register(array('template', 'display'), array('OutputBufferHook', 'hookTemplateDisplay'));
$phpbb_hook->register('exit_handler', array('OutputBufferHook', 'hookExitHandler'));
$phpbb_hook->add_hook('BeforePageDisplay');

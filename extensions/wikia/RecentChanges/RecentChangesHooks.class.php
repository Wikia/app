<?php

class RecentChangesHooks {
	public static function onGetNamespaceCheckbox(&$html, $selected = '', $all = null, $element_name = 'namespace', $label = null) {
		$app = F::app();

		if (!($app->wg->Title->isSpecialPage() && $app->wg->Title->getText() =='RecentChanges')) {
			return true;
		}

		$namespaces = $app->wg->ContLang->getFormattedNamespaces();

		$app->wf->RunHooks('XmlNamespaceSelectorAfterGetFormattedNamespaces', array(&$namespaces, $selected, $all, $element_name, $label));

		$options = array();

		if (preg_match('/^\d+$/', $selected)) {
			$selected = intval($selected);
		}

		if (!is_null($all)) {
			$namespaces = array($all => wfMsg('namespacesall')) + $namespaces;
		}

		foreach ($namespaces as $index => $name) {
			if ($index < NS_MAIN) {
				continue;
			}

			if ($index === 0) {
				$options[$index] = $app->wf->Msg('blanknamespace');

			} else {
				$options[$index] = $name;
			}
		}

		$selected = array($selected);
		$html = $app->renderView('RecentChangesController', 'dropdown', array('options' => $options, 'selected' => $selected));

		if (!is_null($label)) {
			$html = Xml::label($label, $element_name) . ' ' . $ret;
		}

		return true;
	}
}
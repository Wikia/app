<?php

	class TemplateService {

		const HOT_TEMPLATES_TTL = 3600;
		const PROMOTED_TEMPLATES_MESSAGE = 'editor-template-list';

		/**
		 * Grabbing list of most included templates
		 *
		 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
		 */
		static public function getHotTemplates() {
			global $wgMemc;

			wfProfileIn(__METHOD__);

			$key = wfMemcKey(__CLASS__, 'hot-templates');
			$list = $wgMemc->get($key);

			if (empty($list) || !is_array($list)) {
				$dbr = wfGetDB(DB_SLAVE);
				$conds = array(
					'qc_type' => 'Mostlinkedtemplates',
					'qc_namespace' => NS_TEMPLATE,
				);

				// handle list of excluded templates
				global $wgTemplateExcludeList;
				if (is_array($wgTemplateExcludeList) && count($wgTemplateExcludeList)) {
					$templateExcludeListA = array();
					foreach($wgTemplateExcludeList as $tmpl) {
						$templateExcludeListA[] = $dbr->AddQuotes($tmpl);
					}
					$conds[] = 'qc_title NOT IN (' . implode(',', $templateExcludeListA) . ')';
				}

				$res = $dbr->select('querycache', 'qc_title', $conds, __METHOD__, array('ORDER BY' => 'qc_value DESC', 'LIMIT' => 10));
				$list = array();

				while ($row = $dbr->fetchObject($res)) {
					$title = Title::newFromText($row->qc_title, NS_TEMPLATE);
					if (empty($title) || !$title->exists()) {
						continue;
					}
					$list[] = $row->qc_title;
				}

				$wgMemc->set($key, $list, self::HOT_TEMPLATES_TTL);
			}

			wfProfileOut(__METHOD__);

			return $list;
		}

		/*
		 * Return list of templates to be placed in dropdown menu on CK toolbar
		 */
		static public function getPromotedTemplates($limit = 4) {
			wfProfileIn(__METHOD__);

			// TODO: add caching for this data
			$list = array();
			$lines = explode("\n", wfMsgForContent(self::PROMOTED_TEMPLATES_MESSAGE)); // we do not care if the message is empty

			foreach ($lines as $line) {
				if(strrpos($line, '*') === 0) {
					$title = Title::newFromText(trim($line, '* '));
					if ( is_object( $title ) ) {
						$list[] = $title->getText();

						if (count($list) >= $limit) {
							break;
						}
					}
				}
			}

			wfProfileOut(__METHOD__);

			return $list;
		}

	}

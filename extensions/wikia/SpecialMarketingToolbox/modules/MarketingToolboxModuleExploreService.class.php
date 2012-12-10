<?php
class MarketingToolboxModuleExploreService extends MarketingToolboxModuleService {
	const SECTION_NUMBERS = 4;
	const LINKS_PER_SECTION = 4;

	const SECTION_FIELD_PREFIX = 'exploreSectionHeader';

	protected $lettersMap = array('a', 'b', 'c', 'd');

	protected function getFormFields() {
		$formFields = array(
			'exploreTitle' => array(
				'label' => $this->wf->Msg('marketing-toolbox-hub-module-explore-title'),
				'isRequired' => true,
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),
		);

		for($sectionIdx = 1; $sectionIdx <= self::SECTION_NUMBERS; $sectionIdx++) {
			$formFields = $formFields + $this->generateSectionHeaderField($sectionIdx);

			for($linkIdx = 0; $linkIdx < self::LINKS_PER_SECTION; $linkIdx++) {
				$formFields = $formFields + $this->generateSectionLinkFields($sectionIdx, $linkIdx);
			}
		}

		return $formFields;
	}

	protected function generateSectionHeaderField($sectionIdx) {
		$fieldName = self::SECTION_FIELD_PREFIX . $sectionIdx;
		return array(
			$fieldName => array(
				'label' => $this->wf->MsgExt('marketing-toolbox-hub-module-explore-section-header', array($sectionIdx)),
				'validator' => new WikiaValidatorString(
					array(
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),
		);
	}

	protected function generateSectionLinkFields($sectionIdx, $linkIdx) {
	//todo: header a. depends on URL a and the other way around
		$fieldName = self::SECTION_FIELD_PREFIX . $sectionIdx . $this->lettersMap[$linkIdx];
		return array(
			$fieldName => array(
				'label' => $this->wf->MsgExt('marketing-toolbox-hub-module-explore-section-header', array($this->lettersMap[$linkIdx])),
				'validator' => new WikiaValidatorString(
					array(
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),
		);
	}
}
?>
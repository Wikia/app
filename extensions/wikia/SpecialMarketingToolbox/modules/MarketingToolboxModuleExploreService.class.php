<?php
class MarketingToolboxModuleExploreService extends MarketingToolboxModuleService {
	const SECTION_NUMBERS = 4;
	const LINKS_PER_SECTION = 4;

	const SECTION_FIELD_PREFIX = 'exploreSectionHeader';
	const LINK_HEADER = 'exploreLinkHeader';
	const LINK_URL = 'exploreLinkUrl';

	protected $lettersMap = array('a', 'b', 'c', 'd');

	protected function getFormFields() {
		$formFields = array(
			'exploreTitle' => array(
				'label' => $this->wf->Msg('marketing-toolbox-hub-module-explore-title'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
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
				'label' => $this->wf->MsgExt('marketing-toolbox-hub-module-explore-header', array('parseinline'), $sectionIdx),
				'validator' => new WikiaValidatorString(),
			),
		);
	}

	protected function generateSectionLinkFields($sectionIdx, $linkIdx) {
	//todo: header a. depends on URL a and the other way around
		$linkHeaderFieldName = self::LINK_HEADER . $sectionIdx . $this->lettersMap[$linkIdx];
		$linkUrlFieldName = self::LINK_URL . $sectionIdx . $this->lettersMap[$linkIdx];
		return array(
			$linkHeaderFieldName => array(
				'label' => $this->wf->MsgExt('marketing-toolbox-hub-module-explore-header', array('parseinline'), $this->lettersMap[$linkIdx]),
				'validator' => new WikiaValidatorString(
					array(
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => "{required: '#MarketingToolbox{$linkUrlFieldName}:filled'}"
				)
			),
			$linkUrlFieldName => array(
				'label' => $this->wf->Msg('marketing-toolbox-hub-module-explore-link-url'),
				'validator' => new WikiaValidatorUrl(),
				'attributes' => array(
					'class' => "wikiaUrl"
				)
			),
		);
	}
}
?>
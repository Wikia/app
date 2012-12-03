<?
class MarketingToolboxModulePulseService extends MarketingToolboxModuleService {
	protected function getValidationRules() {
		return array(
			'boardTitle' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'boardDescription' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'stat1' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'stat2' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'stat3' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'number1' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'number2' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'number3' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
		);
	}
	public function renderEditor($data) {
		return parent::renderEditor($data);
	}
}
?>
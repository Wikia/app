<?
class CollectionsForm extends FormBuilderService {
	protected $prefix = 'collections';

	public function __construct($prefix = '', $fields = []) {
		parent::__construct($prefix, $fields);

		if (empty($fields)) {
			$fields = [
				'id' => [
					'type' => 'hidden',
					'isArray' => true
				],
				'name' => [
					'label' => wfMsg('manage-wikia-home-collections-name-field-label'),
					'validator' => new WikiaValidatorListValue([
						'validator' => new WikiaValidatorString(
							array(
								'required' => true,
								'min' => 1
							),
							array('too_short' => 'marketing-toolbox-validator-string-short')
						)
					]),
					'isArray' => true
				],
				'enabled' => [
					'label' => wfMsg('manage-wikia-home-collections-enabled-field-label'),
					'type' => 'checkbox',
					'validator' => new WikiaValidatorListValue([
						'validator' => new WikiaValidatorInteger()
					]),
					'isArray' => true
				],
				'sponsor_url' => [
					'label' => wfMsg('manage-wikia-home-collections-sponsor-url-field-label'),
					'validator' => new WikiaValidatorListValue([
						'validator' => new WikiaValidatorUrl()
					]),
					'isArray' => true
				],
				'sponsor_hero_image' => [
					'label' => wfMsg('manage-wikia-home-collections-sponsor-hero-image-field-label'),
					'validator' => new WikiaValidatorListValue([
						'validator' => new WikiaValidatorFileTitle(
							array(
								'required' => false
							)
						)
					]),
					'isArray' => true
				],
				'sponsor_image' => [
					'label' => wfMsg('manage-wikia-home-collections-sponsor-image-field-label'),
					'validator' => new WikiaValidatorListValue([
						'validator' => new WikiaValidatorFileTitle(
							array(
								'required' => false
							)
						)
					]),
					'isArray' => true
				],
			];
			$this->setFields($fields);
		}
	}

	public function filterData($data) {
		if (!empty($data['sponsor_url'])) {
			foreach ($data['sponsor_url'] as &$url) {
				if( !empty($url) && strpos($url, 'http://') === false && strpos($url, 'https://') === false ) {
					$url = 'http://' . $url;
				}
			}
		}
		return parent::filterData($data);
	}
}
<?php
namespace Wikia\PageHeader;

class Subtitle {
	/**
	 * @var string
	 */
	public $text;

	public function __construct( \WikiaApp $app ) {
		$this->subtitle = \RequestContext::getMain()->getOutput()->getSubtitle();
		$this->text = $app->getSkinTemplateObj()->data['subtitle'];
	}

}
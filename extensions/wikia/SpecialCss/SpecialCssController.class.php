<?php
class SpecialCssController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct('CSS', 'specialcss', true);
	}
	
	public function index() {
		wfProfileIn(__METHOD__);

		if( $this->checkPermissions() ) {
			$this->displayRestrictionError();
			return false; // skip rendering
		}

		$this->response->addAsset('/extensions/wikia/SpecialCss/css/SpecialCss.scss');
		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->text() );
		
		$model = new SpecialCssModel();
		$this->cssContent = $model->getCssFileContent();

		$this->cssBlogs = $this->getCssBlogMockedData(); // $model->getCssBlogData();

		wfProfileOut(__METHOD__);
	}
	
	public function notOasis() {
		$this->wg->Out->setPageTitle( $this->wf->Message('special-css-title')->text() );
	}
	
	private function getCssBlogMockedData() {
		return [
			[
				'userName' => 'DaNASCAT',
				'userAvatar' => AvatarService::renderAvatar('DaNASCAT', 26), //todo: talk about that -- it's not a default avatar size
				'title' => 'Technical Update: June 11, 2013',
				'timestamp' => 'June 11, 2013',
				'text' => 'Shortly after the release, a script will run to convert existing YouTube tags to File pages. This conversion is already happening (as of last week) for newly added YouTube tags.',
				'url' => 'http://community.wikia.com/wiki/User_blog:DaNASCAT/Technical_Update:_June_11,_2013',
			],
			[
				'userName' => 'Kirkburn',
				'userAvatar' => AvatarService::renderAvatar('Kirkburn'),
				'title' => 'Technical Update: June 4, 2013',
				'timestamp' => 'June 4, 2013',
				'text' => 'It is no longer possible to create Message Wall and Forum posts with titles that consist of only spaces (which made them difficult to access).',
				'url' => 'http://community.wikia.com/wiki/User_blog:DaNASCAT/Technical_Update:_June_4,_2013',
			],
			[
				'userName' => 'Rappy 4187',
				'userAvatar' => AvatarService::renderAvatar('Rappy 4187'),
				'title' => 'Technical Update: May 28, 2013',
				'timestamp' => 'May 28, 2013',
				'text' => 'Due to observations of the American holiday Memorial Day on May 27 and the Polish holiday Corpus Christi on May 30, there will be no release this week. The regular release schedule will resume next week.',
				'url' => 'http://community.wikia.com/wiki/User_blog:DaNASCAT/Technical_Update:_May_28,_2013',
			],
		];
	}
}

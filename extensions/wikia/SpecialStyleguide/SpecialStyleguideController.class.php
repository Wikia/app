<?php

class SpecialStyleguideController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'Styleguide' );
	}

	public function index() {
		wfProfileIn( __METHOD__ );

		RenderContentOnlyHelper::setRenderContentVar( true );
		RenderContentOnlyHelper::setRenderContentLevel( RenderContentOnlyHelper::LEAVE_NAV_ONLY );
		$this->response->addAsset( 'extensions/wikia/SpecialStyleguide/css/SpecialStyleguide.scss' );
		$this->wg->Out->setPageTitle( wfMessage( 'styleguide-pagetitle' )->plain() );

		$this->app->setGlobal( 'wgAutoloadClasses', dirname( __FILE__ ) . '/SpecialStyleguideGlobalHeaderControllerOverride.php', 'GlobalHeaderController' );

		$this->wg->Out->clearHTML();
		$this->wg->Out->addHtml(
			(new Wikia\Template\MustacheEngine)
				->setPrefix( dirname(__FILE__) . '/templates' )
				->setData( [
					'header' =>  $this->getSectionContent('header'),
					'body' => $this->getSectionContent('home'),
					'footer' => $this->getSectionContent('footer'),
				])
				->render('SpecialStyleguide_index.mustache')
		);

		wfProfileOut( __METHOD__ );

		// skip rendering
		$this->skipRendering();
	}

	public function getSectionContent($sectionName) {
		return (new Wikia\Template\MustacheEngine)
			->setPrefix( dirname(__FILE__) . '/templates' )
			->setData($this->getSectionData($sectionName))
			->render('SpecialStyleguide_' . $sectionName . '.mustache');
	}

	private function getSectionData($sectionName) {
		$homePageData = [
			'sections' => [
				[
					'header' => 'Lorem ipsum',
					'paragraph' => 'Maecenas sed diam eget risus varius blandit.'
				],
				[
					'header' => 'Lorem ipsum',
					'paragraph' => 'Maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit
					sit amet non magna. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas sed diam eget risus varius blandit sit amet non magna. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.',
				],
				[
					'header' => 'Lorem ipsum',
					'paragraph' => 'Maecenas faucibus mollis interdum. Maecenas sed diam eget risus varius blandit
					sit amet non magna. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
					'list' => [
						[
							'link' => '',
							'linkTitle' => 'Lorem Ipsum',
							'linkName' => 'Lorem Ipsum',
							'linkTagline' => 'Lorem ipsum dolor'
						],
						[
							'link' => '',
							'linkTitle' => 'Lorem Ipsum',
							'linkName' => 'Lorem Ipsum',
							'linkTagline' => 'Lorem ipsum dolor'
						],
						[
							'link' => '',
							'linkTitle' => 'Lorem Ipsum',
							'linkName' => 'Lorem Ipsum',
							'linkTagline' => 'Lorem ipsum dolor'
						]
					]
				]
			]
		];
		$headerData = [
			'home' => [
				'mainHeader' => 'Lorem Ipsum Dolor',
				'getStartedBtnLink' => '',
				'getStartedBtnTitle' => 'Lorem Ipsum',
				'getStartedBtnLabel' => 'Get started',
				'version' => 'Version 1.0.0'
			],
			'tagLine' => 'Maecenas faucibus mollis interdum',
		];
		$footerData = [
			'list' => [
				[
					'link' => '#',
					'linkTitle' => 'Blog',
					'linkLabel' => 'Blog'
				],
				[
					'link' => '#',
					'linkTitle' => 'Changelog',
					'linkLabel' => 'Changelog'
				]
			]
		];

		switch ($sectionName) {
			case 'home':
				return $homePageData;
				break;
			case 'header':
				return $headerData;
				break;
			case 'footer':
				return $footerData;
				break;
		}
	}
}

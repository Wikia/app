<?php

class EditorPreferencesTest extends WikiaBaseTest {

	const NAMESPACES = [ NS_MAIN, NS_USER ];

	private function getSkinMock( int $ns, string $title) : Skin {
		$skin = Skin::newFromKey('oasis');

		$isCssJsSubpage = Title::newFromText( $title, $ns )->isCssJsSubpage();

		/* @var $title Title */
		$title = $this->mockClassWithMethods(Title::class, [
			'getNamespace' => $ns,
			'inNamespaces' => in_array( $ns, self::NAMESPACES ),
			'getText' => $title,
			'isRedirect' => false,
			'isCssJsSubpage' => $isCssJsSubpage,
		]);

		/* @var $user User */
		$user = $this->mockClassWithMethods( User::class, [
			'isBlockedFrom' => false,
		]);

		$context = new RequestContext();
		$context->setTitle( $title );
		$context->setUser( $user );

		$skin->setContext($context);
		return $skin;
	}

	/**
	 * @param int $namespace
	 * @param string $text
	 * @param bool $expected
	 * @param string $message
	 * @dataProvider shouldShowVisualEditorLinkDataProvider
	 */
	public function testShouldShowVisualEditorLink( int $namespace, string $text, bool $expected, string $message ) {
		$this->mockGlobalVariable( 'wgEnableVisualEditorExt', true );
		$this->mockGlobalVariable( 'wgVisualEditorNamespaces', self::NAMESPACES );
		$this->mockGlobalVariable( 'wgVisualEditorSupportedSkins', [ 'oasis' ] );

		// mock the Oasis skin with a specified title
		$skin =  self::getSkinMock( $namespace,  $text );

		$this->assertEquals( $expected, EditorPreference::shouldShowVisualEditorLink( $skin ), $message );
	}

	public function shouldShowVisualEditorLinkDataProvider() {
		yield [ NS_MAIN, 'Foo', true, 'NS_MAIN is supported by VisualEditor' ] ;
		yield [ NS_USER, 'Foo', true, 'NS_USER is supported by VisualEditor' ] ;
		yield [ NS_USER, 'Rappy_4187/global.css ', false, 'User CSS is not editable by VisualEditor' ] ;
		yield [ NS_USER, 'Rappy_4187/global.js ', false, 'User JS is not editable by VisualEditor' ] ;

		yield [ NS_TEMPLATE, 'Foo', false, 'NS_TEMPLATE is not supported by VisualEditor'  ] ;
	}

}

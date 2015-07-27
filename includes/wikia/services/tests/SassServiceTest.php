<?php

class SassServiceTest extends WikiaBaseTest {

	private static $sassVariables = [
		'color-body' => '#112233',
	];

	public function testCompileInlineCss() {
		$css = <<<CSS
@import "skins/shared/color";
header {
	div {
		color: \$color-body;
	}
}
CSS;
		$sass = SassService::newFromString($css);
		$sass->setSassVariables(self::$sassVariables);

		$result = $sass->getCss(false); # no cache

		$this->assertContains( 'header div {', $result, 'CSS selector is properly compiled' );
		$this->assertContains( 'color: #112233;', $result, 'Color variable is properly passed' );
	}

	public function testCompileSassFile() {
		$sass = SassService::newFromFile( __DIR__ . '/styles/style.scss' );
		$sass->setSassVariables(self::$sassVariables);

		$result = $sass->getCss(false); # no cache

		$this->assertContains( '@import url(/skins/wikia/shared.css);', $result, 'CSS @import statements are kept' );
		$this->assertContains( 'font-size: 13px;', $result, '@bodytext mixin is expanded' );
		$this->assertContains( 'color: #112233;', $result, 'Color variable is properly passed' );
	}
}
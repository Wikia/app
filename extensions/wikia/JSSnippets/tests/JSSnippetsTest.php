<?php

class JSSnippetsTest extends WikiaBaseTest {

	public function testAddToStack() {
		$instance = new JSSnippets();

		$snippet = $instance->addToStack(
			array(
				'/extensions/wikia/Feature/js/Feature.js',
				'/extensions/wikia/Feature/css/Feature.css',
			)
		);

		$this->assertEquals(
			'<script>JSSnippetsStack.push({dependencies:["/extensions/wikia/Feature/js/Feature.js","/extensions/wikia/Feature/css/Feature.css"]})</script>',
			$snippet);

		$snippet = $instance->addToStack(
			array( '/extensions/wikia/Feature/js/Feature.js' ),
			array('$.loadJQueryUI'),
			'Feature.init',
			array(
				'foo' => 'bar',
			)
		);

		$this->assertEquals(
			'<script>JSSnippetsStack.push({dependencies:["/extensions/wikia/Feature/js/Feature.js"],getLoaders:function(){return [$.loadJQueryUI]},callback:function(json){Feature.init(json)},id:"Feature.init",options:{"foo":"bar"}})</script>',
			$snippet);
	}
}
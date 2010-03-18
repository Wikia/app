<?php
$wgExtensionFunctions[] = 'CollectionPage_Setup';

function CollectionPage_Setup() {
	global $wgHooks;
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'CollectionPage_Display';
}

function CollectionPage_Display(&$template, &$templateEngine) {
	$templateEngine->data['bodytext'] = <<<EOT
<style>
.collection cite {
	margin-left: 15px;
}
.collection p {
	margin-right: 180px;
	font-size: 1.2em;
}
.collection li {
	position: relative;
	margin: 10px 0;
}
.collection span {
	font-size: 0.8em;
	color: #666;
	position: absolute;
	top: 0px;
	right: 25px;
}
.collection big {
	font-weight: bold;
}
</style>

<h1>Facts</h1>
<ul class="collection collection-facts">
	<li>
		<p>Jason Mraz is cool! ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla </p>
		<cite>added by Inez Feb. 22, 2010</cite>
		<span>edit delete up/down <big class="dark_text_1">100%</big></span>
	</li>
	<li>
		<p>Jason Mraz is cool! ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla </p>
		<cite>added by Inez Feb. 22, 2010</cite>
		<span>up/down <big class="dark_text_1">92%</big></span>
	</li>
</ul>

<h1>Pictures</h1>
<ul class="collection collection-facts">
	<li>
		<p>Jason Mraz is cool! ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla </p>
		<cite>added by Inez Feb. 22, 2010</cite>
		<span>edit delete up/down <big class="dark_text_1">100%</big></span>
	</li>
	<li>
		<p>Jason Mraz is cool! ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla ... ... ... lorem ipsum bla bla </p>
		<cite>added by Inez Feb. 22, 2010</cite>
		<span>up/down <big class="dark_text_1">92%</big></span>
	</li>
</ul>

EOT;
	return true;
}
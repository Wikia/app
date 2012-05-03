<style>
.WikiaArticle h2 {
	font-weight: bold;
	margin-top: 50px;
}
.WikiaArticle h3 {
	margin-top: 15px;
}
.uisg-sample-pane {
	border: 1px solid #ccc;
	height: 100px;
	margin-bottom: 20px;
	width: 300px;
}
</style>

<!-- Ajax loading wheel -->
<h2>Ajax loading wheel</h2>
<h3>Sample:</h3>
<!-- The element has to be positioned for ajax loading wheel to be applied correctly.  This will be addressed.  -->
<div id="UISGLoadingWheel" class="uisg-sample-pane" style="position:relative">
	Click me to toggle ajax loading wheel.
</div>

<!-- Ajax Loading Wheel Sample Code -->
<script>
$(function() {
	$('#UISGLoadingWheel').toggle(function() {
		console.log(this);
		$(this).startThrobbing();
	}, function() {
		$(this).stopThrobbing();
	});
});
</script>

<h3>Sample Code:</h3>
<pre>
html:
/* The element has to be positioned for ajax loading wheel to be applied correctly.  This will be addressed.  */
&lt;div id=&quot;UISGLoadingWheel&quot; class=&quot;uisg-sample-pane&quot; style=&quot;position:relative&quot;&gt;<br/>	Click me to toggle ajax loading wheel.<br/>&lt;/div&gt;

javascript:
$('#LoadingWheelDiv').toggle(function() {
	$(this).startThrobbing();	/* start throbbing */
}, function() {
	$(this).stopThrobbing();	/* stop throbbing */
});
</pre>


<!-- Buttons -->
<h2>Buttons</h2>
<h3>Primary Button:</h3>
<button>Your label here</button>
<h3>Secondary Button</h3>
<button class="secondary">Secondary Button</button>

<h3>Sample Codes:</h3>
Any of these will produce the buttons, please use them as appropriate:
<pre>
&lt;button&gt;Your label here&lt;/button&gt;<br/>&lt;input type=&quot;button&quot; value=&quot;Your label here&quot;&gt;<br/>&lt;input type=&quot;submit&quot; value=&quot;Your label here&quot;&gt;<br/>&lt;input type=&quot;reset&quot; value=&quot;Your label here&quot;&gt;<br/>&lt;a class=&quot;wikia-button&quot;&gt;Your label here&lt;/a&gt;<br/>&lt;div class=&quot;button&quot;&gt;Your label here&lt;/div&gt;<br/>&lt;button class=&quot;secondary&quot;&gt;Secondary Button&lt;/button&gt;	/* add class "secondary" */
</pre>

<h2>Menu Button</h2>
<h3>Sample:</h3>
<?php
$dropdown = array(array(
	"id" => "UISGMenuButtonFirst",
	"text" => "First Item"
), array(
	"id" => "UISGMenuButtonSecond",
	"text" => "Second Item"
));
?>
<?= wfRenderModule('MenuButton', 
	'Index', 
	array(
		'action' => array("href" => "#", "text" => "Visible Part", "id" => "UISGMenuButton"), 
		'name' => 'foobar',
		'dropdown' => $dropdown
	)
) ?>
<h3>Sample Code:</h3>
<pre>
$dropdown = array(array(
	"id" => "UISGMenuButtonFirst",
	"text" => "First Item"
), array(
	"id" => "UISGMenuButtonSecond",
	"text" => "Second Item"
));
echo wfRenderModule('MenuButton', 
	'Index', 
	array(
		'action' => array("href" => "#", "text" => "Visible Part", "id" => "UISGMenuButton"), 
		'name' => 'foobar',
		'dropdown' => $dropdown
	)
)
</pre>
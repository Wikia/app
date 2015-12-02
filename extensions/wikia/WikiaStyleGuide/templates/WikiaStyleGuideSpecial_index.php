<script>
var UISGNamespace = {};	/* generic UISG namespace for demos */
</script>
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
<h3>Big Button</h3>
<button class="big">Big Button</button>
<h3>Button with Chevron</h3>
<button>
Chevron to the right
<img src="<?= wfBlankImgUrl() ?>" class="chevron">
</button>

<h3>Sample Codes:</h3>
Any of these will produce the buttons, please use them as appropriate:
<pre>
&lt;button&gt;Your label here&lt;/button&gt;<br/>&lt;input type=&quot;button&quot; value=&quot;Your label here&quot;&gt;<br/>&lt;input type=&quot;submit&quot; value=&quot;Your label here&quot;&gt;<br/>&lt;input type=&quot;reset&quot; value=&quot;Your label here&quot;&gt;<br/>&lt;a class=&quot;wikia-button&quot;&gt;Your label here&lt;/a&gt;<br/>&lt;div class=&quot;button&quot;&gt;Your label here&lt;/div&gt;<br/>&lt;button class=&quot;secondary&quot;&gt;Secondary Button&lt;/button&gt;	/* add class "secondary" */<br/>&lt;button class=&quot;big&quot;&gt;Big Button&lt;/button&gt;	/* add class "big" */<br/>&lt;button&gt;<br/>Chevron to the right<br/>&lt;img src=&quot;&lt;?= F::app()-&gt;wf-&gt;BlankImgUrl() ?&gt;&quot; class=&quot;chevron&quot;&gt;<br/>&lt;/button&gt;	/* chevron image added */
</pre>

<h2>Menu Button</h2>
<h3>Sample:</h3>
<?php
$dropdown = array(
	array(
		"id" => "UISGMenuButtonFirst",
		"text" => "First Item"
	),
	array(
		"id" => "UISGMenuButtonSecond",
		"text" => "Second Item"
	)
);
?>
<?= F::app()->renderView('MenuButton',
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
echo F::app()->renderView('MenuButton',
	'Index',
	array(
		'action' => array("href" => "#", "text" => "Visible Part", "id" => "UISGMenuButton"),
		'name' => 'foobar',
		'dropdown' => $dropdown
	)
)
</pre>

<!-- Dropdowns -->
<h2>Dropdowns</h2>
<h3>Normal Dropdown</h3>
<?
// TODO
?>
<script>

</script>
<h3>Normal Dropdown Sample Code</h3>
<pre>
TODO
</pre>

<!-- Modals -->
<h2>Modal Dialog</h2>
<h3>Normal Modal Sample</h3>
<button id="UISGNormalModalButton">Click to make a normal modal dialog</button>
<script>
$(function() {
	$("#UISGNormalModalButton").click(function() {
		$("<div><h1>This is a Normal Dialog</h1>Body content goes here.</div>").makeModal({width: 400});
	});
});
</script>
<h3>Normal Modal Sample Code</h3>
<pre>
$("#UISGNormalModalButton").click(function() {
	$("&lt;div&gt;&lt;h1&gt;This is a Normal Dialog&lt;/h1&gt;Body content goes here.&lt;/div&gt;").makeModal({width: 400});
});
</pre>

<h3>Persistent Modal Sample</h3>
<button id="UISGPersistentModalButton">Persistent Modal</button>
<script>
$(function() {
	$("#UISGPersistentModalButton").click(function() {
		if(UISGNamespace.UISGPersistentModal) {
			// Recall a persisted modal.  This way, recalling modals will be faster as it limits repeated DOM construction and event attachments
			// Use this carefully, and do keep in mind that state of the modal is whatever it was, so reset state as needed.
			UISGNamespace.UISGPersistentModal.showModal();
		} else {
			// this ensures modal is only created once on the first click
			UISGNamespace.UISGPersistentModal = $("<div><h1>This is a Persistent Dialog</h1>Body content goes here.</div>").makeModal({width:400, persistent: true});
		}
	});
});
</script>
<h3>Persistent Modal Code:</h3>
<pre>
$("#UISGPersistentModalButton").click(function() {
	if(UISGNamespace.UISGPersistentModal) {
		// Recall a persisted modal.  This way, recalling modals will be faster as it limits repeated DOM construction and event attachments
		// Use this carefully, and do keep in mind that state of the modal is whatever it was, so reset state as needed.
		UISGNamespace.UISGPersistentModal.showModal();
	} else {
		// this ensures modal is only created once on the first click
		UISGNamespace.UISGPersistentModal = $("&lt;div&gt;&lt;h1&gt;This is a Persistent Dialog&lt;/h1&gt;Body content goes here.&lt;/div&gt;").makeModal({width:400, persistent: true});
	}
});
</pre>

<h2>Modal Dialog Shortcut functions</h2>
<h3>ajax Modal Shortcut</h3>
<button id="UISGAjaxModalShortcutButton">Ajax Modal</button>
<script>
$(function() {
	$("#UISGAjaxModalShortcutButton").click(function() {
		$().getModal(
			'/wikia.php?controller=WikiaStyleGuideSpecial&method=ajaxModalSample&format=html',
			'#UISGAjaxModalSample',
			{width:400});
	});
});
</script>
<h3>ajax Modal Shortcut code sample</h3>
<pre>
$("#UISGAjaxModalShortcutButton").click(function() {
	$().getModal(
		'/wikia.php?controller=WikiaStyleGuideSpecial&method=ajaxModalSample&format=html',
		'#UISGAjaxModalSample',
		{width:400});
});
</pre>

<h3>Content Modal Shortcut</h3>
<button id="UISGContentModalShortcutButton">Content Modal</button>
<script>
$(function() {
	$("#UISGContentModalShortcutButton").click(function() {
		$.showModal("This is being created in javascript", "Content goes here", {width: 400});
	});
});
</script>
<h3>Content Modal Shortcut code sample</h3>
<pre>
$("#UISGContentModalShortcutButton").click(function() {
	$.showModal("This is being created in javascript", "Content goes here", {width: 400});
});
</pre>

<h2>Form</h2>
<?php
// See: /extensions/wikia/WikiaStyleGuide/templates/WikiaStyleGuideForm_index.php
$uisgSampleForm = array (
	'action' => '',
	'method' => 'GET',
    'inputs' => array (
        array(
            // Main input attributes
            'label' => 'A Text Input',
            'type' => 'text',
            'name' => 'uisgformsampletext',
            // extra attributes (all optional)
            'attributes' => array(
                'placeholder' => 'default text if you want',
                'maxlength' => 160,
                'class' => 'uisgformsampleclass',
            ),
        ),
        array(
        	'type' => 'custom',
        	'output' => '<label>Free form label</label>You can put whatever you want in here',
        ),
        array(
            // Main input attributes
            'label' => 'A Text Input',
            'type' => 'text',
            'name' => 'uisgformsampletext',
            // extra attributes (all optional)
            'attributes' => array(
            ),
        ),
    )
);
echo F::app()->renderView('WikiaStyleGuideForm', 'index', array('form' => $uisgSampleForm));
?>

<h2>System Notification (aka Banner Notification)</h2>
<div id="UISGBannerNotification" class="uisg-sample-pane">
	Click me to toggle Notification near top of the window.
</div>
<!-- Banner Notification Sample Code -->
<script>
$(function() {
	var bannerNotification =
		new BannerNotification('Hello there, I am a Banner Notification', 'notify');
	$('#UISGBannerNotification').toggle(function() {
		bannerNotification.show();
	}, function() {
		bannerNotification.hide();
	});
});
</script>
<h3>Sample Code:</h3>
<pre>
html:
&lt;div id=&quot;UISGBannerNotification&quot; class=&quot;uisg-sample-pane&quot;&gt;<br/>	Click me to toggle Notification near top of the window.<br/>&lt;/div&gt;

javascript:
	var bannerNotification =
		new BannerNotification('Hello there, I am a Banner Notification', 'notify');
	$('#UISGBannerNotification').toggle(function() {
		bannerNotification.show();
	}, function() {
		bannerNotification.hide();
	});
});
</pre>

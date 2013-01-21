<div id="UserLoginDropdown" class="UserLoginDropdown subnav">
<?php
	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $formData));

	// 3rd party providers buttons
	echo $app->renderView('UserLoginSpecial', 'Providers', array('tabindex' => ++$tabindex));
?>
</div>

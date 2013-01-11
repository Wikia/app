<div class="UserLogin">
<?php
	echo $app->renderView('WikiaStyleGuideForm', 'index', array('form' => $form));

	// 3rd party providers buttons
	if (!$isMonobookOrUncyclo) echo $app->renderView('UserLoginSpecial', 'Providers', array('tabindex' => ++$tabindex));
?>
</div>

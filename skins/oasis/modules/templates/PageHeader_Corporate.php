<div id="WikiaPageHeader" class="WikiaPageHeader">
	<h1><?= !empty($displaytitle) ? $title : htmlspecialchars($title) ?></h1>
<?php
        // edit button with actions dropdown
        if ( !empty($action) && $canAct ) {
                echo F::app()->renderView('MenuButton', 'Index', array('action' => $action, 'image' => $actionImage, 'dropdown' => $dropdown, 'name' => $actionName));
        }
?>
	<p><?= $subtitle ?></p>
</div>

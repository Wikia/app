<?php
$values = $object->getValues();
if (empty($values) || $values[0] == null):?>
	<p class="empty">empty</p>
<?php else:
	echo ($rendererName == '@list') ? '<ol>' : '<ul>';
	foreach($values as $reference) {
		echo '<li>';
		$referenceHTML = false;
		if (is_object($reference) && (!is_null($reference->object))) {
			$referenceHTML = $reference->object->render( $context );
		}
		if ($referenceHTML !== false) {
			echo $referenceHTML;
		}
		else {
			echo $reference;
		}
		echo '</li>';

	}

	echo ($rendererName == '@list') ? '</ol>' : '</ul>';
	?>
<?php endif;?>
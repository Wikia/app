<?php
$values = $object->getValues();
if (empty($values)):?>
<span class="empty">empty</span>
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

			continue;
		} else {
			echo '<pre>';print_r($reference);echo '</pre>';
		}
		echo '</li>';

	}

	echo ($rendererName == '@list') ? '</ol>' : '</ul>';
	?>
<?php endif;?>
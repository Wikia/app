<?php

$values = $object->getValue(true);

if ( $context == SD_CONTEXT_EDITING ) {
	echo '<ol data-field-name="'.$object->getName().'">';
}

foreach ( $values as $i => $reference ) {

	$text = $reference->object->getProperty('schema:text');
	$name = $reference->object->getProperty('schema:name');
	$description = $reference->object->getProperty('schema:name');

	if ( $context == SD_CONTEXT_DEFAULT ) {

		echo '<p>' . $text->getValue() . '</p>';
	}

	if ( $context == SD_CONTEXT_SPECIAL ) {
		echo '<strong><a href="' . $reference->object->getSpecialPageUrl() . '">' . htmlspecialchars
		($reference->object->getName() ) . '</a></strong>';
		echo '<p>' . $text->getValue() . '</p>';
	}

	if ( $context == SD_CONTEXT_EDITING ) {

    	?>
		<li>
			<input type="hidden" name="wikia:wikiText[]" value="<?=$reference->object->getId();?>" />
			<a href="<?=$reference->object->getSpecialPageUrl();?>"><?=htmlspecialchars( $reference->object->getName() );?></a>
			<button class="secondary remove">Remove</button>
        </li>
	<?php
	}

}

if ( $context == SD_CONTEXT_EDITING ) {
	echo '</ol>';
	if ( $object->getType()->hasRange() ) {
		$types = $object->getType()->getAcceptedValues();
		if (count($types['classes']) == 1 && in_array('rdfs:Literal', $types['classes'])) {
			echo '<button class="add-input" data-range="' . join('', $types['classes']) . '">Add new</button>';
		} else {
			echo '<button class="load-dropdown" data-range="' . join(' ', $types['classes']) . '">Add</button>';
		}
	}
}

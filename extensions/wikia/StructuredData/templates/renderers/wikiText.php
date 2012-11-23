<?php

$values = $object->getWrappedValue();

if ( $context == SD_CONTEXT_EDITING ) {
	echo '<ol data-field-name="'.$object->getName().'">';
}

/* @var SDElementPropertyValue $propertyValue */
foreach ( $values as $i => $propertyValue ) {
	$value = $propertyValue->getValue();

	//@todo - handle the case when $value->object is null because for some reason the referenced object couldn't be fetched
	// in this case we should still have the object id in form fields, so this reference is not removed during form submit

	$text = $value->object->getPropertyValue('schema:text');

	if ( $context == SD_CONTEXT_DEFAULT ) {

		echo '<p>' . $text->getValue() . '</p>';
	}

	if ( $context == SD_CONTEXT_SPECIAL ) {
		echo '<strong><a href="' . $value->object->getSpecialPageUrl() . '">' . htmlspecialchars
		($value->object->getName() ) . '</a></strong>';
		echo '<p>' . $text->getValue() . '</p>';
	}

	if ( $context == SD_CONTEXT_EDITING ) {

    	?>
		<li>
			<input type="hidden" name="wikia:wikiText[]" value="<?=$value->object->getId();?>" />
			<a href="<?=$value->object->getSpecialPageUrl();?>"><?=htmlspecialchars( $value->object->getName() );?></a>
			<button class="secondary remove">Remove</button>
        </li>
	<?php
	}
}
if ( $context == SD_CONTEXT_DEFAULT ) {
	echo '<button class="add-wikiText-SDObj-from-article">Add new WikiText object</button>';
	echo F::build('JSSnippets')->addToStack(
		array('/extensions/wikia/StructuredData/js/StructuredDataInArticle.js')
	);
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

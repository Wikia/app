<?php
$values = $object->getWrappedValue();

if ( !count( $values ) && ( $context == SD_CONTEXT_SPECIAL ) ):
	echo '<p class="empty">empty</p>';
else:

if ( $context == SD_CONTEXT_EDITING ) {
	echo '<ol data-field-name="'.$object->getName().'">';
}

/* @var SDElementPropertyValue $propertyValue */
foreach ( $values as $i => $propertyValue ) {
	$value = $propertyValue->getValue();

	if (isset($value->object) && ($value->object !== null)) {
		$text = $value->object->getPropertyValue('schema:text');
	}

	if ( $context == SD_CONTEXT_DEFAULT ) {
		if (isset($value->object) && ($value->object !== null)) {
			echo '<p>' . $text->getValue() . '</p>';
		}
	}

	if ( $context == SD_CONTEXT_SPECIAL ) {
		if (isset($value->object) && ($value->object !== null)) {
			echo '<strong><a href="' . $value->object->getObjectPageUrl($context) . '">' . htmlspecialchars
			($value->object->getName() ) . '</a></strong>';
			echo '<p>' . $text->getValue() . '</p>';
		}
		else {
			echo '<p>' . $value->id . '</p>';
		}
	}

	if ( $context == SD_CONTEXT_EDITING ) {

    	?>
		<li>
			<input type="hidden" name="wikia:wikiText[]" value="<?=$value->id;?>" />
			<?php if (isset($value->object) && $value->object !== null) : ?>
				<a href="<?=$value->object->getObjectPageUrl($context);?>"><?=htmlspecialchars( $value->object->getName() );?></a>
			<?php else : ?>
				<?=$value->id;?>
			<?php endif; ?>
			<button class="secondary remove">Remove</button>
        </li>
	<?php
	}
}
if ( $context == SD_CONTEXT_DEFAULT ) {
	echo '<button class="add-wikiText-SDObj-from-article" data-displayed-object="' . $object->getName() .
		'" data-object-id="'.$params['objectId'].'" data-prop-name="'.$params['propName'].'">Add new WikiText object</button>';
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

endif;

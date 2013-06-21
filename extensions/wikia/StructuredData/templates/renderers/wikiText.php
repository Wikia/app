<?php
$values = $object->getWrappedValue();

if ( !count( $values ) && ( $context == SD_CONTEXT_SPECIAL ) ):
	echo '<p class="empty">' . wfMsg('structureddata-object-empty-property') . '</p>';
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
			if (isset($params['parser'])) {
				echo '<p>' . $params['parser']->recursiveTagParse($text->getValue(), isset( $params['frame'] ) ? $params['frame'] : null ) . '</p>';
			} else {
				echo '<p>' . $text->getValue() . '</p>';
			}
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
			<button class="secondary remove"><?= wfMsg('structureddata-object-edit-remove-reference') ?></button>
        </li>
	<?php
	}
}
/*if ( $context == SD_CONTEXT_DEFAULT ) {
	echo '<button class="add-wikiText-SDObj-from-article" data-displayed-object="' . $object->getName() .
		'" data-object-id="'.$params['objectId'].'" data-prop-name="'.$params['propName'].'">' . wfMsg('structureddata-add-trivia-from-article-btn') . '</button>';
	echo JSSnippets::addToStack(
		array('/extensions/wikia/StructuredData/js/StructuredDataInArticle.js')
	);
}*/
if ( $context == SD_CONTEXT_EDITING ) {
	echo '</ol>';
	if ( $object->getType()->hasRange() ) {
		$types = $object->getType()->getAcceptedValues();
		if (count($types['classes']) == 1 && in_array('rdfs:Literal', $types['classes'])) {
			echo '<button class="add-input" data-range="' . join('', $types['classes']) . '">'. wfMsg('structureddata-object-edit-add-blank-input-to-collection-btn') . '</button>';
		} else {
			echo '<button class="load-dropdown" data-range="' . join(' ', $types['classes']) . '">' . wfMsg('structureddata-object-edit-add-new-reference-btn') .
				'</button>';
		}
	}
}

endif;

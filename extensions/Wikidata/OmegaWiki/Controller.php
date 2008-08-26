<?php

require_once("OmegaWikiAttributes.php");

interface UpdateController {
	public function add(IdStack $idPath, $record);
	public function remove($keyPath);
	public function update($keyPath, $record);
}

interface UpdateAttributeController {
	public function update($keyPath, $value);
}

interface PermissionController {
	public function allowUpdateOfAttribute($attribute);
	public function allowUpdateOfValue($idPath, $value);
	public function allowRemovalOfValue($idPath, $value);
}

class SimplePermissionController implements PermissionController {
	protected $allowUpdate;
	protected $allowRemove;
	
	public function __construct($allowUpdate, $allowRemove = true) {
		$this->allowUpdate = $allowUpdate;
		$this->allowRemove = $allowRemove;
	}	
	
	public function allowUpdateOfAttribute($attribute) {
		return $this->allowUpdate;
	}

	public function allowUpdateOfValue($idPath, $value) {
		return $this->allowUpdate;
	}
	
	public function allowRemovalOfValue($idPath, $value) {
		return $this->allowRemove;
	}
}

class DefaultUpdateController implements UpdateController {
	public function add(IdStack $idPath, $record) {
	}
	
	public function remove($keyPath) {
	}

	public function update($keyPath, $record) {
	}
}

class DefinedMeaningDefinitionController extends DefaultUpdateController {
	public function add(IdStack $idPath, $record) {
		$definedMeaningId = $idPath->getKeyStack()->peek(0)->definedMeaningId;
		$languageId = $record->language;
		$text = $record->text;

		if ($languageId != 0 && $text != "")
			addDefinedMeaningDefinition($definedMeaningId, $languageId, $text);
	}

	public function remove($keyPath) {
		$definedMeaningId = $keyPath->peek(1)->definedMeaningId;
		$languageId = $keyPath->peek(0)->language;
		removeDefinedMeaningDefinition($definedMeaningId, $languageId);
	}

	public function update($keyPath, $record) {
		$definedMeaningId = $keyPath->peek(1)->definedMeaningId;
		$languageId = $keyPath->peek(0)->language;
		$text = $record->text;

		if ($text != "")
			updateDefinedMeaningDefinition($definedMeaningId, $languageId, $text);
	}
}

class DefinedMeaningFilteredDefinitionController implements UpdateAttributeController {
	protected $filterLanguageId;
	
	public function __construct($filterLanguageId) {
		$this->filterLanguageId = $filterLanguageId;
	}

	public function update($keyPath, $value) {
		$definedMeaningId = $keyPath->peek(0)->definedMeaningId;
		
		if ($value != "")
			updateOrAddDefinedMeaningDefinition($definedMeaningId, $this->filterLanguageId, $value);
	}
}

class DefinedMeaningAlternativeDefinitionsController extends DefaultUpdateController {
	protected $filterLanguageId;
	
	public function __construct($filterLanguageId) {
		$this->filterLanguageId = $filterLanguageId;
	}
	
	public function add(IdStack $idPath, $record)  {
		$definedMeaningId = $idPath->getKeyStack()->peek(0)->definedMeaningId;
		$alternativeDefinition = $record->alternativeDefinition;
		$sourceId = $record->source;

		if ($this->filterLanguageId == 0) {
			if ($alternativeDefinition->getRecordCount() > 0) {
				$definitionRecord = $alternativeDefinition->getRecord(0);
	
				$languageId = $definitionRecord->language;
				$text = $definitionRecord->text;
	
				if ($languageId != 0 && $text != '')
					addDefinedMeaningAlternativeDefinition($definedMeaningId, $languageId, $text, $sourceId);
			}
		}
		else if ($alternativeDefinition != '') 
			addDefinedMeaningAlternativeDefinition($definedMeaningId, $this->filterLanguageId, $alternativeDefinition, $sourceId);
	}

	public function remove($keyPath) {
		$definedMeaningId = $keyPath->peek(1)->definedMeaningId;
		$definitionId = $keyPath->peek(0)->definitionId;
		removeDefinedMeaningAlternativeDefinition($definedMeaningId, $definitionId);
	}
}

class DefinedMeaningAlternativeDefinitionController extends DefaultUpdateController {
	public function add(IdStack $idPath, $record) {
		$definitionId = $idPath->getKeyStack()->peek(0)->definitionId;
		$languageId = $record->language;
		$text = $record->text;

		if ($languageId != 0 && $text != "")
			addTranslatedTextIfNotPresent($definitionId, $languageId, $text);
	}

	public function remove($keyPath) {
		$definitionId = $keyPath->peek(1)->definitionId;
		$languageId = $keyPath->peek(0)->language;

		removeTranslatedText($definitionId, $languageId);
	}

	public function update($keyPath, $record) {
		$definitionId = $keyPath->peek(1)->definitionId;
		$languageId = $keyPath->peek(0)->language;
		$text = $record->text;

		if ($text != "")
			updateTranslatedText($definitionId, $languageId, $text);
	}
}

class DefinedMeaningFilteredAlternativeDefinitionController implements UpdateAttributeController {
	protected $filterLanguageId;
	
	public function __construct($filterLanguageId) {
		$this->filterLanguageId = $filterLanguageId;
	}
	
	public function update($keyPath, $value) {
		$definitionId = $keyPath->peek(0)->definitionId;

		if ($value != "")
			updateTranslatedText($definitionId, $this->filterLanguageId, $value);
	}
}

class SynonymTranslationController extends DefaultUpdateController {
	protected $filterLanguageId;
	
	public function __construct($filterLanguageId) {
		$this->filterLanguageId = $filterLanguageId;
	}
	
	public function add(IdStack $idPath, $record) {
		$definedMeaningId = $idPath->getKeyStack()->peek(0)->definedMeaningId;
		$expressionValue = $record->expression;
		
		if ($this->filterLanguageId == 0) {
			$languageId = $expressionValue->language;
			$spelling = $expressionValue->spelling;
		}
		else {
			$languageId	= $this->filterLanguageId;
			$spelling = $expressionValue;
		}
		
		$identicalMeaning = $record->identicalMeaning;

		if ($languageId != 0 && $spelling != '') {
			$expression = findOrCreateExpression($spelling, $languageId);
			$expression->assureIsBoundToDefinedMeaning($definedMeaningId, $identicalMeaning);
		}
	}

	public function remove($keyPath) {
		$definedMeaningId = $keyPath->peek(1)->definedMeaningId;
		$syntransId = $keyPath->peek(0)->syntransId;
		removeSynonymOrTranslationWithId($syntransId);
	}

	public function update($keyPath, $record) {
		$definedMeaningId = $keyPath->peek(1)->definedMeaningId;
		$syntransId = $keyPath->peek(0)->syntransId;
		$identicalMeaning = $record->identicalMeaning;
		updateSynonymOrTranslationWithId($syntransId, $identicalMeaning);
	}
}

class ClassAttributesController extends DefaultUpdateController {
	public function add(IdStack $idPath, $record) {
		$definedMeaningId = $idPath->getKeyStack()->peek(0)->definedMeaningId;
		$attributeLevelId = $record->classAttributeLevel;
		$attributeMeaningId = $record->classAttributeAttribute;
		$attributeType = $record->classAttributeType;

		if (($attributeLevelId != 0) && ($attributeMeaningId != 0))
			addClassAttribute($definedMeaningId, $attributeLevelId, $attributeMeaningId, $attributeType);
	}

	public function remove($keyPath) {
		$classAttributeId = $keyPath->peek(0)->classAttributeId;
		removeClassAttributeWithId($classAttributeId);
	}
}

class DefinedMeaningClassMembershipController extends DefaultUpdateController {
	public function add(IdStack $idPath, $record) {
		$definedMeaningId = $idPath->getKeyStack()->peek(0)->definedMeaningId;
		$classId = $record->class;

		if ($classId != 0)
			addClassMembership($definedMeaningId, $classId);
	}

	public function remove($keyPath) {
		removeClassMembershipWithId($keyPath->peek(0)->classMembershipId);
	}
}

class DefinedMeaningCollectionController extends DefaultUpdateController {
	public function add(IdStack $idPath, $record) {
		$definedMeaningId = $idPath->getKeyStack()->peek(0)->definedMeaningId;
		$collectionMeaningId = $record->collectionMeaning;
		$internalId = $record->sourceIdentifier;
		
		if ($collectionMeaningId != 0)
			addDefinedMeaningToCollectionIfNotPresent($definedMeaningId, $collectionMeaningId, $internalId);
	}

	public function remove($keyPath) {
		$definedMeaningId = $keyPath->peek(1)->definedMeaningId;
		$collectionId = $keyPath->peek(0)->collectionId;

		removeDefinedMeaningFromCollection($definedMeaningId, $collectionId);
	}

	public function update($keyPath, $record) {
		$definedMeaningId = $keyPath->peek(1)->definedMeaningId;
		$collectionId = $keyPath->peek(0)->collectionId;
		$sourceId = $record->sourceIdentifier;

//		if ($sourceId != "")
			updateDefinedMeaningInCollection($definedMeaningId, $collectionId, $sourceId);
	}
}

class ExpressionMeaningController extends DefaultUpdateController {
	protected $filterLanguageId;
	
	public function __construct($filterLanguageId) {
		$this->filterLanguageId = $filterLanguageId;
	}

	public function add(IdStack $idPath, $record) {
		$definition = $record->definedMeaning->definition;
		$translatedContent = $definition->translatedText;
		$expressionId = $idPath->getKeyStack()->peek(0)->expressionId;

		if ($this->filterLanguageId == 0) {
			if ($translatedContent->getRecordCount() > 0) {
				$definitionRecord = $translatedContent->getRecord(0);
	
				$text = $definitionRecord->text;
				$languageId = $definitionRecord->language;
	
				if ($languageId != 0 && $text != "")  
					createNewDefinedMeaning($expressionId, $languageId, $text);
			}
		}
		else if ($translatedContent != "") 
			createNewDefinedMeaning($expressionId, $this->filterLanguageId, $translatedContent);
	}
}

class ExpressionController extends DefaultUpdateController {
	protected $spelling;
	protected $filterLanguageId;

	public function __construct($spelling, $filterLanguageId) {
		$this->spelling = $spelling;
		$this->filterLanguageId = $filterLanguageId;
	}

	public function add(IdStack $idPath, $record) {
		if ($this->filterLanguageId == 0)
			$expressionLanguageId = $record->expression->language;
		else
			$expressionLanguageId = $this->filterLanguageId; 
				
		$expressionMeanings = $record->expressionMeanings->expressionExactMeanings;

		if ($expressionLanguageId != 0 && $expressionMeanings->getRecordCount() > 0) {
			$expressionMeaning = $expressionMeanings->getRecord(0);

			$definition = $expressionMeaning->definedMeaning->definition;
			$translatedContent = $definition->translatedText;
			
 			if ($this->filterLanguageId == 0) {					
				if ($translatedContent->getRecordCount() > 0) {
					$definitionRecord = $translatedContent->getRecord(0);
	
					$text = $definitionRecord->text;
					$languageId = $definitionRecord->language;
	
					if ($languageId != 0 && $text != "") {
						$expression = findOrCreateExpression($this->spelling, $expressionLanguageId);
						createNewDefinedMeaning($expression->id, $languageId, $text);
					}
				}
			}
			else if ($translatedContent != "") {
				$expression = findOrCreateExpression($this->spelling, $expressionLanguageId);
				createNewDefinedMeaning($expression->id, $this->filterLanguageId, $translatedContent);
			}
		}
	}
}

class ObjectAttributeValuesController extends DefaultUpdateController {
	protected $objectIdFetcher;
	protected $attributeIDFilter;
	protected $levelName;
	
	public function __construct(ContextFetcher $objectIdFetcher, $levelName, AttributeIDFilter $attributeIDFilter) {
		$this->objectIdFetcher = $objectIdFetcher;
		$this->attributeIDFilter = $attributeIDFilter;
		$this->levelName = $levelName;
	}

	protected function determineAttributeId(IdStack $idPath, $annotationType, $attributeIdFromRecord) {
		$result = $attributeIdFromRecord;
		
		if ($this->attributeIDFilter->leavesOnlyOneOption()) {
			$classAttributes = $idPath->getClassAttributes()->filterClassAttributesOnLevelAndType($this->levelName, $annotationType);
			$classAttributes = $this->attributeIDFilter->filter($classAttributes);
		
			if (count($classAttributes) == 1)
				$result = $classAttributes[0];
		}  
		
		return $result;
	}
}

class DefinedMeaningAttributeValuesController extends ObjectAttributeValuesController {
	public function add(IdStack $idPath, $record)  {
		$objectId = $this->objectIdFetcher->fetch($idPath->getKeyStack());
		$definedMeaningAttributeId = $this->determineAttributeId($idPath, "DM", $record->relationType);
		$definedMeaningValue = $record->otherDefinedMeaning;
		
		if ($definedMeaningAttributeId != 0 && $definedMeaningValue != 0) 		
			addRelation($objectId, $definedMeaningAttributeId, $definedMeaningValue);
	}

	public function remove($keyPath) {
		$valueId = $keyPath->peek(0)->relationId;
		removeRelationWithId($valueId);
	}
}

class TextAttributeValuesController extends ObjectAttributeValuesController {
	public function add(IdStack $idPath, $record)  {
		$objectId = $this->objectIdFetcher->fetch($idPath->getKeyStack());
		$textAttributeId = $this->determineAttributeId($idPath, "TEXT", $record->textAttribute);
		$text = $record->text;
		
		if ($textAttributeId != 0 && $text != '')		
			addTextAttributeValue($objectId, $textAttributeId, $text);
	}

	public function remove($keyPath) {
		$textId = $keyPath->peek(0)->textAttributeId;
		removeTextAttributeValue($textId);
	}

	public function update($keyPath, $record) {
		$textId = $keyPath->peek(0)->textAttributeId;
		
		$text = $record->text;
		
		if ($text != "")
			updateTextAttributeValue($text, $textId);
	}
}

class LinkAttributeValuesController extends ObjectAttributeValuesController {
	protected function validateURL($url) {
		if (!strpos($url,"://"))
			$url = "http://" . $url;
			
		return $url;
	}
	
	public function add(IdStack $idPath, $record)  {
		$objectId = $this->objectIdFetcher->fetch($idPath->getKeyStack());
		$linkAttributeId = $this->determineAttributeId($idPath, "URL", $record->linkAttribute);
		$linkValue = $record->link;
		$label = $linkValue->linkLabel;
		$url = $linkValue->linkURL;		
		
		if ($linkAttributeId != 0 && $url != "") 		
			addLinkAttributeValue($objectId, $linkAttributeId, $this->validateURL($url), $label);
	}

	public function remove($keyPath) {
		$linkId = $keyPath->peek(0)->linkAttributeId;
		removeLinkAttributeValue($linkId);
	}

	public function update($keyPath, $record) {
		$linkId = $keyPath->peek(0)->linkAttributeId;
		$linkValue = $record->link;
		$label = $linkValue->linkLabel;
		$url = $linkValue->linkURL;		
				
		if ($url != "") 
			updateLinkAttributeValue($linkId, $this->validateURL($url), $label);
	}
}

class TranslatedTextAttributeValuesController extends ObjectAttributeValuesController {
	protected $filterLanguageId;
	
	public function __construct(ContextFetcher $objectIdFetcher, $levelName, AttributeIDFilter $attributeIDFilter, $filterLanguageId) {
		parent::__construct($objectIdFetcher, $levelName, $attributeIDFilter);
		
		$this->filterLanguageId = $filterLanguageId;
	}
	
	public function add(IdStack $idPath, $record)  {
		$objectId = $this->objectIdFetcher->fetch($idPath->getKeyStack());
		$textValue = $record->translatedTextValue;
		$textAttributeId = $this->determineAttributeId($idPath, "TRNS", $record->translatedTextAttribute);

		if ($textAttributeId != 0) {
			if ($this->filterLanguageId == 0) {
				if ($textValue->getRecordCount() > 0) {
					$textValueRecord = $textValue->getRecord(0);
		
					$languageId = $textValueRecord->language;
					$text = $textValueRecord->text;
					
					if ($languageId != 0 && $text != '')
						addTranslatedTextAttributeValue($objectId, $textAttributeId, $languageId, $text);
				}
			}
			else if ($textValue != '')
				addTranslatedTextAttributeValue($objectId, $textAttributeId, $this->filterLanguageId, $textValue);
		}
	}

	public function remove($keyPath) {
		$valueId = $keyPath->peek(0)->translatedTextAttributeId;
		removeTranslatedTextAttributeValue($valueId);
	}
}

class TranslatedTextAttributeValueController extends DefaultUpdateController {
	public function add(IdStack $idPath, $record) {
		$valueId = $idPath->getKeyStack()->peek(0)->translatedTextAttributeId;
		$languageId = $record->language;
		$text = $record->text;
		$translatedTextAttribute = getTranslatedTextAttribute($valueId);

		if ($languageId != 0 && $text != "")
			addTranslatedTextIfNotPresent($translatedTextAttribute->value_tcid, $languageId, $text);
	}

	public function remove($keyPath) {
		$valueId = $keyPath->peek(1)->translatedTextAttributeId;
		$languageId = $keyPath->peek(0)->language;
		$translatedTextAttribute = getTranslatedTextAttribute($valueId);

		removeTranslatedText($translatedTextAttribute->value_tcid, $languageId);
	}

	public function update($keyPath, $record) {
		$valueId = $keyPath->peek(1)->translatedTextAttributeId;
		$languageId = $keyPath->peek(0)->language;
		$text = $record->text;
		$translatedTextAttribute = getTranslatedTextAttribute($valueId);

		if ($text != "")
			updateTranslatedText($translatedTextAttribute->value_tcid, $languageId, $text);
	}
}

class FilteredTranslatedTextAttributeValueController implements UpdateAttributeController {
	protected $filterLanguageId;
	
	public function __construct($filterLanguageId) {
		$this->filterLanguageId = $filterLanguageId;
	}
	
	public function update($keyPath, $value) {
		$valueId = $keyPath->peek(0)->translatedTextAttributeId;
		$translatedTextAttribute = getTranslatedTextAttribute($valueId);

		if ($value != "")
			updateTranslatedText($translatedTextAttribute->value_tcid, $this->filterLanguageId, $value);
	}
}

class OptionAttributeValuesController extends ObjectAttributeValuesController {
	public function add(IdStack $idPath, $record) {
		$objectId = $this->objectIdFetcher->fetch($idPath->getKeyStack());
		$optionId = $record->optionAttributeOption;

		if ($optionId)
			addOptionAttributeValue($objectId,$optionId);
	}

	public function remove($keyPath) {
		$valueId = $keyPath->peek(0)->optionAttributeId;
		removeOptionAttributeValue($valueId);
	}
}

class OptionAttributeOptionsController extends DefaultUpdateController {
	public function add(IdStack $idPath, $record) {
		$attributeId = $idPath->getKeyStack()->peek(0)->classAttributeId;
		$optionMeaningId = $record->optionAttributeOption;
		$languageId = $record->language;

		if ($optionMeaningId)
			addOptionAttributeOption($attributeId, $optionMeaningId, $languageId);
	}

	public function remove($keyPath) {
		$optionId = $keyPath->peek(0)->optionAttributeOptionId;
		removeOptionAttributeOption($optionId);
	}
}

class AlternativeDefinitionsPermissionController implements PermissionController {
	public function allowUpdateOfAttribute($attribute) {
		return true;	
	}
	
	public function allowUpdateOfValue($idPath, $value) {
		return $this->allowAnyChangeOfValue($value);
	}
	
	public function allowRemovalOfValue($idPath, $value) {
		return $this->allowAnyChangeOfValue($value);
	}

	protected function allowAnyChangeOfValue($value) {
		$source = $value->source;	
			
		return $source == null || $source == 0;
	}
}



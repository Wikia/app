<?php

require_once("Editor.php");
require_once("OmegaWikiAttributes.php");
require_once("WikiDataBootstrappedMeanings.php");
require_once("ContextFetcher.php");
require_once("WikiDataGlobals.php");
require_once("GotoSourceTemplate.php");
require_once("ViewInformation.php");

class DummyViewer extends Viewer {
	public function view(IdStack $idPath, $value) {
		return "";	
	}

	public function showsData($value) {
		return true;
	}
}

class ObjectAttributeValuesEditor extends WrappingEditor {
	protected $recordSetTableEditor;
	protected $propertyAttribute;
	protected $valueAttribute;
	protected $attributeIDFilter;
	protected $levelName;
	protected $showPropertyColumn;
	
	public function __construct(Attribute $attribute, $propertyCaption, $valueCaption, ViewInformation $viewInformation, $levelName, AttributeIDFilter $attributeIDFilter) {
		parent::__construct(new RecordUnorderedListEditor($attribute, 5));
		
		$this->levelName = $levelName;
		$this->attributeIDFilter = $attributeIDFilter;
		$this->showPropertyColumn = !$attributeIDFilter->leavesOnlyOneOption();
		
		$this->recordSetTableEditor = new RecordSetTableEditor(
			$attribute, 
			new SimplePermissionController(false), 
			new ShowEditFieldChecker(true), 
			new AllowAddController(false), 
			false, 
			false, 
			null
		);
		
		$this->propertyAttribute = new Attribute("property", $propertyCaption, "short-text");
		$this->valueAttribute = new Attribute("value", $valueCaption, "short-text");
		
		foreach ($viewInformation->getPropertyToColumnFilters() as $propertyToColumnFilter) 
			$this->recordSetTableEditor->addEditor(new DummyViewer($propertyToColumnFilter->getAttribute()));

		$o=OmegaWikiAttributes::getInstance();
			
		$this->recordSetTableEditor->addEditor(new DummyViewer($o->objectAttributes));
		addTableMetadataEditors($this->recordSetTableEditor, $viewInformation);
	}
	
	public function getAttributeIDFilter() {
		return $this->attributeIDFilter;
	}
	
	public function getLevelName() {
		return $this->levelName;
	}
	
	protected function attributeInStructure(Attribute $attribute, Structure $structure) {
		$result = false;
		$attributes = $structure->getAttributes();
		$i = 0;
		
		while (!$result && $i < count($attributes)) {
			$result = $attribute->id == $attributes[$i]->id;
			$i++; 
		}
		
		return $result;
	}
	
	protected function attributeInStructures(Attribute $attribute, array &$structures) {
		$result = false;
		$i = 0;
		
		while (!$result && $i < count($structures)) {
			$result = $this->attributeInStructure($attribute, $structures[$i]);
			$i++;
		}
		
		return $result;
	}
	
	protected function getSubStructureForAttribute(Structure $structure, Attribute $attribute) {
		$attributes = $structure->getAttributes();
		$result = null;
		$i = 0;
		
		while ($result == null && $i < count($attributes)) 
			if ($attribute->id == $attributes[$i]->id)
				$result = $attributes[$i]->type;
			else
				$i++;	
		
		return $result;
	}
	
	protected function filterStructuresOnAttribute(array &$structures, Attribute $attribute) {
		$result = array();
		
		foreach ($structures as $structure) {
			$subStructure = $this->getSubStructureForAttribute($structure, $attribute);
			
			if ($subStructure != null)
				$result[] = $subStructure;
		}
		
		return $result;
	}
	
	protected function filterAttributesByStructures(array &$attributes, array &$structures) {
		$result = array();

		foreach ($attributes as $attribute) { 
			if ($attribute->type instanceof Structure) {
				$filteredAttributes = $this->filterAttributesByStructures(
					$attribute->type->getAttributes(),
					$this->filterStructuresOnAttribute($structures, $attribute) 
				);
				
				if (count($filteredAttributes) > 0)
					$result[] = new Attribute($attribute->id, $attribute->name, new Structure($filteredAttributes));
			}
			else if ($this->attributeInStructures($attribute, $structures))
				$result[] = $attribute;
		}
		
		return $result;
	}
	
	public function determineVisibleSuffixAttributes(IdStack $idPath, $value) {
		$visibleStructures = array();
		
		foreach ($this->getEditors() as $editor) {
			$visibleStructure = $editor->getTableStructureForView($idPath, $value->getAttributeValue($editor->getAttribute()));
			
			if (count($visibleStructure->getAttributes()) > 0)
				$visibleStructures[] = $visibleStructure;
		}

		return $this->filterAttributesByStructures(
			$this->recordSetTableEditor->getTableStructure($this->recordSetTableEditor)->getAttributes(), 
			$visibleStructures
		);
	}
	
	public function addEditor(Editor $editor) {
		$this->wrappedEditor->addEditor($editor);
	}
	
	protected function getVisibleStructureForEditor(Editor $editor, $showPropertyColumn, array &$suffixAttributes) {
		$leadingAttributes = array();
		$childEditors = $editor->getEditors();
		
		for ($i = $showPropertyColumn ? 0 : 1; $i < 2; $i++)
			$leadingAttributes[] = $childEditors[$i]->getAttribute();
			
		return new Structure(array_merge($leadingAttributes, $suffixAttributes));
	}

	public function view(IdStack $idPath, $value) {
		$visibleAttributes = array();

		if ($this->showPropertyColumn)
			$visibleAttributes[] = $this->propertyAttribute;
			
		$visibleAttributes[] = $this->valueAttribute;	

		$idPath->pushAnnotationAttribute($this->getAttribute());
		$visibleSuffixAttributes = $this->determineVisibleSuffixAttributes($idPath, $value); 
		
		$visibleStructure = new Structure(array_merge($visibleAttributes, $visibleSuffixAttributes));
		
		$result = $this->recordSetTableEditor->viewHeader($idPath, $visibleStructure);

		foreach ($this->getEditors() as $editor) {
			$attribute = $editor->getAttribute();
			$idPath->pushAttribute($attribute);
			$result .= $editor->viewRows(
				$idPath, 
				$value->getAttributeValue($attribute),
				$this->getVisibleStructureForEditor($editor, $this->showPropertyColumn, $visibleSuffixAttributes)
			);
			$idPath->popAttribute();
		} 
		
		$result .= $this->recordSetTableEditor->viewFooter($idPath, $visibleStructure);

		$idPath->popAnnotationAttribute();

		return $result;
	}

	public function edit(IdStack $idPath, $value) {
		$idPath->pushAnnotationAttribute($this->getAttribute());
		$result = $this->wrappedEditor->edit($idPath, $value);		
		$idPath->popAnnotationAttribute();
		
		return $result;
	}
	
	public function add(IdStack $idPath) {
		$idPath->pushAnnotationAttribute($this->getAttribute());
		$result = $this->wrappedEditor->add($idPath);		
		$idPath->popAnnotationAttribute();
		
		return $result;
	}
	
	public function save(IdStack $idPath, $value) {
		$idPath->pushAnnotationAttribute($this->getAttribute());
		$this->wrappedEditor->save($idPath, $value);		
		$idPath->popAnnotationAttribute();
	}
	
	protected function getAttributeOptionCount(IdStack $idPath) {
		$classAttributes = $idPath->getClassAttributes()->filterClassAttributesOnLevel($this->getLevelName());
		$classAttributes = $this->getAttributeIDFilter()->filter($classAttributes);
		
		return count($classAttributes);
	}
	
	public function showEditField(IdStack $idPath) {
		return $this->getAttributeOptionCount($idPath) > 0;		
	}
}

class ShowEditFieldForAttributeValuesChecker extends ShowEditFieldChecker {
	protected $levelDefinedMeaningName;
	protected $annotationType;
	protected $attributeIDFilter; 
	
	public function __construct($levelDefinedMeaningName, $annotationType, AttributeIDFilter $attributeIDFilter) {
		$this->levelDefinedMeaningName = $levelDefinedMeaningName;
		$this->annotationType = $annotationType;
		$this->attributeIDFilter = $attributeIDFilter;
	}

	public function check(IdStack $idPath) {
		$classAttributes = $idPath->getClassAttributes()->filterClassAttributesOnLevelAndType($this->levelDefinedMeaningName, $this->annotationType);
		$classAttributes = $this->attributeIDFilter->filter($classAttributes);
		
		return count($classAttributes) > 0;
	}
}

function initializeObjectAttributeEditors(ViewInformation $viewInformation) {
	global
		$definedMeaningValueObjectAttributesEditors, 
		$textValueObjectAttributesEditors, 
		$linkValueObjectAttributesEditors, 
		$translatedTextValueObjectAttributesEditors, 
		$optionValueObjectAttributesEditors, 
		$annotationMeaningName;
		
	$o=OmegaWikiAttributes::getInstance($viewInformation);

	$definedMeaningValueObjectAttributesEditors = array();
	$textValueObjectAttributesEditors = array();
	$translatedTextValueObjectAttributesEditors = array();
	$linkValueObjectAttributesEditors = array();
	$optionValueObjectAttributesEditors = array();	
	
	foreach ($viewInformation->getPropertyToColumnFilters() as $propertyToColumnFilter) { 
		$attribute = $propertyToColumnFilter->getAttribute();
		$propertyCaption = $propertyToColumnFilter->getPropertyCaption();
		$valueCaption = $propertyToColumnFilter->getValueCaption();
		$attributeIDfilter = $propertyToColumnFilter->getAttributeIDFilter();
		
		$definedMeaningValueObjectAttributesEditors[] = new ObjectAttributeValuesEditor($attribute, $propertyCaption, $valueCaption, $viewInformation, $annotationMeaningName, $attributeIDfilter);
		$textValueObjectAttributesEditors[] = new ObjectAttributeValuesEditor($attribute, $propertyCaption, $valueCaption, $viewInformation, $annotationMeaningName, $attributeIDfilter);
		$linkValueObjectAttributesEditors[] = new ObjectAttributeValuesEditor($attribute, $propertyCaption, $valueCaption, $viewInformation, $annotationMeaningName, $attributeIDfilter);
		$translatedTextValueObjectAttributesEditors[] = new ObjectAttributeValuesEditor($attribute, $propertyCaption, $valueCaption, $viewInformation, $annotationMeaningName, $attributeIDfilter);
		$optionValueObjectAttributesEditors[] = new ObjectAttributeValuesEditor($attribute, $propertyCaption, $valueCaption, $viewInformation, $annotationMeaningName, $attributeIDfilter);
	}
	
	$leftOverAttributeIdFilter = $viewInformation->getLeftOverAttributeFilter();
	
	$definedMeaningValueObjectAttributesEditors[] = new ObjectAttributeValuesEditor($o->objectAttributes, wfMsgSc("Property"), wfMsgSc("Value"), $viewInformation,	$annotationMeaningName, $leftOverAttributeIdFilter);
	$textValueObjectAttributesEditors[] = new ObjectAttributeValuesEditor($o->objectAttributes, wfMsgSc("Property"), wfMsgSc("Value"), $viewInformation, $annotationMeaningName, $leftOverAttributeIdFilter);
	$linkValueObjectAttributesEditors[] = new ObjectAttributeValuesEditor($o->objectAttributes, wfMsgSc("Property"), wfMsgSc("Value"), $viewInformation, $annotationMeaningName, $leftOverAttributeIdFilter);
	$translatedTextValueObjectAttributesEditors[] = new ObjectAttributeValuesEditor($o->objectAttributes, wfMsgSc("Property"), wfMsgSc("Value"), $viewInformation, $annotationMeaningName, $leftOverAttributeIdFilter);
	$optionValueObjectAttributesEditors[] = new ObjectAttributeValuesEditor($o->objectAttributes, wfMsgSc("Property"), wfMsgSc("Value"), $viewInformation, $annotationMeaningName, $leftOverAttributeIdFilter);
	
	foreach ($definedMeaningValueObjectAttributesEditors as $definedMeaningValueObjectAttributesEditor)
		addObjectAttributesEditors($definedMeaningValueObjectAttributesEditor, $viewInformation, new ObjectIdFetcher(0, $o->relationType));

	foreach ($textValueObjectAttributesEditors as $textValueObjectAttributesEditor)
		addObjectAttributesEditors($textValueObjectAttributesEditor, $viewInformation, new ObjectIdFetcher(0, $o->textAttributeId));

	foreach ($linkValueObjectAttributesEditors as $linkValueObjectAttributesEditor)
		addObjectAttributesEditors($linkValueObjectAttributesEditor, $viewInformation, new ObjectIdFetcher(0, $o->linkAttributeId));

	foreach ($translatedTextValueObjectAttributesEditors as $translatedTextValueObjectAttributesEditor)
		addObjectAttributesEditors($translatedTextValueObjectAttributesEditor, $viewInformation, new ObjectIdFetcher(0, $o->translatedTextAttributeId));
		
	foreach ($optionValueObjectAttributesEditors as $optionValueObjectAttributesEditor)
		addObjectAttributesEditors($optionValueObjectAttributesEditor, $viewInformation, new ObjectIdFetcher(0, $o->optionAttributeId));
}

function getTransactionEditor(Attribute $attribute) {
	$o=OmegaWikiAttributes::getInstance();

	$transactionEditor = new RecordTableCellEditor($attribute);
	$transactionEditor->addEditor(createUserViewer($o->user));
	$transactionEditor->addEditor(new TimestampEditor($o->timestamp, new SimplePermissionController(false), true));

	return $transactionEditor;
}

function createTableLifeSpanEditor(Attribute $attribute) {
	$o=OmegaWikiAttributes::getInstance();
	
	$result = new RecordTableCellEditor($attribute);
	$result->addEditor(getTransactionEditor($o->addTransaction));
	$result->addEditor(getTransactionEditor($o->removeTransaction));
	
	return $result;
}

function getTableLifeSpanEditor($showRecordLifeSpan) {
	global
		$wgRequest;

	$o=OmegaWikiAttributes::getInstance();

	$result = array();
	
	if ($wgRequest->getText('action') == 'history' && $showRecordLifeSpan) 
		$result[] = createTableLifeSpanEditor($o->recordLifeSpan);
		
	return $result;
}

function getTableMetadataEditors(ViewInformation $viewInformation) {
	return getTableLifeSpanEditor($viewInformation->showRecordLifeSpan);
}

function addTableMetadataEditors($editor, ViewInformation $viewInformation) {
	$metadataEditors = getTableMetadataEditors($viewInformation);
	
	foreach ($metadataEditors as $metadataEditor)
		$editor->addEditor($metadataEditor);
}

function getDefinitionEditor(ViewInformation $viewInformation) {
	global
		$wgPopupAnnotationName, $definitionMeaningName;

	$o=OmegaWikiAttributes::getInstance();

	$editor = new RecordDivListEditor($o->definition);
	$editor->addEditor(getTranslatedTextEditor(
		$o->translatedText, 
		new DefinedMeaningDefinitionController(),
		new DefinedMeaningFilteredDefinitionController($viewInformation->filterLanguageId), 
		$viewInformation
	));
	
	foreach ($viewInformation->getPropertyToColumnFilters() as $propertyToColumnFilter) {
		$attribute = $propertyToColumnFilter->getAttribute();
		
		$editor->addEditor(new PopUpEditor(
			createDefinitionObjectAttributesEditor(
				$viewInformation, 
				$attribute, 
				$propertyToColumnFilter->getPropertyCaption(),
				$propertyToColumnFilter->getValueCaption(),
				$o->definedMeaningId, 
				$definitionMeaningName, 
				$propertyToColumnFilter->getAttributeIDFilter()
			),	
			$attribute->name
		));
	}
		
	$editor->addEditor(new PopUpEditor(
		createDefinitionObjectAttributesEditor($viewInformation, $o->objectAttributes, wfMsgSc("Property"), wfMsgSc("Value"), $o->definedMeaningId, $definitionMeaningName, $viewInformation->getLeftOverAttributeFilter()),	
		$wgPopupAnnotationName
	));

	return $editor;	
}

function createPropertyToColumnFilterEditors(ViewInformation $viewInformation, Attribute $idAttribute, $levelName) {
	$result = array();

	foreach ($viewInformation->getPropertyToColumnFilters() as $propertyToColumnFilter) {
		$result[] = createObjectAttributesEditor(
			$viewInformation, 
			$propertyToColumnFilter->getAttribute(), 
			$propertyToColumnFilter->getPropertyCaption(), 
			$propertyToColumnFilter->getValueCaption(), 
			$idAttribute, 
			$levelName, 
			$propertyToColumnFilter->getAttributeIDFilter()
		);	
	}
	
	return $result;
}

function addPropertyToColumnFilterEditors(Editor $editor, ViewInformation $viewInformation, Attribute $idAttribute, $levelName) {
	foreach (createPropertyToColumnFilterEditors($viewInformation, $idAttribute, $levelName) as $propertyToColumnEditor) {
		$attribute = $propertyToColumnEditor->getAttribute();
		$editor->addEditor(new PopUpEditor($propertyToColumnEditor, $attribute->name));
	}
}	

function getTranslatedTextEditor(Attribute $attribute, UpdateController $updateController, UpdateAttributeController $updateAttributeController, ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();	
	
	if ($viewInformation->filterLanguageId == 0 || $viewInformation->showRecordLifeSpan) {
		$editor = new RecordSetTableEditor($attribute, new SimplePermissionController(true), new ShowEditFieldChecker(true), new AllowAddController(true), true, true, $updateController);
		
		if ($viewInformation->filterLanguageId == 0)
			$editor->addEditor(new LanguageEditor($o->language, new SimplePermissionController(false), true));
			
		$editor->addEditor(new TextEditor($o->text, new SimplePermissionController(true), true));
		addTableMetadataEditors($editor, $viewInformation);
	}
	else 
		$editor = new TextEditor($attribute, new SimplePermissionController(true), true, false, 0, $updateAttributeController);

	return $editor;
}

function addObjectAttributesEditors(ObjectAttributeValuesEditor $objectAttributesEditor, ViewInformation $viewInformation, ContextFetcher $annotatedObjectIdFetcher) {
	$attributeIDFilter = $objectAttributesEditor->getAttributeIDfilter();
	$annotationLevelName = $objectAttributesEditor->getLevelName();
	
	$objectAttributesEditor->addEditor(getDefinedMeaningAttributeValuesEditor($viewInformation, new DefinedMeaningAttributeValuesController($annotatedObjectIdFetcher, $annotationLevelName, $attributeIDFilter), $annotationLevelName, $attributeIDFilter));
	$objectAttributesEditor->addEditor(getTextAttributeValuesEditor($viewInformation, new TextAttributeValuesController($annotatedObjectIdFetcher, $annotationLevelName, $attributeIDFilter), $annotationLevelName, $attributeIDFilter));
	$objectAttributesEditor->addEditor(getTranslatedTextAttributeValuesEditor($viewInformation, new TranslatedTextAttributeValuesController($annotatedObjectIdFetcher, $annotationLevelName, $attributeIDFilter, $viewInformation->filterLanguageId), $annotationLevelName, $attributeIDFilter));
	$objectAttributesEditor->addEditor(getLinkAttributeValuesEditor($viewInformation, new LinkAttributeValuesController($annotatedObjectIdFetcher, $annotationLevelName, $attributeIDFilter), $annotationLevelName, $attributeIDFilter));
	$objectAttributesEditor->addEditor(getOptionAttributeValuesEditor($viewInformation, new OptionAttributeValuesController($annotatedObjectIdFetcher, $annotationLevelName, $attributeIDFilter), $annotationLevelName, $attributeIDFilter));
}

function createObjectAttributesEditor(ViewInformation $viewInformation, Attribute $attribute, $propertyCaption, $valueCaption, Attribute $idAttribute, $levelName, AttributeIDFilter $attributeIDFilter) {
	$o=OmegaWikiAttributes::getInstance();
	
	$result = new ObjectAttributeValuesEditor($attribute, $propertyCaption, $valueCaption, $viewInformation, $levelName, $attributeIDFilter); 
	
	addObjectAttributesEditors(
		$result, 
		$viewInformation, 
		new ObjectIdFetcher(0, $idAttribute) 
	);
	
	return $result;
}

function createDefinitionObjectAttributesEditor(ViewInformation $viewInformation, Attribute $attribute, $propertyCaption, $valueCaption, Attribute $idAttribute, $levelName, AttributeIDFilter $attributeIDFilter) {
	$o=OmegaWikiAttributes::getInstance();
	
	$result = new ObjectAttributeValuesEditor($attribute, $propertyCaption, $valueCaption, $viewInformation, $levelName, $attributeIDFilter); 
	
	addObjectAttributesEditors(
		$result, 
		$viewInformation, 
		new DefinitionObjectIdFetcher(0, $idAttribute) 
	);
	
	return $result;
}

function getAlternativeDefinitionsEditor(ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();

	$editor = new RecordSetTableEditor(
		$o->alternativeDefinitions, 
		new SimplePermissionController(true), 
		new ShowEditFieldChecker(true), 
		new AllowAddController(true), 
		true, 
		false, 
		new DefinedMeaningAlternativeDefinitionsController($viewInformation->filterLanguageId)
	);
	
	$editor->addEditor(getTranslatedTextEditor(
		$o->alternativeDefinition, 
		new DefinedMeaningAlternativeDefinitionController(),
		new DefinedMeaningFilteredAlternativeDefinitionController($viewInformation), 
		$viewInformation)
	);
	$editor->addEditor(new DefinedMeaningReferenceEditor($o->source, new SimplePermissionController(false), true));
	
	addTableMetadataEditors($editor, $viewInformation);

	return $editor;
}

function getExpressionTableCellEditor(Attribute $attribute, ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();

	if ($viewInformation->filterLanguageId == 0) {
		$editor = new RecordTableCellEditor($attribute);
		$editor->addEditor(new LanguageEditor($o->language, new SimplePermissionController(false), true));
		$editor->addEditor(new SpellingEditor($o->spelling, new SimplePermissionController(false), true));
	}
	else	
		$editor = new SpellingEditor($attribute, new SimplePermissionController(false), true);
	
	return $editor;
}

function getClassAttributesEditor(ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();

	$tableEditor = new RecordSetTableEditor($o->classAttributes, new SimplePermissionController(true), new ShowEditFieldForClassesChecker(0, $o->definedMeaningId), new AllowAddController(true), true, false, new ClassAttributesController());
	$tableEditor->addEditor(new ClassAttributesLevelDefinedMeaningEditor($o->classAttributeLevel, new SimplePermissionController(false), true));
	$tableEditor->addEditor(new DefinedMeaningReferenceEditor($o->classAttributeAttribute, new SimplePermissionController(false), true));
	$tableEditor->addEditor(new ClassAttributesTypeEditor($o->classAttributeType, new SimplePermissionController(false), true));
	$tableEditor->addEditor(new PopupEditor(getOptionAttributeOptionsEditor(), 'Options'));

	addTableMetadataEditors($tableEditor, $viewInformation);
	
	return $tableEditor;
}

function getSynonymsAndTranslationsEditor(ViewInformation $viewInformation) {
	global
		$wgPopupAnnotationName, $synTransMeaningName;

	$o=OmegaWikiAttributes::getInstance();

	$tableEditor = new RecordSetTableEditor(
		$o->synonymsAndTranslations, 
		new SimplePermissionController(true), 
		new ShowEditFieldChecker(true), 
		new AllowAddController(true), 
		true, 
		false, 
		new SynonymTranslationController($viewInformation->filterLanguageId)
	);
	
	$tableEditor->addEditor(getExpressionTableCellEditor($o->expression, $viewInformation));
	$tableEditor->addEditor(new BooleanEditor($o->identicalMeaning, new SimplePermissionController(true), true, true));
	
	addPropertyToColumnFilterEditors($tableEditor, $viewInformation, $o->syntransId, $synTransMeaningName);
	
	$tableEditor->addEditor(new PopUpEditor(
		createObjectAttributesEditor($viewInformation, $o->objectAttributes, wfMsgSc("Property"), wfMsgSc("Value"), $o->syntransId, $synTransMeaningName, $viewInformation->getLeftOverAttributeFilter()), 
		$wgPopupAnnotationName
	));

	addTableMetadataEditors($tableEditor, $viewInformation);

	return $tableEditor;
}

function getDefinedMeaningAttributeValuesEditor(ViewInformation $viewInformation, UpdateController $controller, $levelDefinedMeaningName, AttributeIDFilter $attributeIDFilter) {
	global
		$definedMeaningValueObjectAttributesEditors;

	$o=OmegaWikiAttributes::getInstance();

	$showEditFieldChecker = new ShowEditFieldForAttributeValuesChecker($levelDefinedMeaningName, "DM", $attributeIDFilter);

	$editor = new RecordSetTableEditor($o->relations, new SimplePermissionController(true), $showEditFieldChecker, new AllowAddController(true), true, false, $controller);
	$editor->addEditor(new DefinedMeaningAttributeEditor($o->relationType, new SimplePermissionController(false), true, $attributeIDFilter, $levelDefinedMeaningName));
	$editor->addEditor(new DefinedMeaningReferenceEditor($o->otherDefinedMeaning, new SimplePermissionController(false), true));

	addPopupEditors($editor, $definedMeaningValueObjectAttributesEditors);
	addTableMetadataEditors($editor, $viewInformation);

	return $editor;
}

function getDefinedMeaningReciprocalRelationsEditor(ViewInformation $viewInformation) {
	global
		$relationsObjectAttributesEditor, $relationMeaningName, $wgPopupAnnotationName;

	$o=OmegaWikiAttributes::getInstance();

	$editor = new RecordSetTableEditor($o->reciprocalRelations, new SimplePermissionController(false), new ShowEditFieldChecker(true), new AllowAddController(false), false, false, null);
	$editor->addEditor(new DefinedMeaningReferenceEditor($o->otherDefinedMeaning, new SimplePermissionController(false), true));
	$editor->addEditor(new RelationTypeReferenceEditor($o->relationType, new SimplePermissionController(false), true));
	
	addPropertyToColumnFilterEditors($editor, $viewInformation, $o->relationId, $relationMeaningName);
	
	$editor->addEditor(new PopUpEditor(
		createObjectAttributesEditor($viewInformation, $o->objectAttributes, wfMsgSc("Property"), wfMsgSc("Value"), $o->relationId, $relationMeaningName, $viewInformation->getLeftOverAttributeFilter()), 
		$wgPopupAnnotationName
	));

	addTableMetadataEditors($editor, $viewInformation);

	return $editor;
}

function getDefinedMeaningClassMembershipEditor(ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();

	$editor = new RecordSetTableEditor($o->classMembership, new SimplePermissionController(true), new ShowEditFieldChecker(true), new AllowAddController(true), true, false, new DefinedMeaningClassMembershipController());
	$editor->addEditor(new ClassReferenceEditor($o->class, new SimplePermissionController(false), true));

	addTableMetadataEditors($editor, $viewInformation);

	return $editor;
}

function getDefinedMeaningCollectionMembershipEditor(ViewInformation $viewInformation) {
	global
		 $wgGotoSourceTemplates;

	$o=OmegaWikiAttributes::getInstance();

	$editor = new RecordSetTableEditor($o->collectionMembership, new SimplePermissionController(true), new ShowEditFieldChecker(true), new AllowAddController(true), true, false, new DefinedMeaningCollectionController());
	$editor->addEditor(new CollectionReferenceEditor($o->collectionMeaning, new SimplePermissionController(false), true));
	$editor->addEditor(new ShortTextEditor($o->sourceIdentifier, new SimplePermissionController(false), true));
	
	if (count($wgGotoSourceTemplates) > 0)
		$editor->addEditor(new GotoSourceEditor($o->gotoSource, new SimplePermissionController(true), true));

	addTableMetadataEditors($editor, $viewInformation);

	return $editor;
}

function addPopupEditors(Editor $editor, array &$columnEditors) {
	foreach ($columnEditors as $columnEditor)
		$editor->addEditor(new PopUpEditor($columnEditor, $columnEditor->getAttribute()->name));
}

function getTextAttributeValuesEditor(ViewInformation $viewInformation, UpdateController $controller, $levelDefinedMeaningName, AttributeIDFilter $attributeIDFilter) {
	global
		$textValueObjectAttributesEditors;

	$o=OmegaWikiAttributes::getInstance();

	$showEditFieldChecker = new ShowEditFieldForAttributeValuesChecker($levelDefinedMeaningName, "TEXT", $attributeIDFilter);

	$editor = new RecordSetTableEditor($o->textAttributeValues, new SimplePermissionController(true), $showEditFieldChecker, new AllowAddController(true), true, false, $controller);
	$editor->addEditor(new TextAttributeEditor($o->textAttribute, new SimplePermissionController(false), true, $attributeIDFilter, $levelDefinedMeaningName));
	$editor->addEditor(new TextEditor($o->text, new SimplePermissionController(true), true));
	
	addPopupEditors($editor, $textValueObjectAttributesEditors);
	addTableMetadataEditors($editor, $viewInformation);

	return $editor;
}

function getLinkAttributeValuesEditor(ViewInformation $viewInformation, UpdateController $controller, $levelDefinedMeaningName, AttributeIDFilter $attributeIDFilter) {
	global
		$linkValueObjectAttributesEditors;

	$o=OmegaWikiAttributes::getInstance();

	$showEditFieldChecker = new ShowEditFieldForAttributeValuesChecker($levelDefinedMeaningName, "URL", $attributeIDFilter);

	$editor = new RecordSetTableEditor($o->linkAttributeValues, new SimplePermissionController(true), $showEditFieldChecker, new AllowAddController(true), true, false, $controller);
	$editor->addEditor(new LinkAttributeEditor($o->linkAttribute, new SimplePermissionController(false), true, $attributeIDFilter, $levelDefinedMeaningName));
	
	if ($viewInformation->viewOrEdit == "view")
		$linkEditor = new LinkEditor($o->link, new SimplePermissionController(true), true);
	else {
		$linkEditor = new RecordTableCellEditor($o->link);
		$linkEditor->addEditor(new ShortTextEditor($o->linkURL, new SimplePermissionController(true), true, "urlFieldChanged(this);"));
		$linkEditor->addEditor(new ShortTextEditor($o->linkLabel, new SimplePermissionController(true), true));
	}	
		
	$editor->addEditor($linkEditor);

	addPopupEditors($editor, $linkValueObjectAttributesEditors);
	addTableMetadataEditors($editor, $viewInformation);

	return $editor;
}

function getTranslatedTextAttributeValuesEditor(ViewInformation $viewInformation, UpdateController $controller, $levelDefinedMeaningName, AttributeIDFilter $attributeIDFilter) {
	global
		$translatedTextValueObjectAttributesEditors;

	$o=OmegaWikiAttributes::getInstance();

	$showEditFieldChecker = new ShowEditFieldForAttributeValuesChecker($levelDefinedMeaningName, "TRNS", $attributeIDFilter);

	$editor = new RecordSetTableEditor($o->translatedTextAttributeValues, new SimplePermissionController(true), $showEditFieldChecker, new AllowAddController(true), true, false, $controller);
	$editor->addEditor(new TranslatedTextAttributeEditor($o->translatedTextAttribute, new SimplePermissionController(false), true, $attributeIDFilter, $levelDefinedMeaningName));
	$editor->addEditor(getTranslatedTextEditor(
		$o->translatedTextValue, 
		new TranslatedTextAttributeValueController(),
		new FilteredTranslatedTextAttributeValueController($viewInformation->filterLanguageId), 
		$viewInformation
	));
	
	addPopupEditors($editor, $translatedTextValueObjectAttributesEditors);
	addTableMetadataEditors($editor, $viewInformation);

	return $editor;
}

function getOptionAttributeValuesEditor(ViewInformation $viewInformation, UpdateController $controller, $levelDefinedMeaningName, AttributeIDFilter $attributeIDFilter) {
	global
		$optionValueObjectAttributesEditors;

	$o=OmegaWikiAttributes::getInstance();

	$showEditFieldChecker = new ShowEditFieldForAttributeValuesChecker($levelDefinedMeaningName, "OPTN", $attributeIDFilter);
	
	$editor = new RecordSetTableEditor($o->optionAttributeValues, new SimplePermissionController(true), $showEditFieldChecker, new AllowAddController(true), true, false, $controller);
	$editor->addEditor(new OptionAttributeEditor($o->optionAttribute, new SimplePermissionController(false), true, $attributeIDFilter, $levelDefinedMeaningName));
	$editor->addEditor(new OptionSelectEditor($o->optionAttributeOption, new SimplePermissionController(false), true));
	
	addPopupEditors($editor, $optionValueObjectAttributesEditors);
	addTableMetadataEditors($editor, $viewInformation);

	return $editor;
}

function getOptionAttributeOptionsEditor() {
	$o=OmegaWikiAttributes::getInstance();

	$editor = new RecordSetTableEditor($o->optionAttributeOptions, new SimplePermissionController(true), new ShowEditFieldChecker(true), new AllowAddController(true), true, false, new OptionAttributeOptionsController());
	$editor->addEditor(new DefinedMeaningReferenceEditor($o->optionAttributeOption, new SimplePermissionController(false), true)); 
	$editor->addEditor(new LanguageEditor($o->language, new SimplePermissionController(false), true));

	return $editor;
}

function getExpressionMeaningsEditor(Attribute $attribute, $allowAdd, ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();
	
	$definedMeaningEditor = getDefinedMeaningEditor($viewInformation);

	$definedMeaningCaptionEditor = new DefinedMeaningHeaderEditor($o->definedMeaningId, new SimplePermissionController(false), true, 75);
	$definedMeaningCaptionEditor->setAddText("New exact meaning");

	$expressionMeaningsEditor = new RecordSetListEditor($attribute, new SimplePermissionController(true), new ShowEditFieldChecker(true), new AllowAddController($allowAdd), false, $allowAdd, new ExpressionMeaningController($viewInformation->filterLanguageId), 3, false);
	$expressionMeaningsEditor->setCaptionEditor($definedMeaningCaptionEditor);
	$expressionMeaningsEditor->setValueEditor($definedMeaningEditor);
	
	return $expressionMeaningsEditor;
}

function getExpressionsEditor($spelling, ViewInformation $viewInformation) {
	$o=OmegaWikiAttributes::getInstance();

	$expressionMeaningsRecordEditor = new RecordUnorderedListEditor($o->expressionMeanings, 3);
	
	$exactMeaningsEditor = getExpressionMeaningsEditor($o->expressionExactMeanings, true, $viewInformation);
	$expressionMeaningsRecordEditor->addEditor($exactMeaningsEditor);
	$expressionMeaningsRecordEditor->addEditor(getExpressionMeaningsEditor($o->expressionApproximateMeanings, false, $viewInformation));
	
	$expressionMeaningsRecordEditor->expandEditor($exactMeaningsEditor);
	
	if ($viewInformation->filterLanguageId == 0) {
		$expressionEditor = new RecordSpanEditor($o->expression, ': ', ' - ');
		$expressionEditor->addEditor(new LanguageEditor($o->language, new SimplePermissionController(false), true));

		$expressionsEditor = new RecordSetListEditor(
			$o->expressions, 
			new SimplePermissionController(true), 
			new ShowEditFieldChecker(true), 
			new AllowAddController(true), 
			false, 
			false, 
			new ExpressionController($spelling, $viewInformation->filterLanguageId), 
			2, 
			true
		);
		$expressionsEditor->setCaptionEditor($expressionEditor);
		$expressionsEditor->setValueEditor($expressionMeaningsRecordEditor);
	}
	else {
		$expressionEditor = new RecordSubRecordEditor($o->expression);
		$expressionEditor->setSubRecordEditor($expressionMeaningsRecordEditor);
		
		$expressionsEditor = new RecordSetFirstRecordEditor(
			$o->expressions, 
			new SimplePermissionController(true), 
			new ShowEditFieldChecker(true), 
			new AllowAddController(true), 
			false, 
			false, 
			new ExpressionController($spelling, $viewInformation->filterLanguageId)
		);
		$expressionsEditor->setRecordEditor($expressionEditor);
	}

	return $expressionsEditor;
}

function getDefinedMeaningEditor(ViewInformation $viewInformation) {
	global
		$wdDefinedMeaningAttributesOrder,  $definedMeaningMeaningName,
		$relationMeaningName;
		
	$o=OmegaWikiAttributes::getInstance();
	
	$definitionEditor = getDefinitionEditor($viewInformation);
	$alternativeDefinitionsEditor = getAlternativeDefinitionsEditor($viewInformation);
	$classAttributesEditor = getClassAttributesEditor($viewInformation);		
	$synonymsAndTranslationsEditor = getSynonymsAndTranslationsEditor($viewInformation);
	$reciprocalRelationsEditor = getDefinedMeaningReciprocalRelationsEditor($viewInformation);
	$classMembershipEditor = getDefinedMeaningClassMembershipEditor($viewInformation);
	$collectionMembershipEditor = getDefinedMeaningCollectionMembershipEditor($viewInformation);
	
	$availableEditors = new AttributeEditorMap();
	$availableEditors->addEditor($definitionEditor);
	$availableEditors->addEditor($alternativeDefinitionsEditor);
	$availableEditors->addEditor($classAttributesEditor);
	$availableEditors->addEditor($synonymsAndTranslationsEditor);
	$availableEditors->addEditor($reciprocalRelationsEditor);
	$availableEditors->addEditor($classMembershipEditor);
	$availableEditors->addEditor($collectionMembershipEditor);

	foreach (createPropertyToColumnFilterEditors($viewInformation, $o->definedMeaningId, $definedMeaningMeaningName) as $propertyToColumnEditor) 	
		$availableEditors->addEditor($propertyToColumnEditor);
	
	$availableEditors->addEditor(createObjectAttributesEditor($viewInformation, $o->definedMeaningAttributes, wfMsgSc("Property"), wfMsgSc("Value"), $o->definedMeaningId, $definedMeaningMeaningName, $viewInformation->getLeftOverAttributeFilter()));

	$definedMeaningEditor = new RecordUnorderedListEditor($o->definedMeaning, 4);
	
	foreach ($wdDefinedMeaningAttributesOrder as $attributeId) {
		$editor = $availableEditors->getEditorForAttributeId($attributeId);
		
		if ($editor != null)
			$definedMeaningEditor->addEditor($editor);
	}

	$definedMeaningEditor->expandEditor($definitionEditor);
	$definedMeaningEditor->expandEditor($synonymsAndTranslationsEditor);
	
	return new DefinedMeaningContextEditor($definedMeaningEditor);
}

function createTableViewer($attribute) {
	return new RecordSetTableEditor(
		$attribute, 
		new SimplePermissionController(false), 
		new ShowEditFieldChecker(true), 
		new AllowAddController(false), 
		false, 
		false, 
		null
	);
}

function createLanguageViewer($attribute) {
	return new LanguageEditor($attribute, new SimplePermissionController(false), false);
}

function createLongTextViewer($attribute) {
	$result = new TextEditor($attribute, new SimplePermissionController(false), false);
	
	return $result;
}

function createShortTextViewer($attribute) {
	return new ShortTextEditor($attribute, new SimplePermissionController(false), false);
}

function createLinkViewer($attribute) {
	return new LinkEditor($attribute, new SimplePermissionController(false), false);
}

function createBooleanViewer($attribute) {
	return new BooleanEditor($attribute, new SimplePermissionController(false), false, false);
}

function createDefinedMeaningReferenceViewer($attribute) {
	return new DefinedMeaningReferenceEditor($attribute, new SimplePermissionController(false), false);
}

function createSuggestionsTableViewer($attribute) {
	$result = createTableViewer($attribute);
	$result->setHideEmptyColumns(false);
	$result->setRowHTMLAttributes(array(
		"class" => "suggestion-row",
		"onclick" => "suggestRowClicked(event, this)",
		"onmouseover" => "mouseOverRow(this)",
		"onmouseout" => "mouseOutRow(this)"
	));
	
	return $result;
}

function createUserViewer($attribute) {
	return new UserEditor($attribute, new SimplePermissionController(false), false);
}

function createTranslatedTextViewer($attribute) {
	
	$o=OmegaWikiAttributes::getInstance();

	$result = createTableViewer($attribute);
	$result->addEditor(createLanguageViewer($o->language));
	$result->addEditor(createLongTextViewer($o->text));
	
	return $result;
}

?>

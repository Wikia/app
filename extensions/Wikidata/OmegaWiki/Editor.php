<?php

require_once("HTMLtable.php");
require_once("Controller.php");
require_once("type.php");
require_once("GotoSourceTemplate.php");
require_once("Wikidata.php");
require_once("ContextFetcher.php");

function addCollapsablePrefixToClass($class) {
	return "collapsable-$class";
}


# End of line string for readable HTML, set to "\n" for testing
define('EOL',"\n"); # Makes human (and vim :-p) readable output (somewhat...)
#define('EOL',""); # Output only readable by browsers

/**
 * Class IdStack is used to keep track of context during the rendering of
 * a hierarchical structure of Records and RecordSets. The name IdStack might
 * not be accurate anymore and might be renamed to something else like RenderContext.
 */

class IdStack {
	protected $keyStack;
	protected $idStack = array();
	protected $currentId;
	protected $classStack = array();
	protected $currentClass;
	protected $definedMeaningIdStack = array(); 	// Used to keep track of which defined meaning is being rendered
	protected $annotationAttributeStack = array();	// Used to keep track of which annotation attribute currently is being rendered
	protected $classAttributesStack = array();		// Used to keep track of the class attributes that are currently in effect
	
	public function __construct($prefix) {
	 	$this->keyStack = new RecordStack();
	 	$this->currentId = $prefix;
	 	$this->currentClass = $prefix;
	}

	protected function getKeyIds(Record $record) {
		$ids = array();

		foreach($record->getStructure()->getAttributes() as $attribute)
			$ids[] = $record->getAttributeValue($attribute);

		return $ids;
	}

	protected function pushId($id) {
		$this->idStack[] = $this->currentId;
		$this->currentId .= '-' . $id;
	}

	protected function popId() {
		$this->currentId = array_pop($this->idStack);
	}

	protected function pushClass($class) {
		$this->classStack[] = $this->currentClass;
		$this->currentClass .= '-' . $class;
	}

	protected function popClass() {
		$this->currentClass = array_pop($this->classStack);
	}

	public function pushKey(Record $record) {
		$this->keyStack->push($record);
		$this->pushId(implode("-", $this->getKeyIds($record)));
	}

	public function pushAttribute(Attribute $attribute) {
		# FIXME: check attribute id existence
		@$id=$attribute->id;
		$this->pushId($id);
		$this->pushClass($id);
	}

	public function popKey() {
		$this->popId();
		return $this->keyStack->pop();
	}

	public function popAttribute() {
		$this->popId();
		$this->popClass();
	}

	public function getId() {
		return $this->currentId;
	}

	public function getClass() {
		return $this->currentClass;
	}

	public function getKeyStack() {
		return $this->keyStack;
	}
	
	public function pushDefinedMeaningId($definedMeaningId) {
		$this->definedMeaningIdStack[] = $definedMeaningId;
	}
	
	public function popDefinedMeaningId() {
		return array_pop($this->definedMeaningIdStack);
	}
	
	public function getDefinedMeaningId() {
		$stackSize = count($this->definedMeaningIdStack);
		
		if ($stackSize > 0)
			return $this->definedMeaningIdStack[$stackSize - 1];
		else
			throw new Exception("There is no defined meaning defined in the current context");
	}

	public function pushAnnotationAttribute(Attribute $annotationAttribute) {
		$this->annotationAttributeStack[] = $annotationAttribute;
	}
	
	public function popAnnotationAttribute() {
		return array_pop($this->annotationAttributeStack);
	}
	
	public function getAnnotationAttribute() {
		$stackSize = count($this->annotationAttributeStack);
		
		if ($stackSize > 0)
			return $this->annotationAttributeStack[$stackSize - 1];
		else
			throw new Exception("There is no annotation attribute in the current context");
	}

	public function pushClassAttributes(ClassAttributes $classAttributes) {
		$this->classAttributesStack[] = $classAttributes;
	}
	
	public function popClassAttributes() {
		return array_pop($this->classAttributesStack);
	}
	
	public function getClassAttributes() {
		$stackSize = count($this->classAttributesStack);
		
		if ($stackSize > 0)
			return $this->classAttributesStack[$stackSize - 1];
		else
			throw new Exception("There are no class attributes in the current context");
	}

	public function __tostring() {
		return "<object of class IdStack>";
	}
}

//added the "allow add controller" to be able to control the usage of the add field in different circumstances
//instances of this class are used instead of the boolean "allowAdd" in the editors
class AllowAddController {
	protected $value;
	
	public function __construct($value){
		$this->value = $value;
	}
	public function check($idPath){
		return $this->value;
	}
}

class ShowEditFieldChecker {
	protected $value;
	
	public function __construct($value) {
		$this->value = $value;
	}
	
	public function check(IdStack $idPath) {
		return $this->value;
	}
}

class ShowEditFieldForClassesChecker extends ShowEditFieldChecker{
	protected $objectIdAttributeLevel;
	protected $objectIdAttribute;
	
	public function __construct($objectIdAttributeLevel, Attribute $objectIdAttribute) {
		$this->objectIdAttributeLevel = $objectIdAttributeLevel;
		$this->objectIdAttribute = $objectIdAttribute;
	}
	
	public function check(IdStack $idPath) {
		$objectId = $idPath->getKeyStack()->peek($this->objectIdAttributeLevel)->getAttributeValue($this->objectIdAttribute);
		return isClass($objectId);			
	}	
}

interface Editor {
	public function getAttribute();
	public function getUpdateAttribute();
	public function getAddAttribute();

	public function showsData($value);
	public function view(IdStack $idPath, $value);
	public function showEditField(IdStack $idPath);
	public function edit(IdStack $idPath, $value);
	public function add(IdStack $idPath);
	public function save(IdStack $idPath, $value);

	public function getUpdateValue(IdStack $idPath);
	public function getAddValue(IdStack $idPath);

	public function getEditors();
	public function getAttributeEditorMap();
}

class AttributeEditorMap {
	protected $attributeEditorMap = array();
	
	public function addEditor($editor) {
		$attributeId = $editor->getAttribute()->id;
		$this->attributeEditorMap[$attributeId] = $editor;
	}
	
	public function getEditorForAttributeId($attributeId) {
		if (isset($this->attributeEditorMap[$attributeId]))
			return $this->attributeEditorMap[$attributeId];
		else
			return null;
	}
	
	public function getEditorForAttribute(Attribute $attribute) {
		return $this->getEditorForAttributeId($attribute->id);
	}
}

/* XXX: Basic Editor class. */
abstract class DefaultEditor implements Editor {
	protected $editors;
	protected $attributeEditorMap;
	protected $attribute;

	public function __construct(Attribute $attribute = null) {
		$this->attribute = $attribute;
		$this->editors = array();
		$this->attributeEditorMap = new AttributeEditorMap();
	}

	public function addEditor(Editor $editor) {
		$this->editors[] = $editor;
		$this->attributeEditorMap->addEditor($editor);
	}

	public function getAttribute() {
		return $this->attribute;
	}

	public function getEditors() {
		return $this->editors;
	}
	
	public function getAttributeEditorMap() {
		return $this->attributeEditorMap;
	}

	public function getExpansionPrefix($class, $elementId) {
		return '<span id="prefix-collapsed-' . $elementId . '" class="collapse-' . $class . '">+</span><span id="prefix-expanded-' . $elementId . '" class="expand-' . $class . '">&ndash;</span>' . EOL;
	}

	static private $staticExpansionStyles = array();

	protected function setExpansion($expand, $elementType) {
		$expansionStyles =& DefaultEditor::$staticExpansionStyles;
		if ($expand) {
			$expansionStyles[".collapse-" . $elementType] = "display:none;";
			$expansionStyles[".expand-" . $elementType] = "display:inline;";
		} else {
			$expansionStyles[".collapse-" . $elementType] = "display:inline;";
			$expansionStyles[".expand-" . $elementType] = "display:none;";
		}
	}

	public static function getExpansionCss() {
		$s = "<style type='text/css'>" . EOL;
		$s .= "/*/*/ /*<![CDATA[*/". EOL; # <-- Hide the styles from Netscape 4 without hiding them from IE/Mac
		foreach(DefaultEditor::$staticExpansionStyles as $expansionStyleName => $expansionStyleValue)
			$s .= $expansionStyleName . " {" . $expansionStyleValue . "}" . EOL;
		$s .= "/*]]>*/ /* */".EOL;
		$s .= "</style>".EOL;
		return $s;
	}
}

abstract class Viewer extends DefaultEditor {
	public function getUpdateAttribute() {
		return null;
	}

	public function getAddAttribute() {
		return null;
	}

	public function edit(IdStack $idPath, $value) {
		return $this->view($idPath, $value);
	}

	public function add(IdStack $idPath) {
		return "";		
	}

	public function save(IdStack $idPath, $value) {
	}

	public function getUpdateValue(IdStack $idPath) {
		return null;
	}

	public function getAddValue(IdStack $idPath) {
		return null;
	}

	public function showEditField(IdStack $idPath) {
		return true;
	}
}

abstract class RecordSetEditor extends DefaultEditor {
	protected $permissionController;
	protected $showEditFieldChecker;
	protected $allowAddController;
	protected $allowRemove;
	protected $isAddField;
	protected $controller;

	public function __construct(Attribute $attribute = null, PermissionController $permissionController, ShowEditFieldChecker $showEditFieldChecker, AllowAddController $allowAddController, $allowRemove, $isAddField, UpdateController $controller = null) {
		parent::__construct($attribute);

		$this->permissionController = $permissionController;
		$this->showEditFieldChecker = $showEditFieldChecker;
		$this->allowAddController = $allowAddController;
		$this->allowRemove = $allowRemove;
		$this->isAddField = $isAddField;
		$this->controller = $controller;
	}

	public function getAddValue(IdStack $idPath) {
		$addStructure = $this->getAddStructure();

		if (count($addStructure->getAttributes()) > 0) {
			$relation = new ArrayRecordSet($addStructure, $addStructure);  // TODO Determine real key
			$values = array();

			foreach($this->getEditors() as $editor)
				if ($attribute = $editor->getAddAttribute()) {
					$idPath->pushAttribute($attribute);
					$values[] = $editor->getAddValue($idPath);
					$idPath->popAttribute();
				}

			$relation->addRecord($values);

			return $relation;
		}
		else
			return null;
	}

	protected function saveRecord(IdStack $idPath, Record $record) {
		foreach($this->getEditors() as $editor) {
			$attribute = $editor->getAttribute();
			$value = $record->getAttributeValue($attribute);
			$idPath->pushAttribute($attribute);
			$editor->save($idPath, $value);
			$idPath->popAttribute();
		}
	}

	protected function updateRecord(IdStack $idPath, Record $record, Structure $structure, $editors) {
		if (count($editors) > 0) {
			$updateRecord = $this->getUpdateRecord($idPath, $structure, $editors);

			if (!equalRecords($structure, $record, $updateRecord))
				$this->controller->update($idPath->getKeyStack(), $updateRecord);
		}
	}

	protected function removeRecord(IdStack $idPath) {
		global
			$wgRequest;

		if ($wgRequest->getCheck('remove-'. $idPath->getId())) {
			$this->controller->remove($idPath->getKeyStack());
			return true;
		}
		else
			return false;
	}

	public function getStructure() {
		$attributes = array();

		foreach($this->getEditors() as $editor)
			$attributes[] = $editor->getAttribute();

		return new Structure($attributes);
	}

	public function getUpdateValue(IdStack $idPath) {
		return null;
	}

	protected function getUpdateStructure() {
		$attributes = array();

		foreach($this->getEditors() as $editor)
			if ($updateAttribute = $editor->getUpdateAttribute())
				$attributes[] = $updateAttribute;

		return new Structure($attributes);
	}

	protected function getAddStructure() {
		$attributes = array();

		foreach($this->getEditors() as $editor)
			if ($addAttribute = $editor->getAddAttribute())
				$attributes[] = $addAttribute;

		return new Structure($attributes);
	}

	protected function getUpdateEditors() {
		$updateEditors = array();

		foreach($this->getEditors() as $editor)
			if ($editor->getUpdateAttribute())
				$updateEditors[] = $editor;

		return $updateEditors;
	}

	protected function getAddEditors() {
		$addEditors = array();

		foreach($this->getEditors() as $editor)
			if ($editor->getAddAttribute())
				$addEditors[] = $editor;

		return $addEditors;
	}

	public function getAddRecord(IdStack $idPath, Structure $structure, $editors) {
		$result = new ArrayRecord($structure);

		foreach($editors as $editor)
			if ($attribute = $editor->getAddAttribute()) {
				$idPath->pushAttribute($attribute);
				$result->setAttributeValue($attribute, $editor->getAddValue($idPath));
				$idPath->popAttribute();
			}

		return $result;
	}

	public function getUpdateRecord(IdStack $idPath, Structure $structure, $editors) {
		$result = new ArrayRecord($structure);

		foreach($editors as $editor)
			if ($attribute = $editor->getUpdateAttribute()) {
				$idPath->pushAttribute($attribute);
				$result->setAttributeValue($attribute, $editor->getUpdateValue($idPath));
				$idPath->popAttribute();
			}

		return $result;
	}

	public function save(IdStack $idPath, $value) {
		if ($this->allowAddController->check($idPath) && $this->controller != null) {
			$addStructure = $this->getAddStructure();

			if (count($addStructure->getAttributes()) > 0) {
				$addEditors = $this->getAddEditors();
				$record = $this->getAddRecord($idPath, $addStructure, $addEditors);
				$this->controller->add($idPath, $record);
			}
		}

		$recordCount = $value->getRecordCount();
		$key = $value->getKey();
		$updateStructure = $this->getUpdateStructure();
		$updateEditors = $this->getUpdateEditors();

		for ($i = 0; $i < $recordCount; $i++) {
			$record = $value->getRecord($i);
			$idPath->pushKey(project($record, $key));

			if (!$this->allowRemove || !$this->removeRecord($idPath)) {
				$this->saveRecord($idPath, $record);
				$this->updateRecord($idPath, $record, $updateStructure, $updateEditors);
			}

			$idPath->popKey();
		}
	}

	public function getUpdateAttribute() {
		return null;
	}

	public function getAddAttribute() {
		$result = null;

		if ($this->isAddField) {
			$addStructure = $this->getAddStructure();

			if (count($addStructure->getAttributes()) > 0)
				$result = new Attribute($this->attribute->id, $this->attribute->name, $addStructure);
		}

		return $result;
	}
	
	public function showsData($value) {
		return $value->getRecordCount() > 0;
	}
	
	public function showEditField(IdStack $idPath) {
		return $this->showEditFieldChecker->check($idPath);
	}
}

class RecordSetTableEditor extends RecordSetEditor {
	protected $rowHTMLAttributes = array();
	protected $repeatInput = false;
	protected $hideEmptyColumns = true;
	
	protected function getRowAttributesText() {
		$result = array();
		
		foreach ($this->rowHTMLAttributes as $name => $value) 
			$result[] = $name . '="' . $value . '"';
		
		return implode(' ', $result);
	}
	
	public function setRowHTMLAttributes($rowHTMLAttributes) {
		$this->rowHTMLAttributes = $rowHTMLAttributes;
	}
	
	protected function columnShowsData(Editor $columnEditor, RecordSet $value, $attributePath) {
		$result = false;
		$recordCount = $value->getRecordCount();
		$i = 0;
		
		while (!$result && $i < $recordCount) {
			$recordOrScalar = $value->getRecord($i);
			
			foreach ($attributePath as $attribute)
				$recordOrScalar = $recordOrScalar->getAttributeValue($attribute);
				
			$result = $columnEditor->showsData($recordOrScalar); 						
			$i++;
		}
		
		return $result;
	}
	
	public function getTableStructure(Editor $editor) {
		$attributes = array();

		foreach($editor->getEditors() as $childEditor) {
			$childAttribute = $childEditor->getAttribute();

			if ($childEditor instanceof RecordTableCellEditor)
				$type = $this->getTableStructure($childEditor);
			else
				$type = 'short-text';

			$attributes[] = new Attribute($childAttribute->id, $childAttribute->name, $type);
		}

		return new Structure($attributes);
	}
	
	protected function getTableStructureShowingData($viewOrEdit, Editor $editor, IdStack $idPath, RecordSet $value, $attributePath = array()) {
		$attributes = array();

		foreach ($editor->getEditors() as $childEditor) {
			$childAttribute = $childEditor->getAttribute();
			array_push($attributePath, $childAttribute);

			if ($childEditor instanceof RecordTableCellEditor) {
				$type = $this->getTableStructureShowingData($viewOrEdit, $childEditor, $idPath, $value, $attributePath);
				
				if (count($type->getAttributes()) > 0)
					$attributes[] = new Attribute($childAttribute->id, $childAttribute->name, $type);
			}
			else if (($viewOrEdit == "view" && $this->columnShowsData($childEditor, $value, $attributePath)) ||
					 ($viewOrEdit == "edit") && $childEditor->showEditField($idPath))
				$attributes[] = new Attribute($childAttribute->id, $childAttribute->name, 'short-text');
				
			array_pop($attributePath);
		}

		return new Structure($attributes);
	}

	public function viewHeader(IdStack $idPath, Structure $visibleStructure) {
		$result = '<table id="'. $idPath->getId() .'" class="wiki-data-table">';

		foreach (getStructureAsTableHeaderRows($visibleStructure, 0, $idPath) as $headerRow)
			$result .= '<tr>' . $headerRow . '</tr>'.EOL;
			
		return $result;
	}
	
	public function viewRows(IdStack $idPath, RecordSet $value, Structure $visibleStructure) {
		$result = "";
		$rowAttributes = $this->getRowAttributesText();
		$key = $value->getKey();
		$recordCount = $value->getRecordCount();

		for ($i = 0; $i < $recordCount; $i++) {
			$record = $value->getRecord($i);
			$idPath->pushKey(project($record, $key));
			$result .= 
				'<tr id="'. $idPath->getId() .'" '.  $rowAttributes . '>' . 
					getRecordAsTableCells($idPath, $this, $visibleStructure, $record) .
				'</tr>'.EOL;
				
			$idPath->popKey();
		}
		
		return $result;
	}
	
	public function viewFooter(IdStack $idPath, Structure $visibleStructure) {
		return '</table>' . EOL;
	}
	
	public function getTableStructureForView(IdStack $idPath, RecordSet $value) {
		if ($this->hideEmptyColumns)
			return $this->getTableStructureShowingData("view", $this, $idPath, $value);
		else	
			return $this->getTableStructure($this);		
	}
	
	public function getTableStructureForEdit(IdStack $idPath, RecordSet $value) {
		return $this->getTableStructureShowingData("edit", $this, $idPath, $value);
	}

	public function view(IdStack $idPath, $value) {
		$visibleStructure = $this->getTableStructureForView($idPath, $value);
		
		$result = 
			$this->viewHeader($idPath, $visibleStructure) .
			$this->viewRows($idPath, $value, $visibleStructure) .
			$this->viewFooter($idPath, $visibleStructure);

		return $result;
	}

	public function edit(IdStack $idPath, $value) {
		global
			$wgStylePath;

		$result = '<table id="'. $idPath->getId() .'" class="wiki-data-table">';
		$key = $value->getKey();
		$rowAttributes = $this->getRowAttributesText();
		$visibleStructure = $this->getTableStructureForEdit($idPath, $value);
		
		$columnOffset = $this->allowRemove ? 1 : 0;
		$headerRows = getStructureAsTableHeaderRows($visibleStructure, $columnOffset, $idPath);

		if ($this->allowRemove)
			$headerRows[0] = '<th class="remove" rowspan="' . count($headerRows) . '"><img src="'.$wgStylePath.'/amethyst/delete.png" title="Mark rows to remove" alt="Remove"/></th>' . $headerRows[0];

		if ($this->repeatInput)
			$headerRows[0] .= '<th class="add" rowspan="' . count($headerRows) . '">Input rows</th>';

		foreach ($headerRows as $headerRow)
			$result .= '<tr id="'. $idPath->getId() .'" '.  $rowAttributes . '>' . $headerRow . '</tr>' . EOL;

		$recordCount = $value->getRecordCount();

		for ($i = 0; $i < $recordCount; $i++) {
			$result .= '<tr>';
			$record = $value->getRecord($i);
			$idPath->pushKey(project($record, $key));

			if ($this->allowRemove) {
				$result .= '<td class="remove">';
				
				if ($this->permissionController->allowRemovalOfValue($idPath, $record))
				 	$result .= getRemoveCheckBox('remove-'. $idPath->getId());
				 	
				$result .= '</td>'. EOL;
			}
			
			if ($this->permissionController->allowUpdateOfValue($idPath, $record))
				$result .= getRecordAsEditTableCells($idPath, $this, $visibleStructure, $record);
			else
				$result .= getRecordAsTableCells($idPath, $this, $visibleStructure, $record);
			
			$idPath->popKey();

			if ($this->repeatInput)
				$result .= '<td/>'.EOL;

			$result .= '</tr>'.EOL;
		}
		
		if ($this->allowAddController->check($idPath))
			$result .= $this->getAddRowAsHTML($idPath, $this->repeatInput, $this->allowRemove);

		$result .= '</table>'.EOL;

		return $result;
	}

	public function add(IdStack $idPath) {
		if ($this->isAddField) {
			$result = '<table id="'. $idPath->getId() .'" class="wiki-data-table">';
			$headerRows = getStructureAsTableHeaderRows($this->getAddStructure(), 0, $idPath);

	//		if ($repeatInput)
	//			$headerRows[0] .= '<th class="add" rowspan="' . count($headerRows) . '">Input rows</th>';

			foreach ($headerRows as $headerRow)
				$result .= '<tr>' . $headerRow . '</tr>' . EOL;

			$result .= $this->getAddRowAsHTML($idPath, false, false);
			$result .= '</table>' . EOL;

			return $result;
		}
		else
			return "";
	}

	function getStructureAsAddCells(IdStack $idPath, Editor $editor, &$startColumn = 0) {
		$result = '';
		
		foreach($editor->getEditors() as $childEditor) {
			$attribute = $childEditor->getAttribute();
			$type = $attribute->type;
			$idPath->pushAttribute($attribute);
			
			if ($childEditor instanceof RecordTableCellEditor)
				$result .= $this->getStructureAsAddCells($idPath, $childEditor, $startColumn);
			else {
				if ($childEditor->showEditField($idPath))
					$result .= '<td class="'. getHTMLClassForType($type,$attribute) .' column-'. parityClass($startColumn) . '">' . $childEditor->add($idPath) . '</td>';
					
				$startColumn++;
			}
			
			$idPath->popAttribute();
		}
		
		return $result;
	}
	
	function getAddRowAsHTML(IdStack $idPath, $repeatInput, $allowRemove) {
		global
			$wgScriptPath;
		
		if ($repeatInput)
			$rowClass = 'repeat';
		else
			$rowClass = '';

		$result = '<tr id="add-'. $idPath->getId() . '" class="' . $rowClass . '">';
		
		# + is add new Fo o(but grep this file for Add.png for more)
		if ($allowRemove)
			$result .= '<td class="add"><img src="'.$wgScriptPath.'/extensions/Wikidata/Images/Add.png" title="Enter new rows to add" alt="Add"/></td>' . EOL;

		$result .= $this->getStructureAsAddCells($idPath, $this);

		if ($repeatInput)
			$result .= '<td class="input-rows"/>' .  EOL;

		return $result . '</tr>' . EOL;
	}

	public function setHideEmptyColumns($hideEmptyColumns) {
		$this->hideEmptyColumns = $hideEmptyColumns;
	}
}

abstract class RecordEditor extends DefaultEditor {
	protected function getUpdateStructure() {
		$attributes = array();

		foreach($this->getEditors() as $editor)
			if ($updateAttribute = $editor->getUpdateAttribute())
				$attributes[] = $updateAttribute;

		return new Structure($attributes);
	}

	protected function getAddStructure() {
		$attributes = array();

		foreach($this->getEditors() as $editor)
			if ($addAttribute = $editor->getAddAttribute())
				$attributes[] = $addAttribute;

		return new Structure($attributes);
	}

	public function getUpdateValue(IdStack $idPath) {
		$result = new ArrayRecord($this->getUpdateStructure());

		foreach($this->getEditors() as $editor)
			if ($attribute = $editor->getUpdateAttribute()) {
				$idPath->pushAttribute($attribute);
				$result->setAttributeValue($attribute, $editor->getUpdateValue($idPath));
				$idPath->popAttribute();
			}

		return $result;
	}

	public function getAddValue(IdStack $idPath) {
		$result = new ArrayRecord($this->getAddStructure());

		foreach($this->getEditors() as $editor)
			if ($attribute = $editor->getAddAttribute()) {
				$idPath->pushAttribute($attribute);
				$result->setAttributeValue($attribute, $editor->getAddValue($idPath));
				$idPath->popAttribute();
			}

		return $result;
	}

	public function getUpdateAttribute() {
		$updateStructure = $this->getUpdateStructure();

		if (count($updateStructure->getAttributes()) > 0)
			return new Attribute($this->attribute->id, $this->attribute->name, $updateStructure);
		else
			return null;
	}

	public function getAddAttribute() {
		$addStructure = $this->getAddStructure();

		if (count($addStructure->getAttributes()) > 0)
			return new Attribute($this->attribute->id, $this->attribute->name, $addStructure);
		else
			return null;
	}

	public function save(IdStack $idPath, $value) {
		foreach($this->getEditors() as $editor) {
			$attribute = $editor->getAttribute();
			$idPath->pushAttribute($attribute);
			$editor->save($idPath, $value->getAttributeValue($attribute));
			$idPath->popAttribute();
		}
	}
	
	public function showsData($value) {
		$result = true;
		$i = 0;
		$childEditors = $this->getEditors();
		
		while ($result && $i < count($childEditors)) {
			$editor = $childEditors[$i];
			$result = $editor->showsData($value->getAttributeValue($editor->getAttribute()));
			$i++;
		}
		
		return $result;
	}
	
	public function showEditField(IdStack $idPath) {
		return true;
	}
}

class RecordTableCellEditor extends RecordEditor {
	public function view(IdStack $idPath, $value) {
	}

	public function edit(IdStack $idPath, $value) {
	}

	public function add(IdStack $idPath) {
	}

	public function save(IdStack $idPath, $value) {
	}
}

/* XXX: What is this for? */
abstract class ScalarEditor extends DefaultEditor {
	protected $permissionController;
	protected $isAddField;

	public function __construct(Attribute $attribute = null, PermissionController $permissionController, $isAddField) {
		parent::__construct($attribute);

		$this->permissionController = $permissionController;
		$this->isAddField = $isAddField;
	}

	protected function addId($id) {
		return "add-" . $id;
	}

	protected function updateId($id) {
		return "update-" . $id;
	}

	public function save(IdStack $idPath, $value) {
	}

	public function getUpdateAttribute() {
		if ($this->permissionController->allowUpdateOfAttribute($this->attribute))
			return $this->attribute;
		else
			return null;
	}

	public function getAddAttribute() {
		if ($this->isAddField)
			return $this->attribute;
		else
			return null;
	}

	public abstract function getViewHTML(IdStack $idPath, $value);
	public abstract function getEditHTML(IdStack $idPath, $value);
	public abstract function getInputValue($id);

	public function getUpdateValue(IdStack $idPath) {
		return $this->getInputValue("update-" . $idPath->getId());
	}

	public function getAddValue(IdStack $idPath) {
		return $this->getInputValue("add-" . $idPath->getId());
	}

	public function view(IdStack $idPath, $value) {
		return $this->getViewHTML($idPath, $value);
	}

	public function edit(IdStack $idPath, $value) {
		if ($this->permissionController->allowUpdateOfValue($idPath, $value))
			return $this->getEditHTML($idPath, $value);
		else
			return $this->getViewHTML($idPath, $value);
	}
	
	public function showsData($value) {
		return ($value != null) && (trim($value) != "");
	}
	
	public function showEditField(IdStack $idPath) {
		return true;
	}
}

class LanguageEditor extends ScalarEditor {
	public function getViewHTML(IdStack $idPath, $value) {
		return languageIdAsText($value);
	}

	public function getEditHTML(IdStack $idPath, $value) {
		return getSuggest($this->updateId($idPath->getId()), "language");
	}
	
	public function add(IdStack $idPath) {
		return getSuggest($this->addId($idPath->getId()), "language");
	}

	public function getInputValue($id) {
		global
			$wgRequest;

		return $wgRequest->getInt($id);
	}
	
	public function showsData($value) {
		return ($value != null) && ($value != 0);
	}
}

class SpellingEditor extends ScalarEditor {
	public function getViewHTML(IdStack $idPath, $value) {
		return spellingAsLink($value);
	}

	public function getEditHTML(IdStack $idPath, $value) {
			return getTextBox($this->updateId($idPath->getId()));
	}

	public function add(IdStack $idPath) {
		if ($this->isAddField)
			return getTextBox($this->addId($idPath->getId()));
		else
			return "";
	}

	public function getInputValue($id) {
		global
			$wgRequest;

		return trim($wgRequest->getText($id));
	}
}

class DefinedMeaningHeaderEditor extends ScalarEditor {
	protected $truncate;
	protected $truncateAt;
	protected $addText = "";

	public function __construct($attribute, $permissionController, $truncate=false, $truncateAt=0) {
		parent::__construct($attribute, $permissionController, false);

		$this->truncate = $truncate;
		$this->truncateAt = $truncateAt;
	}

	public function getViewHTML(IdStack $idPath, $value) {
		$definition = getDefinedMeaningDefinition($value);
		$definedMeaningAsLink = definedMeaningAsLink($value);
		$escapedDefinition = htmlspecialchars($definition);

		if ($this->truncate && strlen($definition) > $this->truncateAt)
			$escapedDefinition = '<span title="'. $escapedDefinition .'">'. htmlspecialchars(substr($definition, 0, $this->truncateAt)) . '...</span>' . EOL;
			
		return $definedMeaningAsLink . ": " . $escapedDefinition;			
	}

	public function getEditHTML(IdStack $idPath, $value) {
		return "";
	}

	public function add(IdStack $idPath) {
		if ($this->isAddField)
			return getTextArea($this->addId($idPath->getId()), "", 3);
		else
			return $this->addText;
	}

	public function getInputValue($id) {
		global
			$wgRequest;

		return trim($wgRequest->getText($id));
	}

	public function setAddText($addText) {
		$this->addText = $addText;
	}
}

class TextEditor extends ScalarEditor {
	protected $truncate;
	protected $truncateAt;
	protected $addText = "";
	protected $controller;

	public function __construct(Attribute $attribute = null, PermissionController $permissionController, $isAddField, $truncate=false, $truncateAt=0, UpdateAttributeController $controller = null) {
		parent::__construct($attribute, $permissionController, $isAddField);

		$this->truncate = $truncate;
		$this->truncateAt = $truncateAt;
		$this->controller = $controller;
	}

	public function getViewHTML(IdStack $idPath, $value) {
		$escapedValue = htmlspecialchars($value);

//		global $wgParser, $wgTitle, $wgOut;
//		$parserOutput = $wgParser->parse($value, $wgTitle, $wgOut->mParserOptions, true, true, $wgOut->mRevisionId);

		if (!$this->truncate || strlen($value) <= $this->truncateAt)
			return $escapedValue;//$parserOutput->getText();
		else
			return '<span title="'. $escapedValue .'">'. htmlspecialchars(substr($value, 0, $this->truncateAt)) . '...</span>' . EOL;
	}

	public function getEditHTML(IdStack $idPath, $value) {
		return getTextArea($this->updateId($idPath->getId()), $value, 3);
	}

	public function add(IdStack $idPath) {
		if ($this->isAddField)
			return getTextArea($this->addId($idPath->getId()), "", 3);
		else
			return $this->addText;
	}

	public function getInputValue($id) {
		global
			$wgRequest;

		return trim($wgRequest->getText($id));
	}

	public function setAddText($addText) {
		$this->addText = $addText;
	}
	
	public function save(IdStack $idPath, $value) {
		if ($this->controller != null) {
			$inputValue = $this->getInputValue($this->updateId($idPath->getId()));

			if ($inputValue != $value)
				$this->controller->update($idPath->getKeyStack(), $inputValue);
		}
	}
}

class ShortTextEditor extends ScalarEditor {
	protected $onChangeHandler;

	public function __construct(Attribute $attribute = null, PermissionController $permissionController, $isAddField, $onChangeHandler = "") {
		parent::__construct($attribute, $permissionController, $isAddField);
		
		$this->onChangeHandler = $onChangeHandler;
	}

	public function getViewHTML(IdStack $idPath, $value) {
		return htmlspecialchars($value);
	}

	public function getEditHTML(IdStack $idPath, $value) {
		return getTextBox($this->updateId($idPath->getId()), $value, $this->onChangeHandler);
	}

	public function add(IdStack $idPath) {
		if ($this->isAddField)
			return getTextBox($this->addId($idPath->getId()), "", $this->onChangeHandler);
		else
			return "";
	}

	public function getInputValue($id) {
		global
			$wgRequest;

		return trim($wgRequest->getText($id));
	}
}

class LinkEditor extends ShortTextEditor {
	public function getViewHTML(IdStack $idPath, $value) {
		$label = htmlspecialchars($value->linkLabel);
		$url = htmlspecialchars($value->linkURL); 

		if ($label == "")
			$label = $url;
		
		return 
			'<a href="' . $url . '">' . $label . '</a>' . EOL;
	}
}

class BooleanEditor extends ScalarEditor {
	protected $defaultValue;

	public function __construct(Attribute $attribute = null, PermissionController $permissionController, $isAddField, $defaultValue) {
		parent::__construct($attribute, $permissionController, $isAddField);

		$this->defaultValue = $defaultValue;
	}

	public function getViewHTML(IdStack $idPath, $value) {
		return booleanAsHTML($value);
	}

	public function getEditHTML(IdStack $idPath, $value) {
		return getCheckBox($this->updateId($idPath->getId()), $value);
	}

	public function add(IdStack $idPath) {
		if ($this->isAddField)
			return getCheckBox($this->addId($idPath->getId()), $this->defaultValue);
		else
			return "";
	}

	public function getInputValue($id) {
		global
			$wgRequest;

		return $wgRequest->getCheck($id);
	}
}

abstract class SuggestEditor extends ScalarEditor {
	public function add(IdStack $idPath) {
		if ($this->isAddField)
			return getSuggest($this->addId($idPath->getId()), $this->suggestType());
		else
			return "";
	}

	protected abstract function suggestType();

	public function getEditHTML(IdStack $idPath, $value) {
		return getSuggest($this->updateId($idPath->getId()), $this->suggestType()); 
	}

	public function getInputValue($id) {
		global
			$wgRequest;

		return trim($wgRequest->getText($id));
	}
}

class DefinedMeaningReferenceEditor extends SuggestEditor {
	protected function suggestType() {
		return "defined-meaning";
	}

	public function getViewHTML(IdStack $idPath, $value) {
		$definedMeaningId = $value->definedMeaningId;
		$definedMeaningLabel = $value->definedMeaningLabel;
		$definedMeaningDefiningExpression = $value->definedMeaningDefiningExpression;
		
		return definedMeaningReferenceAsLink($definedMeaningId, $definedMeaningDefiningExpression, $definedMeaningLabel);
	}
}

class ClassAttributesLevelDefinedMeaningEditor extends SuggestEditor {
	protected function suggestType() {
		return "class-attributes-level";
	}

	public function getViewHTML(IdStack $idPath, $value) {
		$definedMeaningId = $value->definedMeaningId;
		$definedMeaningLabel = $value->definedMeaningLabel;
		$definedMeaningDefiningExpression = $value->definedMeaningDefiningExpression;
		
		return definedMeaningReferenceAsLink($definedMeaningId, $definedMeaningDefiningExpression, $definedMeaningLabel);
	}
}

abstract class SelectEditor extends ScalarEditor {
	protected abstract function getOptions();

	public function add(IdStack $idPath) {
		if ($this->isAddField)
			return getSelect($this->addId($idPath->getId()), $this->getOptions());
		else
			return "";
	}

	public function getViewHTML(IdStack $idPath, $value) {
		$options = $this->getOptions();
		return $options[$value];
	}

	public function getEditHTML(IdStack $idPath, $value) {
		return getSelect($this->addId($idPath->getId()), $this->getOptions());
	}

	public function getInputValue($id) {
		global
			$wgRequest;

		return trim($wgRequest->getText($id));
	}
}

/* XXX: Should these options be stored somewhere else? */
class ClassAttributesTypeEditor extends SelectEditor {
	protected function getOptions() {
		return array(
			'DM' => 'Defined meaning', 
			'TRNS' => 'Translatable text', 
			'TEXT' => 'Plain text', 
			'URL' => 'Link', 
			'OPTN' => 'Option list'
		);
	}
}

class OptionSelectEditor extends SelectEditor {
	protected function getOptions() {
		return array();
	}

	public function getViewHTML(IdStack $idPath, $value) {
		$definedMeaningId = $value->definedMeaningId;
		$definedMeaningLabel = $value->definedMeaningLabel;
		$definedMeaningDefiningExpression = $value->definedMeaningDefiningExpression;
		
		return definedMeaningReferenceAsLink($definedMeaningId, $definedMeaningDefiningExpression, $definedMeaningLabel);
	}
}

class RelationTypeReferenceEditor extends DefinedMeaningReferenceEditor {
	protected function suggestType() {
		return "relation-type";
	}
}

class ClassReferenceEditor extends DefinedMeaningReferenceEditor {
	protected function suggestType() {
		return "class";
	}
}

class CollectionReferenceEditor extends DefinedMeaningReferenceEditor {
	protected function suggestType() {
		return "collection";
	}
}

class AttributeEditor extends DefinedMeaningReferenceEditor {
	protected $attributesLevelName;
	protected $attributeIDFilter;

	public function __construct(Attribute $attribute = null, PermissionController $permissionController, $isAddField, AttributeIDFilter $attributeIDFilter, $attributesLevelName) {
		parent::__construct($attribute, $permissionController, $isAddField);

		$this->attributeIDFilter = $attributeIDFilter;
		$this->attributesLevelName = $attributesLevelName;
	}

	public function add(IdStack $idPath) {
		if ($this->isAddField) {
			$parameters = array(
				"level" => $this->attributesLevelName, 
				"definedMeaningId" => $idPath->getDefinedMeaningId(),
				"annotationAttributeId" => $idPath->getAnnotationAttribute()->getId() 
			);
								
			return getSuggest($this->addId($idPath->getId()), $this->suggestType(), $parameters);			
		}
		else
			return "";
	}
	
	public function getEditHTML(IdStack $idPath, $value) {
		$parameters = array("level" => $this->attributesLevelName);
		return getSuggest($this->updateId($idPath->getId()), $this->suggestType(), $parameters); 
	}
	
	public function showEditField(IdStack $idPath) {
		return !$this->attributeIDFilter->leavesOnlyOneOption();
	}
}

class DefinedMeaningAttributeEditor extends AttributeEditor {
	protected function suggestType() {
		return "defined-meaning-attribute";
	}
}

class TextAttributeEditor extends AttributeEditor {
	protected function suggestType() {
		return "text-attribute";
	}
}

class TranslatedTextAttributeEditor extends AttributeEditor {
	protected function suggestType() {
		return "translated-text-attribute";
	}
}

class LinkAttributeEditor extends AttributeEditor {
	protected function suggestType() {
		return "link-attribute";
	}
}

class OptionAttributeEditor extends AttributeEditor {
	protected function suggestType() {
		return "option-attribute";
	}

	public function add(IdStack $idPath) {
		if ($this->isAddField) {
			$syntransId = $idPath->getKeyStack()->peek(0)->syntransId;
			
			$parameters = array(
				"level" => $this->attributesLevelName, 
				"definedMeaningId" => $idPath->getDefinedMeaningId(),
				"annotationAttributeId" => $idPath->getAnnotationAttribute()->getId(), 
				"onUpdate" => 'updateSelectOptions(\'' . $this->addId($idPath->getId()) . '-option\',' . $syntransId
			);
			return getSuggest($this->addId($idPath->getId()), $this->suggestType(), $parameters);
		}
		else
			return '';
	}

	public function getEditHTML(IdStack $idPath, $value) {
		$parameters = array(
			"level" => $this->attributesLevelName,
			"onUpdate" => 'updateSelectOptions(\'' . $this->updateId($idPath->getId()) . '-option\''
		);
		
		return getSuggest($this->updateId($idPath->getId()), $this->suggestType(), $parameters); 
	}
}

class RecordListEditor extends RecordEditor {
	protected $expandedEditors = array();
	protected $headerLevel = 1;
	protected $htmlTag;

	public function __construct(Attribute $attribute = null, $headerLevel, $htmlTag) {
		parent::__construct($attribute);
		
		$this->htmlTag = $htmlTag;
		$this->headerLevel = $headerLevel;
	}
	
	public function showsData($value) {
		$i = 0;
		$result = false;
		$childEditors = $this->getEditors();
		
		while(!$result && $i < count($childEditors)) {
			$editor = $childEditors[$i];
			$attribute = $editor->getAttribute();
			$attributeValue = $value->getAttributeValue($attribute);
			$result = $editor->showsData($attributeValue);
			$i++;			
		}
		
		return $result;
	}
	
	protected function shouldCompressOnView($idPath, $value, $editors) {
		$visibleEditorCount = 0;
		
		foreach ($editors as $editor) {
			$attribute = $editor->getAttribute();
			$idPath->pushAttribute($attribute);
			
			if ($editor->showsData($value->getAttributeValue($attribute)))
				$visibleEditorCount++;

			$idPath->popAttribute();
		}
		
		return $visibleEditorCount <= 1;
	}

	protected function viewEditors(IdStack $idPath, $value, $editors, $htmlTag, $compress) {
		$result = '';
		
		foreach ($editors as $editor) {
			$attribute = $editor->getAttribute();
			$idPath->pushAttribute($attribute);
			$class = $idPath->getClass();
			$attributeId = $idPath->getId();
			$attributeValue = $value->getAttributeValue($attribute);
						
			if ($editor->showsData($attributeValue)) { 	
				if (!$compress) 
					$result .=	
						'<' . $htmlTag . '>' . 
					    	$this->childHeader($editor, $attribute, $class, $attributeId);
					    	
				$result .= $this->viewChild($editor, $idPath, $value, $attribute, $class, $attributeId);
				    
			    if (!$compress)
			    	$result .= '</' . $htmlTag . '>';
			}
			           
			$idPath->popAttribute();			           
		}
		
		return $result;
	}

	public function view(IdStack $idPath, $value) {
		$editors = $this->getEditors();
		return $this->viewEditors($idPath, $value, $editors, $this->htmlTag, $this->shouldCompressOnView($idPath, $value, $editors));
	}

	public function showEditField(IdStack $idPath) {
		return true;
	}

	protected function shouldCompressOnEdit($idPath, $value, $editors) {
		$visibleEditorCount = 0;
		
		foreach ($editors as $editor) {
			$attribute = $editor->getAttribute();
			$idPath->pushAttribute($attribute);
			
			if ($editor->showEditField($idPath))
				$visibleEditorCount++;

			$idPath->popAttribute();
		}
		
		return $visibleEditorCount <= 1;
	}

	protected function editEditors(IdStack $idPath, $value, $editors, $htmlTag, $compress) {
		$result = '';
		
		foreach ($editors as $editor) {
			$attribute = $editor->getAttribute();
			$idPath->pushAttribute($attribute);
			
			if ($editor->showEditField($idPath)) {
				$class = $idPath->getClass();
				$attributeId = $idPath->getId();

				if (!$compress)	
					$result .= 	
						'<' . $htmlTag . '>'.
						   	$this->childHeader($editor, $attribute, $class, $attributeId); 
						   	
				$result	.= $this->editChild($editor, $idPath, $value,  $attribute, $class, $attributeId);
				
				if (!$compress)	
					$result .= '</' . $htmlTag . '>';
			}
			
			$idPath->popAttribute();
		}

		return $result;
	}

	public function edit(IdStack $idPath, $value) {
		$editors = $this->getEditors();
		return $this->editEditors($idPath, $value, $editors, $this->htmlTag, $this->shouldCompressOnEdit($idPath, $value, $editors));
	}
	
	protected function addEditors(IdStack $idPath, $editors, $htmlTag) {
		$result = '';
		
		foreach($editors as $editor) {
			if ($attribute = $editor->getAddAttribute()) {
				$idPath->pushAttribute($attribute);
				$class = $idPath->getClass();
				$attributeId = $idPath->getId();

				$result .=	
					'<' . $htmlTag . '>'.
						$this->childHeader($editor, $attribute, $class, $attributeId) .
						$this->addChild($editor, $idPath, $attribute, $class, $attributeId) .
					'</' . $htmlTag . '>';

				$editor->add($idPath);
				$idPath->popAttribute();
			}
		}

		return $result;
	}
	
	public function add(IdStack $idPath) {
		return $this->addEditors($idPath, $this->getEditors(), $this->htmlTag);
	}
	
	protected function childHeader(Editor $editor, Attribute $attribute, $class, $attributeId){
		$expansionPrefix = $this->getExpansionPrefix($class, $attributeId);
		$this->setExpansionByEditor($editor, $class);
		return '<h'. $this->headerLevel .'><span id="collapse-'. $attributeId .'" class="toggle '. addCollapsablePrefixToClass($class) .'" onclick="toggle(this, event);">' . $expansionPrefix . '&nbsp;' . $attribute->name . '</span></h'. $this->headerLevel .'>' . EOL;
	}
	
	protected function viewChild(Editor $editor, IdStack $idPath, $value, Attribute $attribute, $class, $attributeId){
		return '<div id="collapsable-'. $attributeId . '" class="expand-' . $class . '">' . $editor->view($idPath, $value->getAttributeValue($attribute)) . '</div>' . EOL;
	}

	protected function editChild(Editor $editor, IdStack $idPath, $value, Attribute $attribute, $class, $attributeId) {
		return '<div id="collapsable-'. $attributeId . '" class="expand-' . $class . '">' . $editor->edit($idPath, $value->getAttributeValue($attribute)) . '</div>' . EOL;
	}

	protected function addChild(Editor $editor, IdStack $idPath, Attribute $attribute, $class, $attributeId) {
		return '<div id="collapsable-'. $attributeId . '" class="expand-' . $class . '">' . $editor->add($idPath) . '</div>' . EOL;
	}

	public function expandEditor(Editor $editor) {
		$this->expandedEditors[] = $editor;
	}

	public function setExpansionByEditor(Editor $editor, $elementType) {
		$this->setExpansion(in_array($editor, $this->expandedEditors, true), $elementType);
	}
}

class RecordUnorderedListEditor extends RecordListEditor {
	public function __construct(Attribute $attribute = null, $headerLevel) {
		parent::__construct($attribute, $headerLevel, "li");
	}
	
	protected function wrapInList($listItems) {
		if ($listItems != "")
			return
				'<ul class="collapsable-items">' . $listItems . '</ul>' . EOL;
		else
			return "";
	}
	
	public function view(IdStack $idPath, $value) {
		$editors = $this->getEditors();
		$compress = $this->shouldCompressOnView($idPath, $value, $editors);
		$result = $this->viewEditors($idPath, $value, $editors, $this->htmlTag, $compress);
		
		if (!$compress)
			return $this->wrapInList($result);
		else
			return $result;
	}

	public function edit(IdStack $idPath, $value) {
		$editors = $this->getEditors();
		$compress = $this->shouldCompressOnEdit($idPath, $value, $editors);
		$result = $this->editEditors($idPath, $value, $editors, $this->htmlTag, $compress);
		
		if (!$compress)
			return $this->wrapInList($result);
		else
			return $result;
	}

	public function add(IdStack $idPath) {
		return $this->wrapInList(parent::add($idPath));
	}
}

class RecordDivListEditor extends RecordListEditor {
	public function __construct(Attribute $attribute = null) {
		parent::__construct($attribute, 0, "div");
	}

	protected function wrapInDiv($listItems) {
		return '<div>' . $listItems . '</div>';
	}
	
	public function view(IdStack $idPath, $value) {
		return $this->wrapInDiv(parent::view($idPath, $value));
	}

	public function edit(IdStack $idPath, $value) {
		return $this->wrapInDiv(parent::edit($idPath, $value));
	}

	public function add(IdStack $idPath) {
		return $this->wrapInDiv(parent::add($idPath));
	}
	
	protected function childHeader(Editor $editor, Attribute $attribute, $class, $attributeId){
		return "";
	}
}

class WrappingEditor implements Editor {
	protected $wrappedEditor;
	
	public function __construct(Editor $wrappedEditor) {
		$this->wrappedEditor = $wrappedEditor;
	}

	public function getAttribute() {
		return $this->wrappedEditor->getAttribute();
	}
	
	public function getUpdateAttribute() {
		return $this->wrappedEditor->getUpdateAttribute();
	}
	
	public function getAddAttribute() {
		return $this->wrappedEditor->getAddAttribute();
	}

	public function showsData($value) {
		return $this->wrappedEditor->showsData($value);
	}
	
	public function showEditField(IdStack $idPath) {
		return $this->wrappedEditor->showEditField($idPath);
	}
	
	public function view(IdStack $idPath, $value) {
		return $this->wrappedEditor->view($idPath, $value);
	}
	
	public function edit(IdStack $idPath, $value) {
		return $this->wrappedEditor->edit($idPath, $value);	
	}
	
	public function add(IdStack $idPath) {
		return $this->wrappedEditor->add($idPath);	
	}
	
	public function save(IdStack $idPath, $value) {
		$this->wrappedEditor->save($idPath, $value);
	}

	public function getUpdateValue(IdStack $idPath) {
		return $this->wrappedEditor->getUpdateValue($idPath);	
	}
	
	public function getAddValue(IdStack $idPath) {
		return $this->wrappedEditor->getAddValue($idPath);
	}

	public function getEditors() {
		return $this->wrappedEditor->getEditors();
	}
	
	public function getAttributeEditorMap() {
		return $this->wrappedEditor->getAttributeEditorMap();
	}
}

class PopUpEditor extends WrappingEditor {
	protected $linkCaption;
	
	public function __construct(Editor $wrappedEditor, $linkCaption) {
		parent::__construct($wrappedEditor);
				
		$this->linkCaption = $linkCaption;
	}

	public function view(IdStack $idPath, $value) {
		return
			$this->startToggleCode($idPath->getId()) .
			$this->wrappedEditor->view($idPath, $value) . 
			$this->endToggleCode($idPath->getId());
	}
	
	public function edit(IdStack $idPath, $value) {
		return 	
			$this->startToggleCode($idPath->getId()) .
			$this->wrappedEditor->edit($idPath, $value) .
			$this->endToggleCode($idPath->getId());
	}

	protected function startToggleCode($attributeId) {
		return 	
			'<a id="popup-' . $attributeId . '-link" style="cursor: pointer; font-weight: bolder; font-size: 90%; white-space: nowrap" onclick="togglePopup(this, event);">'. $this->linkCaption .' &raquo;</a>' . EOL. 
			'<div><div id="popup-' . $attributeId . '-toggleable" style="position: absolute; border: 1px solid #000000; display: none; background-color: white; padding: 4px;">' . EOL;
	}

	protected function endToggleCode($attributeId) {
		return '</div></div>' . EOL;
	}
}

class RecordSetListEditor extends RecordSetEditor {
	protected $headerLevel;
	protected $childrenExpanded;
	protected $captionEditor;
	protected $valueEditor;

	public function __construct(Attribute $attribute = null, PermissionController $permissionController, ShowEditFieldChecker $showEditFieldChecker, AllowAddController $allowAddController, $allowRemove, $isAddField, UpdateController $controller = null, $headerLevel, $childrenExpanded) {
		parent::__construct($attribute, $permissionController, $showEditFieldChecker, $allowAddController, $allowRemove, $isAddField, $controller);

		$this->headerLevel = $headerLevel;
		$this->childrenExpanded = $childrenExpanded;
	}

	public function setCaptionEditor(Editor $editor) {
		$this->captionEditor = $editor;
		$this->editors[0] = $editor;
	}

	public function setValueEditor(Editor $editor) {
		$this->valueEditor = $editor;
		$this->editors[1] = $editor;
	}

	public function view(IdStack $idPath, $value) {
		$recordCount = $value->getRecordCount();

		if ($recordCount > 0) {
			$result = '<ul class="collapsable-items">' . EOL;
			$key = $value->getKey();
			$captionAttribute = $this->captionEditor->getAttribute();
			$valueAttribute = $this->valueEditor->getAttribute();
		
			for ($i = 0; $i < $recordCount; $i++) {
				$record = $value->getRecord($i);
				$idPath->pushKey(project($record, $key));
				$recordId = $idPath->getId();
				$captionClass = $idPath->getClass() . "-record";
				$captionExpansionPrefix = $this->getExpansionPrefix($captionClass, $recordId);
				$this->setExpansion($this->childrenExpanded, $captionClass);
				$valueClass = $idPath->getClass() . "-record";
				$this->setExpansion($this->childrenExpanded, $valueClass);
		
				$idPath->pushAttribute($captionAttribute);
				$result .= '<li>'.
							'<h' . $this->headerLevel .'><span id="collapse-'. $recordId .'" class="toggle '. addCollapsablePrefixToClass($captionClass) .'" onclick="toggle(this, event);">' . $captionExpansionPrefix . '&nbsp;' . $this->captionEditor->view($idPath, $record->getAttributeValue($captionAttribute)) . '</span></h' . $this->headerLevel .'>';
				$idPath->popAttribute();
		
				$idPath->pushAttribute($valueAttribute);
				$result .= '<div id="collapsable-'. $recordId . '" class="expand-' . $valueClass . '">' . $this->valueEditor->view($idPath, $record->getAttributeValue($valueAttribute)) . '</div>' .
							'</li>';
				$idPath->popAttribute();
		
				$idPath->popKey();
			}
		
			$result .= '</ul>';
		
			return $result;
		}
		else
			return "";	
	}

	public function edit(IdStack $idPath, $value) {
		global
			$wgScriptPath;
		
		$recordCount = $value->getRecordCount();
		
		if ($recordCount > 0 || $this->allowAddController->check($idPath)) {
			$result = '<ul class="collapsable-items">';
			$key = $value->getKey();
			$captionAttribute = $this->captionEditor->getAttribute();
			$valueAttribute = $this->valueEditor->getAttribute();
	
			for ($i = 0; $i < $recordCount; $i++) {
				$record = $value->getRecord($i);
				$idPath->pushKey(project($record, $key));
	
				$recordId = $idPath->getId();
				$captionClass = $idPath->getClass();
				$captionExpansionPrefix = $this->getExpansionPrefix($captionClass, $recordId);
				$this->setExpansion($this->childrenExpanded, $captionClass);
				$valueClass = $idPath->getClass();
				$this->setExpansion($this->childrenExpanded, $valueClass);
	
				$idPath->pushAttribute($captionAttribute);
				$result .= '<li>'.
							'<h' . $this->headerLevel .'><span id="collapse-'. $recordId .'" class="toggle '. addCollapsablePrefixToClass($captionClass) .'" onclick="toggle(this, event);">' . $captionExpansionPrefix . '&nbsp;' . $this->captionEditor->edit($idPath, $record->getAttributeValue($captionAttribute)) . '</span></h' . $this->headerLevel .'>' . EOL;
				$idPath->popAttribute();
	
				$idPath->pushAttribute($valueAttribute);
				$result .= '<div id="collapsable-'. $recordId . '" class="expand-' . $valueClass . '">' . $this->valueEditor->edit($idPath, $record->getAttributeValue($valueAttribute)) . '</div>' . EOL .
							'</li>' . EOL;
				$idPath->popAttribute();
	
				$idPath->popKey();
			}
	
			if ($this->allowAddController->check($idPath)) {
				$recordId = 'add-' . $idPath->getId();
				$idPath->pushAttribute($captionAttribute);
				$class = $idPath->getClass();
	
				$this->setExpansion(true, $class);
				
				# For which class is this add?
				$result .= '<li>'.
							'<h' . $this->headerLevel . '><span id="collapse-'. $recordId .'" class="toggle '. addCollapsablePrefixToClass($class) .'" onclick="toggle(this, event);">' . $this->getExpansionPrefix($idPath->getClass(), $idPath->getId()) . ' <img src="'.$wgScriptPath.'/extensions/Wikidata/Images/Add.png" title="Enter new list item to add" alt="Add"/>' . $this->captionEditor->add($idPath) . '</span></h' . $this->headerLevel .'>' . EOL;
				$idPath->popAttribute();
	
				$idPath->pushAttribute($valueAttribute);
				$result .= '<div id="collapsable-'. $recordId . '" class="expand-' . $class . '">' . $this->valueEditor->add($idPath) . '</div>' . EOL .
							'</li>' . EOL;
				$idPath->popAttribute();
			}

			$result .= '</ul>' . EOL;

			return $result;
		}
		else
			return ""; 
	}

	public function add(IdStack $idPath) {
		$result = '<ul class="collapsable-items">' . EOL;
		$captionAttribute = $this->captionEditor->getAttribute();
		$valueAttribute = $this->valueEditor->getAttribute();

		$recordId = 'add-' . $idPath->getId();

		$idPath->pushAttribute($captionAttribute);
		$class = $idPath->getClass();

		$this->setExpansion(true, $class);

		$result .= '<li>'.
					'<h' . $this->headerLevel .'><span id="collapse-'. $recordId .'" class="toggle '. addCollapsablePrefixToClass($class) .'" onclick="toggle(this, event);">' . $this->getExpansionPrefix($idPath->getClass(), $idPath->getId()) . '&nbsp;' . $this->captionEditor->add($idPath) . '</span></h' . $this->headerLevel .'>' . EOL;
		$idPath->popAttribute();

		$idPath->pushAttribute($valueAttribute);
		$result .= '<div id="collapsable-'. $recordId . '" class="expand-' . $class . '">' . $this->valueEditor->add($idPath) . '</div>' .
					'</li>' . EOL;
		$idPath->popAttribute();

		$result .= '</ul>' . EOL;

		return $result;
	}
}

class AttributeLabelViewer extends Viewer {
	public function view(IdStack $idPath, $value) {
		return $this->attribute->name;
	}

	public function add(IdStack $idPath) {
		return "New " . strtolower($this->attribute->name);
	}
	
	public function showsData($value) {
		return true;
	}
	
	public function showEditField(IdStack $idPath){
		return true;
	}
}

class RecordSpanEditor extends RecordEditor {
	protected $attributeSeparator;
	protected $valueSeparator;
	protected $showAttributeNames;

	public function __construct(Attribute $attribute = null, $valueSeparator, $attributeSeparator, $showAttributeNames = true) {
		parent::__construct($attribute);

		$this->attributeSeparator = $attributeSeparator;
		$this->valueSeparator = $valueSeparator;
		$this->showAttributeNames = $showAttributeNames;
	}

	public function view(IdStack $idPath, $value) {
		$fields = array();

		foreach($this->getEditors() as $editor) {
			$attribute = $editor->getAttribute();
			$idPath->pushAttribute($attribute);
			$attributeValue = $editor->view($idPath, $value->getAttributeValue($attribute));
			
			if ($this->showAttributeNames)	
				$field = $attribute->name . $this->valueSeparator . $attributeValue;
			else
				$field = $attributeValue; 
			
			if ($field != "")
				$fields[] = $field;
					
			$idPath->popAttribute();
		}

		return implode($this->attributeSeparator, $fields);
	}

	public function add(IdStack $idPath) {
		$fields = array();

		foreach($this->getEditors() as $editor) {
			if ($attribute = $editor->getAddAttribute()) {
				$attribute = $editor->getAttribute();
				$idPath->pushAttribute($attribute);
				$attributeId = $idPath->getId();
				$fields[] = $attribute->name . $this->valueSeparator. $editor->add($idPath);
				$editor->add($idPath);
				$idPath->popAttribute();
			}
		}

		return implode($this->attributeSeparator, $fields);
	}

	public function edit(IdStack $idPath, $value) {
		$fields = array();

		foreach($this->getEditors() as $editor) {
			$attribute = $editor->getAttribute();
			$idPath->pushAttribute($attribute);
			$fields[] = $attribute->name . $this->valueSeparator. $editor->view($idPath, $value->getAttributeValue($attribute));
			$idPath->popAttribute();
		}

		return implode($this->attributeSeparator, $fields);
	}
}

class UserEditor extends ScalarEditor {
	public function getViewHTML(IdStack $idPath, $value) {
		global
			$wgUser;
			
		if ($value != "")	
			return $wgUser->getSkin()->makeLink("User:".$value, $value);
		else
			return "";
	}
	
	public function getEditHTML(IdStack $idPath, $value) {
		return $this->getViewHTML($idPath, $value);
	}

	public function getInputValue($id) {
	}
	
	public function add(IdStack $idPath) {
	}
}

class TimestampEditor extends ScalarEditor {
	public function getViewHTML(IdStack $idPath, $value) {
		if ($value != "")
			return timestampAsText($value);
		else
			return "";
	}
	
	public function getEditHTML(IdStack $idPath, $value) {
		return $this->getViewHTML($idPath, $value);
	}

	public function getInputValue($id) {
	}
	
	public function add(IdStack $idPath) {
	}
}

// The roll back editor is tricked. It shows a checkbox when its value is 'true', meaning that the record is the latest
// so it can be rolled back. However, when requesting the input value it returns the value of the roll back check box.
// This can possibly be solved better later on when we choose to let editors fetch the value(s) of the attribute(s) they're
// viewing within their parent. The roll back editor could then inspect the value of the $isLatestAttribute to decide whether
// to show the roll back check box. 

//class RollbackEditor extends BooleanEditor {
//	public function __construct($attribute)  {
//		parent::__construct($attribute, new SimplePermissionController(false), false, false);
//	}
//
//	public function getViewHTML($idPath, $value) {
//		if ($value)
//			return $this->getEditHTML($idPath, false);
//		else
//			return "";
//	}
//
//	public function shouldRollBack($id, $value) {
//		return $value && isset($_POST[$id]);
//	}
//}

class RollBackEditor extends ScalarEditor {
	protected $hasValueFields;
	protected $suggestionsEditor;
	
	public function __construct(Attribute $attribute = null, $hasValueFields)  {
		parent::__construct($attribute, new SimplePermissionController(false), false, false);
		
		$this->hasValueFields = $hasValueFields;
	}
	
	public function getViewHTML(IdStack $idPath, $value) {
		$isLatest = $value->isLatest;
		$operation = $value->operation;
		
		if ($isLatest) {
			$options = array('do-nothing' => 'Do nothing');
			
			if ($this->hasValueFields) {
				$previousVersionLabel = 'Previous version';
				$rollBackChangeHandler = 'rollBackOptionChanged(this);';
			}
			else {
				$previousVersionLabel = 'Restore';
				$rollBackChangeHandler = '';
			}
				
			if ($this->hasValueFields || $operation != 'Added')
				$options['previous-version'] = $previousVersionLabel;
			
			if ($operation != 'Removed')
				$options['remove'] = 'Remove';
		
			$result = getSelect($idPath->getId(), $options, 'do-nothing', $rollBackChangeHandler);
		
			if ($this->suggestionsEditor != null)
				$result .=
					'<div id="' . $idPath->getId() . '-version-selector" style="display: none; padding-top: 4px;">' . 
						$this->getSuggestionsHTML($idPath, $value) . 
					'</div>' . EOL;
				
			return $result;
		}
		else
			return "";
	}

	public function getEditHTML(IdStack $idPath, $value) {
		return $this->getViewHTML($idPath, $value);
	}

	protected function getSuggestionsHTML(IdStack $idPath, $value) {
		$attribute = $this->suggestionsEditor->getAttribute();
		$idPath->pushAttribute($attribute);
		$result = $this->suggestionsEditor->view($idPath, $value->getAttributeValue($attribute));
		$idPath->popAttribute();
		
		return $result;
	}

	public function getInputValue($id) {
		return "";
	}

	public function add(IdStack $idPath) {
	}
	
	public function setSuggestionsEditor(Editor $suggestionsEditor) {
		$this->suggestionsEditor = $suggestionsEditor;
	}
}

class RecordSetRecordSelector extends WrappingEditor {
	public function view(IdStack $idPath, $value) {
		return getStaticSuggest(
			$idPath->getId(), 
			$this->wrappedEditor->view($idPath, $value), 
			count($value->getKey()->getAttributes())
		);
	}
}

class RecordSubRecordEditor extends RecordEditor {
	protected $subRecordEditor;
	
	public function view(IdStack $idPath, $value) {
		$attribute = $this->subRecordEditor->getAttribute();
		$idPath->pushAttribute($attribute);
		$result = $this->subRecordEditor->view($idPath, $value->getAttributeValue($attribute));
		$idPath->popAttribute();

		return $result;
	}

	public function edit(IdStack $idPath, $value) {
		$attribute = $this->subRecordEditor->getAttribute();
		$idPath->pushAttribute($attribute);
		$result = $this->subRecordEditor->edit($idPath, $value->getAttributeValue($attribute));
		$idPath->popAttribute();

		return $result;
	}
	
	public function add(IdStack $idPath) {
		$attribute = $this->subRecordEditor->getAttribute();
		$idPath->pushAttribute($attribute);
		$result = $this->subRecordEditor->add($idPath);
		$idPath->popAttribute();
		
		return $result;
	}
	
	public function setSubRecordEditor(Editor $subRecordEditor) {
		$this->subRecordEditor = $subRecordEditor;
		$this->editors[0] = $subRecordEditor;
	}
}

class RecordSetFirstRecordEditor extends RecordSetEditor {
	protected $recordEditor;
		
	public function view(IdStack $idPath, $value) {
		if ($value->getRecordCount() > 0) {
			$record = $value->getRecord(0);
			$idPath->pushKey(project($record, $value->getKey()));
			$result = $this->recordEditor->view($idPath, $record);
			$idPath->popKey();
			
			return $result;
		}
		else
			return "";
	}

	public function edit(IdStack $idPath, $value) {
		if ($value->getRecordCount() > 0) {
			$record = $value->getRecord(0);
			$idPath->pushKey(project($record, $value->getKey()));
			$result = $this->recordEditor->edit($idPath, $record);
			$idPath->popKey();
		}
		else
			$result = $this->recordEditor->add($idPath);

		return $result;
	}
	
	public function add(IdStack $idPath) {
		return "";
	}
	
	public function save(IdStack $idPath, $value) {
		if ($value->getRecordCount() > 0) { 
			$record = $value->getRecord(0);
			$idPath->pushKey(project($record, $value->getKey()));
			$this->recordEditor->save($idPath, $record);
			$idPath->popKey();
		}
		else 
			$this->controller->add($idPath, $this->recordEditor->getAddValue($idPath));
	}

	public function setRecordEditor(Editor $recordEditor) {
		$this->recordEditor = $recordEditor;
		$this->editors[0] = $recordEditor;
	}
}

class ObjectPathEditor extends Viewer {	
	public function view(IdStack $idPath, $value) {
		return $this->resolveObject($value);
	}
	
	protected function resolveObject($objectId) {
		$dc=wdGetDataSetContext();
		wfDebug("dc is <$dc>\n");

		$tableName = getTableNameWithObjectId($objectId);
		
		if ($tableName != "") {
			switch ($tableName) {
				case "{$dc}_meaning_relations": 
					$result = $this->resolveRelation($objectId);
					break;
				case "{$dc}_text_attribute_values":
				case "{$dc}_url_attribute_values":
				case "{$dc}_translated_text_attribute_values":
				case "{$dc}_option_attribute_values":
					$result = $this->resolveAttribute($objectId, $tableName);
					break;
				case "{$dc}_translated_content":
					$result = $this->resolveTranslatedContent($objectId);
					break;
				case "{$dc}_syntrans":
					$result = $this->resolveSyntrans($objectId);
					break;
				case "{$dc}_defined_meaning":
					$result = $this->resolveDefinedMeaning($objectId);
					break;
				default:
					$result = $tableName . " - " . $objectId; 
			}
		}
		else
			$result = "Object $objectId";

		return $result;
	}
	
	protected function resolveRelation($objectId) {
		$dc=wdGetDataSetContext();
		$dbr = &wfGetDB(DB_SLAVE);
		$queryResult = $dbr->query(
			"SELECT meaning1_mid, relationtype_mid, meaning2_mid" .
			" FROM {$dc}_meaning_relations" .
			" WHERE relation_id=$objectId"
		);

		if ($relation = $dbr->fetchObject($queryResult))
			return
				definedMeaningAsLink($relation->meaning1_mid) . " - " .
				definedMeaningAsLink($relation->relationtype_mid) . " - " .
				definedMeaningAsLink($relation->meaning2_mid);		
		else	
			return "Relation " . $objectId;
	}
	
	protected function resolveAttribute($objectId, $tableName) {
		$dbr = &wfGetDB(DB_SLAVE);
		$queryResult = $dbr->query(
			"SELECT object_id, attribute_mid" .
			" FROM " . $tableName .
			" WHERE value_id=$objectId"
		);

		if ($attribute = $dbr->fetchObject($queryResult))
			return
				$this->resolveObject($attribute->object_id) . " > " .
				definedMeaningAsLink($attribute->attribute_mid); 
		else	
			return "Attribute " . $objectId;
	}

	protected function resolveTranslatedContent($objectId) {
		$dc=wdGetDataSetContext();
		$dbr = &wfGetDB(DB_SLAVE);
		$queryResult = $dbr->query(
			"SELECT defined_meaning_id" .
			" FROM {$dc}_defined_meaning" .
			" WHERE meaning_text_tcid=$objectId"
		);

		if ($definedMeaning = $dbr->fetchObject($queryResult))
			return
				definedMeaningAsLink($definedMeaning->defined_meaning_id) . " > Definition "; 
		else	
			return "Translated content " . $objectId;
	}

	protected function resolveSyntrans($objectId) {
		$dc=wdGetDataSetContext();
		$dbr = &wfGetDB(DB_SLAVE);
		$queryResult = $dbr->query(
			"SELECT spelling, defined_meaning_id" .
			" FROM {$dc}_syntrans, {$dc}_expression" .
			" WHERE syntrans_sid=$objectId" .
			" AND {$dc}_syntrans.expression_id={$dc}_expression.expression_id"
		);

		if ($syntrans = $dbr->fetchObject($queryResult))
			return
				 definedMeaningAsLink($syntrans->defined_meaning_id) . " > " . spellingAsLink($syntrans->spelling); 
		else	
			return "Syntrans " . $objectId;
	}
	
	protected function resolveDefinedMeaning($definedMeaningId) {
		return definedMeaningAsLink($definedMeaningId);
	}

	public function showsData($value) {
		return true;
	}
}

class GotoSourceEditor extends Viewer {	
	public function view(IdStack $idPath, $value) {
		global
			  $wgGotoSourceTemplates;
		
		$collectionId = $value->collectionId;			
		$sourceIdentifier = $value->sourceIdentifier;

		$gotoSourceTemplate = $wgGotoSourceTemplates[$collectionId];
		
		if ($gotoSourceTemplate != null) {	
			$url = $gotoSourceTemplate->getURL($sourceIdentifier);
			return '<a href="'. htmlspecialchars($url) . '">Go to source</a>' . EOL;
		}	
		else
			return "";
		
	}
	
	public function showsData($value) {
		return true;
	}
}

class DefinedMeaningContextEditor extends WrappingEditor {
	public function view(IdStack $idPath, $value) {
		$definedMeaningId = (int) $value->definedMeaningId;

		$idPath->pushDefinedMeaningId($definedMeaningId);	
		$idPath->pushClassAttributes(new ClassAttributes($definedMeaningId));

		$result = $this->wrappedEditor->view($idPath, $value);

		$idPath->popClassAttributes();
		$idPath->popDefinedMeaningId();
		
		return $result;
	}
	
	public function edit(IdStack $idPath, $value) {
		if (is_null($idPath)) {
			throw new Exception("Null provided for idPath while trying to edit()");
		}

		if (is_null($value)) {
			throw new Exception("Null provided for value while trying to edit()");
		}

		$definedMeaningId = (int) $value->definedMeaningId;
		
		$idPath->pushDefinedMeaningId($definedMeaningId);
		$idPath->pushClassAttributes(new ClassAttributes($definedMeaningId));
			
		$result = $this->wrappedEditor->edit($idPath, $value);
		
		$idPath->popClassAttributes();
		$idPath->popDefinedMeaningId();
		
		return $result;	
	}
	
	public function save(IdStack $idPath, $value) {
		$definedMeaningId = (int) $value->definedMeaningId;
		
		$idPath->pushDefinedMeaningId($definedMeaningId);	
		$idPath->pushClassAttributes(new ClassAttributes($definedMeaningId));

		$this->wrappedEditor->save($idPath, $value);

		$idPath->popClassAttributes();
		$idPath->popDefinedMeaningId();
	}
}

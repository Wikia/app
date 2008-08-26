<?php

require_once("Attribute.php");
require_once("Record.php");
require_once("RecordSet.php");

function parityClass($value) {
	if ($value % 2 == 0)
		return "even";
	else
		return "odd";
}

/* Functions to create a hierarchical table header
 * using rowspan and colspan for <th> elements
 */

class TableHeaderNode {
	public $attribute = null;
	public $width = 0;
	public $height = 0;
	public $column = 0;
	public $childNodes = array();
}

function getTableHeaderNode(Structure $structure, &$currentColumn=0) {
	$tableHeaderNode = new TableHeaderNode();
	
	foreach($structure->getAttributes() as $attribute) {
		$type = $attribute->type;
		
		if ($type instanceof Structure) {
			$atts=$type->getAttributes();
			$childNode = getTableHeaderNode(new Structure($atts), $currentColumn);
		} else { 
			$childNode = new TableHeaderNode();
			$childNode->width = 1;
			$childNode->height = 1;
			$childNode->column = $currentColumn++;
		}

		$tableHeaderNode->height = max($tableHeaderNode->height, $childNode->height);
		$tableHeaderNode->width += $childNode->width;
		$tableHeaderNode->childNodes[] = $childNode;
		$childNode->attribute = $attribute;
	}
	
	$tableHeaderNode->height++;
	
	return $tableHeaderNode;
}

function addChildNodesToRows(TableHeaderNode $headerNode, &$rows, $currentDepth, $columnOffset, IdStack $idPath, $leftmost=True) {
	$height = $headerNode->height;
	foreach($headerNode->childNodes as $childNode) {
		$attribute = $childNode->attribute;
		$idPath->pushAttribute($attribute);		
		$type = $attribute->type;
		
		if (!$type instanceof Structure) {
			$skipRows=count($rows);
			$columnIndex=$childNode->column + $columnOffset;
			$sort = 'sortTable(this, '. $skipRows .', '. $columnIndex.')';
			$onclick = ' onclick= "' . $sort . '"';
			if ($leftmost) {		# Are we the leftmost column?
				$leftsort= EOL . 
					'<script type="text/javascript"> toSort("' . 
					$idPath->getId(). '-h" , ' . $skipRows . ',' . 
					$columnIndex . '); </script>' 
					. EOL;
				$leftmost = False; 	# There can be only one.
			} 
			else 
				$leftsort="";

			$class = ' class="' . $type . ' sortable"' . $onclick;	
		} 
		else {
			$class = '';
			$sort = '';
			$leftsort='';
		}
		
		$rowSpan = $height - $childNode->height;
		$rows[$currentDepth] .= '<th id="'.$idPath->getId().'-h" '. $class .
			' colspan="'. $childNode->width .  '" rowspan="'. $rowSpan . 
			'">'. $attribute->name . $leftsort .'</th>';
									
		addChildNodesToRows($childNode, $rows, $currentDepth + $rowSpan, $columnOffset,$idPath, $leftmost);
		$idPath->popAttribute();
	} 
}

function getStructureAsTableHeaderRows(Structure $structure, $columnOffset, IdStack $idPath) {
	$rootNode = getTableHeaderNode($structure);
	$result = array();
	
	for ($i = 0; $i < $rootNode->height - 1; $i++)
		$result[$i] = "";
		
	addChildNodesToRows($rootNode, $result, 0, $columnOffset, $idPath);

	return $result;
}

function getHTMLClassForType($type, Attribute $attribute) {
	if ($type instanceof Structure) 
		return $attribute->id;
	else 
		return $type;
}

function getRecordAsTableCells(IdStack $idPath, Editor $editor, Structure $visibleStructure, Record $record, &$startColumn = 0) {
	$result = '';
	$childEditorMap = $editor->getAttributeEditorMap();
	
	foreach ($visibleStructure->getAttributes() as $visibleAttribute) {
		$childEditor = $childEditorMap->getEditorForAttribute($visibleAttribute);
		
		if ($childEditor != null) {
			$attribute = $childEditor->getAttribute();
			$type = $attribute->type;
			$value = $record->getAttributeValue($attribute);
			$idPath->pushAttribute($attribute);
			$attributeId = $idPath->getId();
			
			if ($childEditor instanceof RecordTableCellEditor) 
				$result .= getRecordAsTableCells($idPath, $childEditor, $visibleAttribute->type, $value, $startColumn);	
			else {
				$displayValue = $childEditor->showsData($value) ? $childEditor->view($idPath, $value) : "";
				$result .= '<td class="'. getHTMLClassForType($type, $attribute) .' column-'. parityClass($startColumn) . '">'. $displayValue . '</td>';
				$startColumn++;
			}
			
			$idPath->popAttribute();
		}
		else
			$result .= '<td/>';
	}
	
	return $result;
}

function getRecordAsEditTableCells(IdStack $idPath, Editor $editor, Structure $visibleStructure, Record $record, &$startColumn = 0) {
	$result = '';
	$childEditorMap = $editor->getAttributeEditorMap();
	
	foreach($visibleStructure->getAttributes() as $visibleAttribute) {
		$childEditor = $childEditorMap->getEditorForAttribute($visibleAttribute);
		
		if ($childEditor != null) {
			$attribute = $childEditor->getAttribute();
			$type = $attribute->type;
			$value = $record->getAttributeValue($attribute);
			$idPath->pushAttribute($attribute);
				
			if ($childEditor instanceof RecordTableCellEditor)			
				$result .= getRecordAsEditTableCells($idPath, $childEditor, $visibleAttribute->type, $value, $startColumn); 
			else {	
				if ($childEditor->showEditField($idPath))
					$displayValue = $childEditor->edit($idPath, $value);
				else
					$displayValue = "";
				
				$result .= '<td class="'. getHTMLClassForType($type, $attribute) .' column-'. parityClass($startColumn) . '">'. $displayValue . '</td>';
					
				$startColumn++;
			}
			
			$idPath->popAttribute();
		}
		else 
			$result .= "<td/>";
	}
	
	return $result;
}

?>
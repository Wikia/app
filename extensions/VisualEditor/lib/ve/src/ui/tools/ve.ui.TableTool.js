/*!
 * VisualEditor UserInterface ListTool classes.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* Tools */

ve.ui.InsertTableTool = function VeUiInsertTableTool( toolGroup, config ) {
	ve.ui.Tool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.InsertTableTool, ve.ui.Tool );
ve.ui.InsertTableTool.static.name = 'insertTable';
ve.ui.InsertTableTool.static.group = 'insert';
ve.ui.InsertTableTool.static.icon = 'table';
ve.ui.InsertTableTool.static.title = OO.ui.deferMsg( 'visualeditor-table-insert-table' );
ve.ui.InsertTableTool.static.commandName = 'insertTable';
ve.ui.toolFactory.register( ve.ui.InsertTableTool );

ve.ui.DeleteTableTool = function VeUiDeleteTableTool( toolGroup, config ) {
	ve.ui.Tool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.DeleteTableTool, ve.ui.Tool );
ve.ui.DeleteTableTool.static.name = 'deleteTable';
ve.ui.DeleteTableTool.static.group = 'table';
ve.ui.DeleteTableTool.static.autoAddToCatchall = false;
ve.ui.DeleteTableTool.static.icon = 'remove';
ve.ui.DeleteTableTool.static.title = OO.ui.deferMsg( 'visualeditor-table-delete-table' );
ve.ui.DeleteTableTool.static.commandName = 'deleteTable';
ve.ui.toolFactory.register( ve.ui.DeleteTableTool );

ve.ui.MergeCellsTool = function VeUiMergeCellsTool( toolGroup, config ) {
	ve.ui.Tool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MergeCellsTool, ve.ui.Tool );
ve.ui.MergeCellsTool.static.name = 'mergeCells';
ve.ui.MergeCellsTool.static.group = 'table';
ve.ui.MergeCellsTool.static.autoAddToCatchall = false;
ve.ui.MergeCellsTool.static.icon = 'tableMergeCells';
ve.ui.MergeCellsTool.static.title =
	OO.ui.deferMsg( 'visualeditor-table-merge-cells' );
ve.ui.MergeCellsTool.static.commandName = 'mergeCells';
ve.ui.MergeCellsTool.static.deactivateOnSelect = false;

ve.ui.MergeCellsTool.prototype.onUpdateState = function ( fragment ) {
	// Parent method
	ve.ui.MergeCellsTool.super.prototype.onUpdateState.apply( this, arguments );

	if ( this.isDisabled() ) {
		this.setActive( false );
		return;
	}

	// If not disabled, selection must be table and spanning multiple matrix cells
	this.setActive( fragment.getSelection().isSingleCell() );
};
ve.ui.toolFactory.register( ve.ui.MergeCellsTool );

ve.ui.TableCaptionTool = function VeUiTableCaptionTool( toolGroup, config ) {
	ve.ui.Tool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.TableCaptionTool, ve.ui.Tool );
ve.ui.TableCaptionTool.static.name = 'tableCaption';
ve.ui.TableCaptionTool.static.group = 'table';
ve.ui.TableCaptionTool.static.autoAddToCatchall = false;
ve.ui.TableCaptionTool.static.icon = 'tableCaption';
ve.ui.TableCaptionTool.static.title =
	OO.ui.deferMsg( 'visualeditor-table-caption' );
ve.ui.TableCaptionTool.static.commandName = 'tableCaption';
ve.ui.TableCaptionTool.static.deactivateOnSelect = false;

ve.ui.TableCaptionTool.prototype.onUpdateState = function ( fragment ) {
	var hasCaptionNode, selection;
	// Parent method
	ve.ui.TableCaptionTool.super.prototype.onUpdateState.apply( this, arguments );

	if ( this.isDisabled() ) {
		this.setActive( false );
		return;
	}

	selection = fragment.getSelection();

	if ( selection instanceof ve.dm.TableSelection ) {
		hasCaptionNode = !!selection.getTableNode().getCaptionNode();
	} else {
		// If not disabled, linear selection must have a caption
		hasCaptionNode = true;
	}
	this.setActive( hasCaptionNode );
};
ve.ui.toolFactory.register( ve.ui.TableCaptionTool );

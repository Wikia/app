/*!
 * VisualEditor UserInterface Actions TableAction tests.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.ui.TableAction' );

/* Tests */

function runTableActionTest( assert, html, method, args, selection, expectedData, expectedSelection, msg ) {
	var surface = ve.test.utils.createModelOnlySurfaceFromHtml( html || ve.dm.example.html ),
		tableAction = new ve.ui.TableAction( surface ),
		data = ve.copy( surface.getModel().getDocument().getFullData() );

	expectedData( data );
	surface.getModel().setSelection( ve.dm.Selection.static.newFromJSON( surface.getModel().getDocument(), selection ) );
	tableAction[ method ].apply( tableAction, args );

	assert.equalLinearData( surface.getModel().getDocument().getFullData(), data, msg + ': data models match' );
	if ( expectedSelection ) {
		assert.deepEqual( surface.getModel().getSelection().toJSON(), expectedSelection, msg + ': selections match' );
	}
}

QUnit.test( 'create / insert / mergeCells / delete / changeCellStyle / caption', function ( assert ) {
	var i,
		expected = 0,
		tableCellTail = [
			{ type: 'paragraph', internal: { generated: 'wrapper' } },
			{ type: '/paragraph' },
			{ type: '/tableCell' }
		],
		tableHeader = [
			{
				type: 'tableCell',
				attributes: {
					colspan: 1,
					rowspan: 1,
					style: 'header'
				}
			}
		].concat( tableCellTail ),
		tableData = [
			{
				type: 'tableCell',
				attributes: {
					colspan: 1,
					rowspan: 1,
					style: 'data'
				}
			}
		].concat( tableCellTail ),
		cases = [
			{
				selection: {
					type: 'linear',
					range: new ve.Range( 0 )
				},
				method: 'create',
				args: [ {
					cols: 1,
					rows: 1,
					attributes: { sortable: true }
				} ],
				expectedData: function ( data ) {
					data.splice.apply( data, [ 0, 0 ].concat(
						[
							{ type: 'table', attributes: { sortable: true } },
							{ type: 'tableSection', attributes: { style: 'body' } },
							{ type: 'tableRow' }
						],
						tableData,
						[
							{ type: '/tableRow' },
							{ type: '/tableSection' },
							{ type: '/table' }
						]
					) );
				},
				expectedSelection: {
					type: 'table',
					tableRange: new ve.Range( 0, 10 ),
					fromCol: 0,
					fromRow: 0,
					toCol: 0,
					toRow: 0
				},
				msg: 'create single cell table with attributes'
			},
			{
				selection: {
					type: 'linear',
					range: new ve.Range( 0 )
				},
				method: 'create',
				args: [ {
					cols: 3,
					rows: 2,
					header: true
				} ],
				expectedData: function ( data ) {
					data.splice.apply( data, [ 0, 0 ].concat(
						[
							{ type: 'table' },
							{ type: 'tableSection', attributes: { style: 'body' } },
							{ type: 'tableRow' }
						],
						tableHeader,
						tableHeader,
						tableHeader,
						[
							{ type: '/tableRow' },
							{ type: 'tableRow' }
						],
						tableData,
						tableData,
						tableData,
						[
							{ type: '/tableRow' },
							{ type: 'tableRow' }
						],
						tableData,
						tableData,
						tableData,
						[
							{ type: '/tableRow' },
							{ type: '/tableSection' },
							{ type: '/table' }
						]
					) );
				},
				msg: 'create small table with header'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 5,
					fromRow: 1,
					toCol: 5,
					toRow: 1
				},
				method: 'insert',
				args: [ 'col', 'after' ],
				expectedData: function ( data ) {
					data.splice.apply( data, [ 168, 0 ].concat( tableData ) );
					data.splice.apply( data, [ 130, 0 ].concat( tableData ) );
					data.splice.apply( data, [ 116, 0 ].concat( tableData ) );
					data.splice.apply( data, [ 102, 0 ].concat( tableData ) );
					data.splice.apply( data, [ 82, 0 ].concat( tableData ) );
					data.splice.apply( data, [ 56, 0 ].concat( tableData ) );
					data.splice.apply( data, [ 33, 0 ].concat( tableData ) );
				},
				expectedSelection: {
					type: 'table',
					tableRange: new ve.Range( 0, 199 ),
					fromCol: 5,
					fromRow: 1,
					toCol: 5,
					toRow: 1
				},
				msg: 'insert column at end of table'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 3,
					fromRow: 0,
					toCol: 3,
					toRow: 0
				},
				method: 'insert',
				args: [ 'col', 'before' ],
				expectedData: function ( data ) {
					data.splice.apply( data, [ 150, 0 ].concat( tableData ) );
					data[ 90 ].attributes.colspan = 4;
					data.splice.apply( data, [ 76, 0 ].concat( tableData ) );
					data.splice.apply( data, [ 45, 0 ].concat( tableData ) );
					data.splice.apply( data, [ 18, 0 ].concat( tableData ) );
				},
				msg: 'insert column in middle of table'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 0,
					fromRow: 6,
					toCol: 0,
					toRow: 6
				},
				method: 'insert',
				args: [ 'row', 'after' ],
				expectedData: function ( data ) {
					data.splice.apply( data, [ 169, 0 ].concat(
						[
							{ type: 'tableRow' }
						],
						tableData,
						tableData,
						tableData,
						tableData,
						tableData,
						tableData,
						[
							{ type: '/tableRow' }
						] )
					);
				},
				msg: 'insert row at end of table'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 0,
					fromRow: 3,
					toCol: 0,
					toRow: 3
				},
				method: 'insert',
				args: [ 'row', 'before' ],
				expectedData: function ( data ) {
					data[ 45 ].attributes.rowspan = 5;
					data.splice.apply( data, [ 83, 0 ].concat(
						[
							{ type: 'tableRow' }
						],
						tableData,
						tableData,
						tableData,
						tableData,
						tableData,
						[
							{ type: '/tableRow' }
						] )
					);
				},
				msg: 'insert row in middle of table'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 0,
					fromRow: 0,
					toCol: 2,
					toRow: 1
				},
				method: 'mergeCells',
				args: [],
				expectedData: function ( data ) {
					data[ 3 ].attributes.colspan = 3;
					data[ 3 ].attributes.rowspan = 2;
					data.splice( 40, 5 );
					data.splice( 35, 5 );
					data.splice( 13, 5 );
					data.splice( 8, 5 );
				},
				msg: 'merge cells'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 1,
					fromRow: 3,
					toCol: 3,
					toRow: 5
				},
				method: 'mergeCells',
				args: [],
				expectedData: function ( data ) {
					data[ 90 ].attributes.colspan = 1;
					data[ 90 ].attributes.rowspan = 1;
					data.splice.apply( data, [ 124, 0 ].concat( tableData, tableData, tableData ) );
					data.splice.apply( data, [ 110, 0 ].concat( tableData, tableData, tableData ) );
					data.splice.apply( data, [ 96, 0 ].concat( tableData, tableData ) );
				},
				msg: 'unmerge cells'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 0,
					fromRow: 0,
					toCol: 5,
					toRow: 5
				},
				method: 'mergeCells',
				args: [],
				expectedData: function ( data ) {
					data[ 3 ].attributes.colspan = 6;
					data[ 3 ].attributes.rowspan = 1;
					data.splice( 8, 122 );
				},
				msg: 'merge full rows'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 0,
					fromRow: 0,
					toCol: 3,
					toRow: 6
				},
				method: 'mergeCells',
				args: [],
				expectedData: function ( data ) {
					data[ 3 ].attributes.colspan = 1;
					data[ 3 ].attributes.rowspan = 7;
					data.splice( 132, 24 );
					data.splice( 118, 6 );
					data.splice( 104, 6 );
					data.splice( 84, 12 );
					data.splice( 58, 18 );
					data.splice( 35, 10 );
					data.splice( 8, 15 );
				},
				msg: 'merge full columns'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 0,
					fromRow: 0,
					toCol: 0,
					toRow: 0
				},
				method: 'delete',
				args: [ 'table' ],
				expectedData: function ( data ) {
					data.splice( 0, 171,
						{ type: 'paragraph' },
						{ type: '/paragraph' }
					);
				},
				msg: 'delete whole table'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 0,
					fromRow: 3,
					toCol: 0,
					toRow: 3
				},
				method: 'delete',
				args: [ 'row' ],
				expectedData: function ( data ) {
					data[ 90 ].attributes.rowspan = 2;
					data[ 45 ].attributes.rowspan = 3;
					data.splice( 110, 0,
						{
							type: 'tableCell',
							attributes: {
								colspan: 3,
								rowspan: 2,
								style: 'data'
							}
						},
						{ type: 'paragraph', internal: { generated: 'wrapper' } },
						'1', '6',
						{ type: '/paragraph' },
						{ type: '/tableCell' }
					);
					data.splice( 83, 20 );
				},
				expectedSelection: { type: 'null' },
				msg: 'delete row'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 3,
					fromRow: 0,
					toCol: 3,
					toRow: 0
				},
				method: 'delete',
				args: [ 'col' ],
				expectedData: function ( data ) {
					data[ 90 ].attributes.colspan = 2;
					data.splice( 150, 6 );
					data.splice( 18, 5 );
				},
				expectedSelection: { type: 'null' },
				msg: 'delete column'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 1,
					fromRow: 0,
					toCol: 2,
					toRow: 1
				},
				method: 'changeCellStyle',
				args: [ 'header' ],
				expectedData: function ( data ) {
					data[ 8 ].attributes.style = 'header';
					data[ 13 ].attributes.style = 'header';
					data[ 40 ].attributes.style = 'header';
				},
				msg: 'change style to header'
			},
			{
				html: ve.dm.example.mergedCellsHtml,
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 171 ),
					fromCol: 0,
					fromRow: 0,
					toCol: 0,
					toRow: 0
				},
				method: 'caption',
				args: [],
				expectedData: function ( data ) {
					data.splice( 1, 0,
						{ type: 'tableCaption' },
						{ type: 'paragraph', internal: { generated: 'wrapper' } },
						{ type: '/paragraph' },
						{ type: '/tableCaption' }
					);
				},
				expectedSelection: {
					type: 'linear',
					range: new ve.Range( 3 )
				},
				msg: 'add caption'
			},
			{
				html: '<table><caption>Foo</caption><tr><td>Bar</td></tr></table>',
				selection: {
					type: 'table',
					tableRange: new ve.Range( 0, 20 ),
					fromCol: 0,
					fromRow: 0,
					toCol: 0,
					toRow: 0
				},
				method: 'caption',
				args: [],
				expectedData: function ( data ) {
					data.splice( 1, 7 );
				},
				msg: 'remove caption from table selection'
			},
			{
				html: '<table><caption>Foo</caption><tr><td>Bar</td></tr></table>',
				selection: {
					type: 'linear',
					range: new ve.Range( 5 )
				},
				method: 'caption',
				args: [],
				expectedData: function ( data ) {
					data.splice( 1, 7 );
				},
				msg: 'remove caption from linear selection inside caption'
			}
		];

	for ( i = 0; i < cases.length; i++ ) {
		expected++;
		if ( cases[ i ].expectedSelection ) {
			expected++;
		}
	}
	QUnit.expect( expected );
	for ( i = 0; i < cases.length; i++ ) {
		runTableActionTest(
			assert, cases[ i ].html, cases[ i ].method, cases[ i ].args, cases[ i ].selection,
			cases[ i ].expectedData, cases[ i ].expectedSelection, cases[ i ].msg
		);
	}
} );

/*!
 * VisualEditor UserInterface PagedLayout tests.
 */

( function ( QUnit ) {
	var negativeTestCases = [ 0, null, false, undefined, 'idontexist' ];

	QUnit.module( 'OO.ui.PagedLayout', {
		setup: function () {
			var context = ve.Element.getJQuery( document );
			// FIXME: OO.ui.PanelLayout always assumes it's in a frame (maybe it shouldn't do that).
			context.frame = { dir: 'ltr' };
			this.pagedLayout = new OO.ui.PagedLayout( { '$': context } );
		},
		teardown: function () {
			this.pagedLayout = null;
		}
	} );

	QUnit.test( 'addPage', function ( assert ) {
		var count = 5,
			i,
			pageName;

		this.pagedLayout.on( 'add', function ( name, page ) {
			assert.equal( name, pageName, 'Page "' + pageName + '"" added' );
			assert.ok( page instanceof OO.ui.PanelLayout, 'Page is OO.ui.PanelLayout' );
			assert.ok( page.$element.find( '.' + pageName ).length, 'Page contains proper jQuery object' );
		} );

		for ( i = 1; i <= count; i++ ) {
			pageName = 'page' + i;
			this.pagedLayout.addPage( pageName, { '$content': $( '<div>' ).addClass( pageName ) } );
		}

		// FIXME: Calling addPage without passing the 'name' parameter will create a page under the
		// key 'undefined' -- this is probably not what we want.
		pageName = undefined;
		this.pagedLayout.addPage( pageName, {
			'$content': $( '<div>' ).addClass( 'undefined' )
		} );

		QUnit.expect( ( count + 1 ) * 3 );
	} );

	QUnit.test( 'clearPages', function ( assert ) {
		var $content = $( '<div>' ),
			count = 5,
			i,
			j;

		this.pagedLayout.on( 'remove', function ( pages ) {
			assert.equal( pages.length, i, j + ' pages have been cleared' );
		} );

		for ( i = 0; i < count; i++ ) {
			for ( j = 1; j <= i; j++ ) {
				this.pagedLayout.addPage( 'page' + j, { '$content': $content } );
			}

			this.pagedLayout.clearPages();
		}

		QUnit.expect( count );
	} );

	QUnit.test( 'getPage', function ( assert ) {
		var count = 5,
			i,
			page,
			pageName;

		for ( i = 1; i <= count; i++ ) {
			pageName = 'page' + i;
			this.pagedLayout.addPage( pageName, { '$content': $( '<div>' ).addClass( pageName ) });
		}

		for ( i = count; i > 0; i-- ) {
			pageName = 'page' + i;
			page = this.pagedLayout.getPage( pageName );
			assert.ok( page instanceof OO.ui.PanelLayout, 'Got page  "' + pageName + '"' );
			assert.ok( page.$element.find( '.' + pageName ).length, 'Page contains proper jQuery object' );
		}

		for ( i = 0; i < negativeTestCases.length; i++ ) {
			assert.equal(
				this.pagedLayout.getPage( negativeTestCases[i] ),
				undefined,
				'Unknown page "' + negativeTestCases[i] + '" returns undefined.'
			);
		}

		QUnit.expect( count * 2 + negativeTestCases.length );
	} );

	QUnit.test( 'removePage', function ( assert ) {
		var count = 5,
			i,
			pageName;

		this.pagedLayout.on( 'remove', function ( pages ) {
			assert.ok( pages.length === 1, 'One page was removed' );
			assert.ok( pages[0] instanceof OO.ui.PanelLayout, 'Removed page is OO.ui.PanelLayout' );
			assert.ok(
				pages[0].$element.find( '.' + pageName ).length,
				'Removed page contains proper jQuery object'
			);
		} );

		for ( i = 1; i <= count; i++ ) {
			pageName = 'page' + i;
			this.pagedLayout.addPage( pageName, { '$content': $( '<div>' ).addClass( pageName ) } );
		}

		for ( i = count; i > 0; i-- ) {
			pageName = 'page' + i;
			this.pagedLayout.removePage( pageName );
		}

		for ( i = 0; i < negativeTestCases.length; i++ ) {
			this.pagedLayout.removePage( negativeTestCases[i] );
		}

		QUnit.expect( count * 3 );
	} );

	QUnit.test( 'setPage / getPageName', function ( assert ) {
		var count = 5,
			i,
			pageName;

		this.pagedLayout.on( 'set', function ( page ) {
			assert.ok( page instanceof OO.ui.PanelLayout, 'Page is OO.ui.PanelLayout' );
			assert.ok( page.$element.find( '.' + pageName ).length, 'Page contains proper jQuery object' );
		} );

		for ( i = 1; i <= count; i++ ) {
			pageName = 'page' + i;
			this.pagedLayout.addPage( pageName, { '$content': $( '<div>' ).addClass( pageName ) } );
		}

		for ( i = count; i > 0; i-- ) {
			pageName = 'page' + i;
			this.pagedLayout.setPage( pageName );
			assert.equal(
				this.pagedLayout.getPageName(), pageName, 'Page name is "' + pageName + '"'
			);
		}

		for ( i = 0; i < negativeTestCases.length; i++ ) {
			this.pagedLayout.setPage( negativeTestCases[i] );
			assert.equal(
				this.pagedLayout.getPageName(),
				pageName,
				'After setPage is called with "' + negativeTestCases[i] + '", ' +
				'Page name is still "' + pageName + '"'
			);
		}

		QUnit.expect( count * 3 + negativeTestCases.length );
	} );

}( QUnit ) );

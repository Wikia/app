describe( 'TOC', function() {
	'use strict';

	// Helper functions
	var getHeaders = function( html ) {
			return html.querySelectorAll( 'h2, h3, h4, h5' );
		},
		getHeader = function ( header ) {
			return header;
		},
		createTOCSection = function( header, tocLevel ) {
			return {
				title: header.textContent,
				class: 'toclevel-' + tocLevel,
				sections: []
			};
		},
		// other vars
		html = getBody(),
		htmlContent,
		data,
		dataMock,
		headers,
		// TOC module
		toc = modules[ 'wikia.toc' ]();

	it( 'registers AMD module', function() {
		expect( typeof toc ).toBe( 'object' );
		expect( typeof toc.getData ).toBe( 'function' );
	});

	it( 'works for one level deep TOC', function() {

		htmlContent = '<h2>test</h2><h2>test</h2><h2>test</h2>';
		dataMock = {
			sections: [
				{
					title: 'test',
					class:  'toclevel-1',
					sections: []
				},
				{
					title: 'test',
					class:  'toclevel-1',
					sections: []
				},{
					title: 'test',
					class:  'toclevel-1',
					sections: []
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders( html );
		data = toc.getData( headers, createTOCSection, getHeader );

		expect( JSON.stringify( data ) ).toBe( JSON.stringify( dataMock ) );
	});

	it( 'works for simple nested TOC', function() {

		htmlContent = '<h2>test</h2><h3>test</h3><h4>test</h4><h5>test</h5>';
		dataMock = {
			sections: [
				{
					title: 'test',
					class:  'toclevel-1',
					sections: [
						{
							title: 'test',
							class:  'toclevel-2',
							sections: [
								{
									title: 'test',
									class:  'toclevel-3',
									sections: [
										{
											title: 'test',
											class:  'toclevel-4',
											sections: []
										}
									]
								}
							]
						}
					]
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders( html );
		data = toc.getData( headers, createTOCSection, getHeader );

		expect( JSON.stringify( data ) ).toBe( JSON.stringify( dataMock ) );
	});

	it( 'works for complex nested TOC', function() {

		htmlContent = '<h2>test</h2><h3>test</h3><h3>test</h3><h2>test</h2>' +
			'<h4>test</h4><h3>test</h3><h4>test</h4><h5>test</h5><h2>test</h2>';
		dataMock = {
			sections: [
				{
					title: 'test',
					class:  'toclevel-1',
					sections: [
						{
							title: 'test',
							class:  'toclevel-2',
							sections: []
						},
						{
							title: 'test',
							class:  'toclevel-2',
							sections: []
						}
					]
				},
				{
					title: 'test',
					class:  'toclevel-1',
					sections: [
						{
							title: 'test',
							class:  'toclevel-2',
							sections: []
						},
						{
							title: 'test',
							class:  'toclevel-2',
							sections: [
								{
									title: 'test',
									class:  'toclevel-3',
									sections: [
										{
											title: 'test',
											class:  'toclevel-4',
											sections: []
										}
									]
								}
							]
						}
					]
				},
				{
					title: 'test',
					class:  'toclevel-1',
					sections: []
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders( html );
		data = toc.getData( headers, createTOCSection, getHeader );

		expect( JSON.stringify( data ) ).toBe( JSON.stringify( dataMock ) );
	});

	it( 'works for flat TOC', function() {

		htmlContent = '<h2>test</h2><h2>test</h2><h2>test</h2>';
		dataMock = {
			sections: [
				{
					title: 'test',
					class:  'toclevel-1',
					sections: []
				},
				{
					title: 'test',
					class:  'toclevel-1',
					sections: []
				},
				{
					title: 'test',
					class:  'toclevel-1',
					sections: []
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders( html );
		data = toc.getData( headers, createTOCSection, getHeader );

		expect( JSON.stringify( data ) ).toBe( JSON.stringify( dataMock ) );
	});

	it( 'works for broken TOC', function() {

		htmlContent = '<h3>test3</h3><h4>test4</h4><h2>test2</h2><h5>test5</h5>';
		dataMock = {
			sections: [
				{
					title: 'test3',
					class:  'toclevel-1',
					sections: [
						{
							title: 'test4',
							class:  'toclevel-2',
							sections: []
						}
					]
				},
				{
					title: 'test2',
					class:  'toclevel-1',
					sections: [
						{
							title: 'test5',
							class:  'toclevel-2',
							sections: []
						}
					]
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders( html );
		data = toc.getData( headers, createTOCSection, getHeader );

		expect( JSON.stringify( data ) ).toBe( JSON.stringify( dataMock ) );
	});

	it( 'works for reversed TOC', function() {

		htmlContent = '<h5>test5</h5><h4>test4</h4><h3>test3</h3><h2>test2</h2>';
		dataMock = {
			sections: [
				{
					title: 'test5',
					class:  'toclevel-1',
					sections: []
				},
				{
					title: 'test4',
					class:  'toclevel-1',
					sections: []
				},
				{
					title: 'test3',
					class:  'toclevel-1',
					sections: []
				},
				{
					title: 'test2',
					class:  'toclevel-1',
					sections: []
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders( html );
		data = toc.getData( headers, createTOCSection, getHeader );

		expect( JSON.stringify( data ) ).toBe( JSON.stringify( dataMock ) );
	});

	it( 'works for missed heading steps', function() {

		htmlContent = '<h2>test2</h2><h3>test3</h3><h2>test2</h2><h4>test4</h4>';
		dataMock = {
			sections: [
				{
					title: 'test2',
					class:  'toclevel-1',
					sections: [
						{
							title: 'test3',
							class:  'toclevel-2',
							sections: []
						}
					]
				},
				{
					title: 'test2',
					class:  'toclevel-1',
					sections: [
						{
							title: 'test4',
							class:  'toclevel-2',
							sections: []
						}
					]
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders( html );
		data = toc.getData( headers, createTOCSection, getHeader );

		expect( JSON.stringify( data ) ).toBe( JSON.stringify( dataMock ) );
	});

	it( 'works for http://kirkburn.wikia.com/wiki/Test5347a', function() {

		htmlContent = '<h3>Heading 3</h3><h4>Heading 4</h4><h5>Heading 5 1</h5><h5>Heading 5 2</h5>';
		dataMock = {
			sections: [
				{
					title: 'Heading 3',
					class:  'toclevel-1',
					sections: [
						{
							title: 'Heading 4',
							class:  'toclevel-2',
							sections: [
								{
									title: 'Heading 5 1',
									class:  'toclevel-3',
									sections: []
								},
								{
									title: 'Heading 5 2',
									class:  'toclevel-3',
									sections: []
								}
							]
						}
					]
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders( html );
		data = toc.getData( headers, createTOCSection, getHeader );

		expect( JSON.stringify( data ) ).toBe( JSON.stringify( dataMock ) );
	});

	it( 'works for http://kirkburn.wikia.com/wiki/Test5347b', function() {

		htmlContent = '<h3>Heading 3</h3><h3>Heading 3</h3><h4>Heading 4</h4><h5>Heading 5 1</h5><h5>Heading 5 2</h5>';
		dataMock = {
			sections: [
				{
					title: 'Heading 3',
					class:  'toclevel-1',
					sections: []
				},
				{
					title: 'Heading 3',
					class:  'toclevel-1',
					sections: [
						{
							title: 'Heading 4',
							class:  'toclevel-2',
							sections: [
								{
									title: 'Heading 5 1',
									class:  'toclevel-3',
									sections: []
								},
								{
									title: 'Heading 5 2',
									class:  'toclevel-3',
									sections: []
								}
							]
						}
					]
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders( html );
		data = toc.getData( headers, createTOCSection, getHeader );

		expect( JSON.stringify( data ) ).toBe( JSON.stringify( dataMock ) );
	});
});

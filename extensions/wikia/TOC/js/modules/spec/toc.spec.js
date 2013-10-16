describe('TOC', function() {

	// Helper functions
	var	getHeaders = function(html) {
			return html.querySelectorAll('h2, h3, h4, h5');
		},
		createTOCSection = function(header) {
			return {
				title: header.textContent,
				sections: []
			}
		},
		// other vars
		html = getBody(),
		htmlContent,
		data,
		dataMock,
		headers,
		// TOC module
		toc = modules['wikia.toc']();

	it('registers AMD module', function() {
		expect(typeof toc).toBe('object');
		expect(typeof toc.getData).toBe('function');
	});

	it('works for one level deep TOC', function(){

	    htmlContent = '<h2>test</h2><h2>test</h2><h2>test</h2>';
		dataMock = {
			sections: [
				{
					title: 'test',
					sections: []
				},
				{
					title: 'test',
					sections: []
				},{
					title: 'test',
					sections: []
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders(html);
		data = toc.getData(headers, createTOCSection);

		expect(JSON.stringify(data)).toBe(JSON.stringify(dataMock));
	});

	it('works for simple nested TOC', function() {

		htmlContent = '<h2>test</h2><h3>test</h3><h4>test</h4><h5>test</h5>';
		dataMock = {
			sections: [
				{
					title: 'test',
					sections: [
						{
							title: 'test',
							sections: [
								{
									title: 'test',
									sections: [
										{
											title: 'test',
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
		headers = getHeaders(html);
		data = toc.getData(headers, createTOCSection);

		expect(JSON.stringify(data)).toBe(JSON.stringify(dataMock));
	});

	it('works for complex nested TOC', function() {

		htmlContent = '<h2>test</h2><h3>test</h3><h3>test</h3><h2>test</h2><h4>test</h4><h3>test</h3><h4>test</h4><h5>test</h5><h2>test</h2>';
		dataMock = {
			sections: [
				{
					title: 'test',
					sections: [
						{
							title: 'test',
							sections: []
						},
						{
							title: 'test',
							sections: []
						}
					]
				},
				{
					title: 'test',
					sections: [
						{
							title: 'test',
							sections: []
						},
						{
							title: 'test',
							sections: [
								{
									title: 'test',
									sections: [
										{
											title: 'test',
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
					sections: []
				}
			]
		};

		html.innerHTML = htmlContent;
		headers = getHeaders(html);
		data = toc.getData(headers, createTOCSection);

		expect(JSON.stringify(data)).toBe(JSON.stringify(dataMock));
	});

});

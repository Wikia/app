/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Tables module", function () {
	var body = getBody();

	body.innerHTML = '<div id="mw-content-text"><table id="TESTTABLE"><tbody><tr style="min-width: 99999px;"><td>some content to TEST wide table</td><td>and some more</td></tr><tr><td></td></tr></tbody></table></div>';

	var origFeatures,
		tables = modules.tables(
		{
			touch: 'click'
		},
		{
			track: function(){}
		},
		{
			Features: {},
			iScroll: function(){},
			addEventListener: function(){

			},
			document: document
		},
		jQuery
	);

	beforeEach(function(){
		origFeatures = window.Features;

		body = getBody();

		body.innerHTML = '<div id="mw-content-text"><table ><tbody><tr><td>TESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTESTTEST</td><td>and some more</td></tr><tr><td></td></tr></tbody></table></div>';

		window.Features = {
			overflow: false
		};
	});

	afterEach(function(){
		window.Features = origFeatures;
	});

	it('is defined', function(){
		expect(tables).toBeDefined();
		expect(typeof tables.process).toBe('function');
	});

	it('should wrap/unwrap table', function(){
		var tab = $(body).find('table');

		tables.process(tab);

		var table = body.getElementsByTagName('table')[0];

		expect(table.parentElement.id).not.toBe("mw-content-text");
		expect(table.parentElement.className).toBe('bigTable');
	});

	it('should add wkScroll to bitTable', function(){
		var foundTables = $(body).find('table');

		tables.process(foundTables);

		var table = body.getElementsByTagName('table')[0];

		fireEvent('click', table.parentElement);

		expect(table.parentElement.className).toMatch('active');
		expect(table.wkScroll).toBeTruthy();

	});
});
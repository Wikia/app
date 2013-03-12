/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Tables module", function () {
	var body = getBody();

	body.innerHTML = '<div id="mw-content-text"><table style="width:2000px"><tr><td></td></tr></table><table><tr><td></td></tr></table></div>';

	var tables = modules.tables(
		{
			touch: 'click'
		},
		{
			track: function(){}
		},
		{
			Features: {},
			iScroll: function(){}
		}
	);

	it('is defined', function(){
		expect(tables).toBeDefined();
		expect(typeof tables.process).toBe('function');
	});

	it('should wrap/unwrap table', function(){
		var tab = body.getElementsByTagName('table');

		tables.process(tab);

		var table = body.getElementsByTagName('table')[0];

		expect(table.parentElement.id).not.toBe("mw-content-text");
		expect(table.parentElement.className).toBe('bigTable');

//			fire('viewportsize', window);
//
//			table = document.getElementsByTagName('table')[0];
//
//			expect(table.parentElement.id).toBe("mw-content-text");
//			expect(table.parentElement.className).not.toBe('bigTable');
	});

	it('should add wkScroll to bitTable', function(){
		var body = getBody();
		body.innerHTML = '<div id="mw-content-text"><table style="width:2000px"><tr><td></td></tr></table><table><tr><td></td></tr></table></div>';

		var tab = body.getElementsByTagName('table');

		tables.process(tab);

		var table = body.getElementsByTagName('table')[0];

		fireEvent('click', table.parentElement);

		expect(table.parentElement.className).toMatch('active');
		expect(table.parentElement.wkScroll).toBe(true);

	});
});
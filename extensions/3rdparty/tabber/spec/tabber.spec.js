/* global describe, expect, it, $ */
describe('Tabber', function () {
	it('creates navigation tabs from provided tab titles', function () {
		var tabber = '<div class="tabber">' +
			'<div class="tabbertab" title="Tab1"></div>' +
			'<div class="tabbertab" title="Tab2"></div>' +
			'<div class="tabbertab" title="Tab3"></div>' +
			'</div>';

		var $tabber = $(tabber).tabber(),
			$tabs = $tabber.find('ul.tabbernav li');

		expect($tabber.find('ul.tabbernav:first-child').length).toBeTruthy();
		expect($tabs.length).toBe(3);

		$tabs.each(function (i) {
			var $tab = $(this);
			expect($tab.text()).toBe('Tab' + (i+1));
		});
	});

	it('inserts manual word break after each tab', function () {
		var tabber = '<div class="tabber">' +
			'<div class="tabbertab" title="Tab1"></div>' +
			'<div class="tabbertab" title="Tab2"></div>' +
			'<div class="tabbertab" title="Tab3"></div>' +
			'</div>';

		var $tabber = $(tabber).tabber();

		expect($tabber.find('li+wbr').length).toBe(3);
	});

	it('replaces spaces in tab titles with non-breaking spaces', function () {
		var tabber = '<div class="tabber">' +
			'<div class="tabbertab" title="Tab Title 1"></div>' +
			'<div class="tabbertab" title="Tab Title 2"></div>' +
			'<div class="tabbertab" title="Tab Title 3"></div>' +
			'</div>';

		var $tabber = $(tabber).tabber();

		$tabber.find('ul.tabbernav li').each(function (i) {
			expect($(this).text()).toBe('Tab\u00A0Title\u00A0' + (i+1));
		});
	});
});

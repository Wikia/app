describe('Tabber', function () {
	var $tabber;

	beforeEach(function() {
		var tabber = '<div class="tabber">' +
			'<div class="tabbertab" title="Tab1"></div>' +
			'<div class="tabbertab" title="Tab2"></div>' +
			'<div class="tabbertab" title="Tab3"></div>' +
			'</div>';

		$tabber = $(tabber).tabber();
	});

	it('creates navigation tabs from provided tab titles', function () {
		var $tabs = $tabber.find('ul.tabbernav li');

		expect($tabber.find('ul.tabbernav:first-child').length).toBeTruthy();
		expect($tabs.length).toBe(3);

		$tabs.each(function (i) {
			var $tab = $(this);
			expect($tab.text()).toBe('Tab' + (i+1));
		});
	});

	it('inserts manual word break after each tab', function () {
		expect($tabber.find('ul.tabbernav li+wbr').length).toBe(3);
	});

	it('displays contents of first tab initially', function () {
		var $firstTab = $tabber.find('ul.tabbernav li:first');

		expect($firstTab.hasClass('tabberactive')).toBe(true);
	});

	it('displays contents of tab specified in URL hash', function () {
		window.location.hash = '#Tab3';

		var otherTabber = '<div class="tabber">' +
			'<div class="tabbertab" title="Tab1"></div>' +
			'<div class="tabbertab" title="Tab2"></div>' +
			'<div class="tabbertab" title="Tab3"></div>' +
			'</div>';

		var $otherTabber = $(otherTabber).tabber(),
			$lastTab = $otherTabber.find('ul.tabbernav a:last');;

		expect(window.location.hash).toBe('#Tab3');
		expect($lastTab.parent().hasClass('tabberactive')).toBe(true);
	});

	it('responds to clicks on navigation tabs', function () {
		var $lastTab = $tabber.find('ul.tabbernav a:last');

		$lastTab.click();

		expect(window.location.hash).toBe('#Tab3');
		expect($lastTab.parent().hasClass('tabberactive')).toBe(true);
	});

	it('fires global scroll event when tab is clicked', function () {
		var callback = {
			method: function () {}
		}, $lastTab = $tabber.find('ul.tabbernav a:last');

		spyOn(callback, 'method');

		$(window).on('scroll', callback.method);

		$lastTab.click();

		expect(callback.method).toHaveBeenCalled();
	});
});

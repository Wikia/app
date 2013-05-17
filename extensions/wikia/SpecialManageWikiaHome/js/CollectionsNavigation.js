var CollectionsNavigation = function(modulesSelector) {
	var turnOnButtons = function() {
		var nav = $(modulesSelector).find('.navigation');
		nav.removeAttr('disabled');
		nav.filter(':first, :last').attr('disabled', 'disabled');
	};

	var addButtons = function(moduleElem) {
		var button = $('<button />')
			.attr('type', 'button')
			.addClass('secondary')
			.addClass('navigation');

		var img = $('<img />')
			.attr('src', window.wgBlankImgUrl)
			.addClass('chevron');
		button.append(img);

		var buttonUp = button.clone();
		buttonUp.addClass('nav-up')
			.find('img')
			.addClass('chevron-up');
		var buttonDown = button.clone();
		buttonDown.addClass('nav-down')
			.find('img')
			.addClass('chevron-down');

		$(moduleElem).append(buttonUp, buttonDown);
	};

	var addButtonHandlers = function(modules) {
		modules.find('.navigation').click(handleClick);
	};

	var handleClick = function(event) {
		var elem = $(event.target);
		var moduleOne = elem.parents(modulesSelector + ':first');
		var moduleTwo;

		if (isNavUpElement(elem)) {
			moduleTwo = moduleOne.prev();
			switchModules(moduleTwo, moduleOne);
		} else {
			moduleTwo = moduleOne.next();
			switchModules(moduleOne, moduleTwo);
		}
		turnOnButtons();
	};

	var isNavUpElement = function(element) {
		return element.hasClass('nav-up')  || element.parent().hasClass('nav-up');
	}

	var switchModules = function(moduleOne, moduleTwo) {
		moduleOne.before(moduleTwo);
	};

	var modules = $(modulesSelector);
	modules.each(function(i, moduleElem) {
		addButtons(moduleElem);
	});
	turnOnButtons();
	addButtonHandlers(modules);
};
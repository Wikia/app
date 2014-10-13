(function(window, $) {
	'use strict';

	$(function(){
		var $localNavFirstLevel, $localNavSecondLevel, $localNav, $localNavStart, $window,
			$openedMenu, $openedSubmenu, alwaysReturnTrueFunc, menuAimCache = [],
			$contributeEntryPoint, previousThirdLvlWidth = 0;

		$localNav = $('#localNavigation');
		$localNavStart = $localNav.find('.first-level-menu');
		$localNavFirstLevel = $localNavStart.find('> .local-nav-entry');
		$localNavSecondLevel = $localNav.find('.second-level-menu');
		$contributeEntryPoint = $('#contributeEntryPoint');
		$window = $(window);

		function recalculateDropdownDirection() {
			var $this, dropdownOffset = 0, secondLvlNavWidth = 0, secondLvlNavOffset = 0,
				thirdLvlWidth = 0, windowWidth = $window.width();

			thirdLvlWidth = 239;
			if (window.matchMedia("(max-width: 1024px)").matches) {
				thirdLvlWidth = 178;
			} else if (window.matchMedia("(min-width: 1497px)").matches) {
				thirdLvlWidth = 270;
			}

			if (thirdLvlWidth === previousThirdLvlWidth) {
				return;
			}

			closeOpenedMenu();

			$localNavSecondLevel.each(function(i) {
				$this = $(this);
				secondLvlNavWidth = $this.outerWidth();
				secondLvlNavOffset = $this.offset().left;
				dropdownOffset = secondLvlNavWidth + secondLvlNavOffset + thirdLvlWidth;

				if ( dropdownOffset > windowWidth ) {
					$this.addClass('right');
					//console.log(i, secondLvlNavWidth + secondLvlNavOffset, thirdLvlWidth, windowWidth, 'right');
				} else {
					$this.removeClass('right');
					//console.log(i, secondLvlNavWidth + secondLvlNavOffset, thirdLvlWidth, windowWidth, 'left');
				}
			});

			attachMenuAim();

			previousThirdLvlWidth = thirdLvlWidth;
		}

		function reinitDropdownDirection() {
			resetMenuAim();

			recalculateDropdownDirection();
		}

		function openMenu() {
			$(this).addClass('active');
			closeContributeMenu();
		}

		function closeMenu() {
			$(this).removeClass('active');
		}

		function openSubmenu(row) {
			$(row).addClass('active');
		}

		function closeSubmenu( row ) {
			$(row).removeClass('active');
		}

		function closeOpenedMenu() {
			if ($openedMenu !== undefined) {
				$openedMenu.removeClass('active');
			}
			$openedMenu = undefined;

			closeOpenedSubmenu();
		}

		function closeOpenedSubmenu() {
			if ($openedSubmenu !== undefined) {
				$openedSubmenu.removeClass('active');
			}
			$openedSubmenu = undefined;
		}

		function handleOpenMenuClick(event) {
			var $target = $(event.currentTarget);

			event.preventDefault();
			event.stopPropagation();

			if (!$target.hasClass('active')) {
				closeOpenedMenu();
				$target.addClass('active');
			}
			$('body').one('click', handleCloseMenuClick);
			closeContributeMenu();
			$openedMenu = $target;
		}

		function handleCloseMenuClick(event) {
			var $target = $(event.currentTarget);

			if ($target.closest($localNav).length === 0 && $openedMenu !== undefined) {
				$openedMenu.removeClass('active');
				$openedMenu = undefined;
			}

			closeOpenedSubmenu();
		}

		function handleSubmenuClick(event) {
			var $target = $(event.target),
				$targetMenuItem;

			$targetMenuItem = $target.closest('.second-level-row');
			event.stopPropagation();

			if (
				!$targetMenuItem.hasClass('active') &&
				$target.closest('.has-more').length > 0 ||
				$target.find('a').first().attr('href') === '#'
			) {
				event.preventDefault();
				closeOpenedSubmenu();
				$targetMenuItem.addClass('active');
				$openedSubmenu = $targetMenuItem;
			}
		}

		function attachMenuAim() {
			var options = {};

			$localNavSecondLevel.each(function() {
				options = getMenuAimOptions(this);

				menuAimCache.push(window.menuAim(this, options));
			});
		}

		function getMenuAimOptions(element) {
			var menuAimOptions = {
				activate: openSubmenu,
				deactivate: closeSubmenu,
				rowSelector: '.second-level-row',
				exitMenu: alwaysReturnTrueFunc
			};

			if (element.classList.contains('right')) {
				$.extend(menuAimOptions, {submenuDirection: 'left'});
			}

			return menuAimOptions;
		}

		function resetMenuAim() {
			var i;

			for (i = 0; i < menuAimCache.length; i++) {
				menuAimCache[i].reset();
			}
		}

		function openContributeMenu(event) {
			if (event && event.target && $(event.target).attr('class') === 'contribute-button') {
				event.preventDefault();
				event.stopPropagation();

				$('body').one('click', closeContributeMenu);
			}

			$contributeEntryPoint.addClass('active');
			closeOpenedMenu();
		}

		function closeContributeMenu() {
			$contributeEntryPoint.removeClass('active');
		}

		alwaysReturnTrueFunc = function() {
			return true;
		};

		$(function(){
			if (!window.Wikia.isTouchScreen()) {
				window.delayedHover(
					$localNavFirstLevel,
					{
						onActivate: openMenu,
						onDeactivate: closeMenu,
						activateOnClick: false
					}
				);
			} else {
				$localNavFirstLevel.click(handleOpenMenuClick);
				$localNavSecondLevel.find('.second-level-row').click(handleSubmenuClick);
			}

			if ($contributeEntryPoint.length) {
				if (!window.Wikia.isTouchScreen()) {
					window.delayedHover(
						$contributeEntryPoint.get(0),
						{
							onActivate: openContributeMenu,
							onDeactivate: closeContributeMenu,
							activateOnClick: false
						}
					);
				} else {
					$contributeEntryPoint.click(openContributeMenu);
				}
			}

			$window.on('resize', $.debounce(300, reinitDropdownDirection));

			recalculateDropdownDirection()
		});
	});
})(window, jQuery);

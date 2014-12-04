/*
 * @define wikia.imageServing
 * module used to handle
 *
 * @author Damian Jozwiak
 */
define('wikia.imageServing', function () {
	'use strict';

	function getCutParams(originalWidth, originalHeight, expectedWidth, expectedHeight) {
		var offsetX = 0,
			offsetY = 0,
			originalProportionWidth,
			originalProportionHeight = Math.round(originalWidth * expectedHeight / expectedWidth),
			offsetYFactor,
			windowWidth = originalWidth,
			windowHeight = originalHeight;

		if (originalProportionHeight >= originalHeight) {
			originalProportionWidth = Math.round(originalHeight * expectedWidth / expectedHeight);

			offsetX = Math.round((originalWidth - originalProportionWidth) / 2);
			windowWidth -= 2 * offsetX;
		} else {
			// advanced face recognition algorithm ported from ImageServing.class.php
			offsetYFactor = (expectedWidth / expectedHeight - 1) * 0.1;
			offsetY = Math.round(expectedHeight * offsetYFactor);

			windowHeight = originalProportionHeight;
		}

		return {
			offsetX: offsetX,
			offsetY: offsetY,
			windowWidth: windowWidth,
			windowHeight: windowHeight
		};
	}

	return {
		getCutParams: getCutParams
	};
});

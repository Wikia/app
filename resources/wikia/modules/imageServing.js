/*
 * @define wikia.imageServing
 * module used to handle
 *
 * @author Damian Jozwiak
 */
define('wikia.imageServing', function () {
	'use strict';

	function getCutParams(originalWidth, originalHeight, expectedWidth, expectedHeight) {
		var xOffset1 = 0,
			yOffset1 = 0,
			xOffset2 = originalWidth,
			yOffset2 = originalHeight,
			originalProportionWidth,
			originalProportionHeight = Math.round(originalWidth * expectedHeight / expectedWidth),
			offsetYFactor;

		if (originalProportionHeight >= originalHeight) {
			originalProportionWidth = Math.round(originalHeight * expectedWidth / expectedHeight);

			xOffset1 = Math.round((originalWidth - originalProportionWidth) / 2);
			xOffset2 = originalProportionWidth + xOffset1;
		} else {
			// advanced face recognition algorithm ported from ImageServing.class.php
			offsetYFactor = (expectedWidth / expectedHeight - 1) * 0.1;
			yOffset1 = Math.round(originalHeight * offsetYFactor);

			yOffset2 = originalProportionHeight + yOffset1;
		}

		return {
			xOffset1: xOffset1,
			yOffset1: yOffset1,
			xOffset2: xOffset2,
			yOffset2: yOffset2
		};
	}

	function getThumbUrl(thumbUrl, originalWidth, originalHeight, expectedWidth, expectedHeight) {
		var cutParams = getCutParams(originalWidth, originalHeight, expectedWidth, expectedHeight);
		return Vignette.getThumbURL(thumbUrl, 'window-crop', expectedWidth, expectedHeight, cutParams);
	}

	return {
		getCutParams: getCutParams,
		getThumbUrl: getThumbUrl
	};
});

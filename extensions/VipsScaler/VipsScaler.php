<?php
/**
 * Copyright © Bryan Tong Minh, 2011
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

$wgExtensionCredits['media'][] = array(
	'path' => __FILE__,
	'name' => 'VipsScaler',
	'author' => array( 'Bryan Tong Minh' ),
	'descriptionmsg' => 'vipsscaler-desc',
	'url' => '//www.mediawiki.org/wiki/Extension:VipsScaler',
);

$dir = dirname( __FILE__ );

$wgAutoloadClasses['VipsScaler']      = "$dir/VipsScaler_body.php";
$wgAutoloadClasses['VipsCommand']     = "$dir/VipsScaler_body.php";
$wgAutoloadClasses['VipsConvolution'] = "$dir/VipsScaler_body.php";

$wgExtensionMessagesFiles['VipsScaler'] = "$dir/VipsScaler.i18n.php";

$wgHooks['BitmapHandlerTransform'][] = 'VipsScaler::onTransform';
$wgHooks['BitmapHandlerCheckImageArea'][] = 'VipsScaler::onBitmapHandlerCheckImageArea';

# Download vips from http://www.vips.ecs.soton.ac.uk/
$wgVipsCommand = 'vips';

/* Options and conditions for images to be scaled with this scaler.
 * Set to an array of arrays. The inner array contains a condition array, which
 * contains a list of conditions that the image should pass for it to be scaled
 * with vips. Conditions are mimeType, minArea, maxArea, minShrinkFactor,
 * maxShrinkFactor. The other items in the array are options. Options available
 * are:
 * - sharpen: Set to an array with keys 'radius' and 'sigma', which are
 *   parameters to gaussian sharpen matrix.
 * - preconvert: Convert the file to a .v file first, which costs some space,
 *   but saves memory on the actual downsize
 * - bilinear: Use im_resize_linear instead of im_shrink
 * - convolution: Apply specified convolution matrix
 * - setcomment: Add an exif comment specifying the source of the file.
 *   Requires $wgExiv2Command to be set properly.
 */
$wgVipsOptions = array(
	# Sharpen jpeg files which are shrunk more than 1.2
	array(
		'conditions' => array(
			'mimeType' => 'image/jpeg',
			'minShrinkFactor' => 1.2,
		),
		'sharpen' => array( 'radius' => 0, 'sigma' => 0.8 ),
	),
	# Other jpeg files
	array(
		'conditions' => array(
			'mimeType' => 'image/jpeg',
		),
		'sharpen' => false,
		'bilinear' => true,
	),
	# Do a simple shrink for PNGs
	array(
		'conditions' => array(
			'mimeType' => 'image/png',
		),
	),
);

# Package vipsScaler material in a resource loader module:
$wgResourceModules['ext.vipsscaler'] = array(
	'scripts' => array( 'ext.vipsScaler.js', ),
	'styles' => array( 'ext.vipsScaler.css' ),
	'messages' => array( 'vipsscaler-show-both', 'vipsscaler-show-default', 'vipsscaler-show-vips' ),
	'dependencies' => array(
		'jquery.ucompare',
	),

	'localBasePath' => dirname( __FILE__ ) . '/modules/ext.vipsScaler',
	'remoteExtPath' => 'VipsScaler/modules/ext.vipsScaler',
);

# Also package upstream jquery.ucompare
$wgResourceModules['jquery.ucompare'] = array(
	'scripts' => array( 'js/jquery.ucompare.js', ),
	'styles' => array( 'css/jquery.ucompare.css' ),

	'localBasePath' => dirname( __FILE__ ) . '/modules/jquery.ucompare',
	'remoteExtPath' => 'VipsScaler/modules/jquery.ucompare'
);



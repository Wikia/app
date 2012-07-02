<?php
/**
 * CategoryOnSideBar extension for MediaWiki
 * Copyright (c) 2010 - Bryan Tong Minh
 * Licensed under the terms of the MIT license
 * 
 * Extension that adds category members on the sidebar.
 */
 
/*
 Permission is hereby granted, free of charge, to any person
 obtaining a copy of this software and associated documentation
 files (the "Software"), to deal in the Software without
 restriction, including without limitation the rights to use,
 copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the
 Software is furnished to do so, subject to the following
 conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 OTHER DEALINGS IN THE SOFTWARE.
*/

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'CategoryMembersOnSidebar',
	'descriptionmsg' => 'categorymembersonsidebar-desc',
	'version' => '1.0.1',
	'author' => 'Bryan Tong Minh',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CategoryMembersOnSidebar',
);


$wgHooks['SkinBuildSidebar'][] = 'efCategoryMembersOnSidebar';

/**
 * Hook point to SkinBuildSidebar
 * 
 * Finds all top-level entries in the sidebar that have the format category:$1|$2.
 * Replaces the entry with a list of pages in Category:$1 and changes the label
 * to $2, or $1 if $2 not available.
 * 
 * @param $skin Skin
 * @param $bar array
 * @return bool True
 */
function efCategoryMembersOnSidebar( $skin, &$bar ) {
	$newbar = array();
	
	$i = 0;
	foreach ( $bar as $key => $data ) {
		# Check if this entry needs to be handled by this extension
		$matches = array();
		preg_match( '/category\:([^|]*)\|?([^|]*)/i', $key, $matches );
		if ( $matches ) {
			# Extract the new message key
			$newkey = trim( $matches[2] ) ? trim( $matches[2] ) : $matches[1];
			
			# Extract category members
			$cat = Category::newFromName( $matches[1] );
			if ( !$cat ) {
				# Invalid title
				continue;
			}
			$members = $cat->getMembers();
			
			if ( $members->count() ) {
				# Create the subbar
				$subbar = array();
				foreach ( $members as $title ) {
					$subbar[] = array(
						 'text' => $title->getText(),
						 'href' => $title->getLocalURL(), 
						 'id' => 'catsb-' . Sanitizer::escapeId( $title ->getText() ),
						 'active' => false,
					);
				}
				$bar[$key] = $subbar;
				
				# Store the index of this top-level entry, because we need to 
				# replace the key later with our new key
				$newbar[$i] = $newkey;
			}
		}
		
		$i++;
	}
	
	if ( $newbar ) {
		# Replace the keys without changing the order
		$keys = array_keys( $bar );
		foreach ( $newbar as $i => $newkey ) {
			array_splice( $keys, $i, 1, $newkey );
		}
		$bar = array_combine( $keys, array_values( $bar ) );
	}
	
	return true;
}
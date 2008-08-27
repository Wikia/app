<?php
/* Allow for articles to include:
 * __WIKIA_BANNER__
 * or 
 * __WIKIA_BOXAD__
 *
 * Which will put the above into html comments into the html.
 * This will then be checked for by the AdCollisionLogic class
 * to see if that page should be told to output a banner or 
 * a box ad.
 *
 * See http://www.mediawiki.org/wiki/Extending_wiki_markup
 * 
 * TODO: Reporting on this so that we know which wikis are using it 
 */

$wgExtensionCredits['parserhook'][] = array(
        'name' => 'AdEngineMagicWord',
        'author' => 'Nick Sullivan',
        'description' => 'Allow editors to include __WIKIA_BANNER__ and __WIKIA_BOXAD__ to encourage the collision detection logic to choose that type of ad'
);


$wgHooks['OutputPageBeforeHTML'][] = 'adEngineMagicWordRender';

function adEngineMagicWordRender($parserOutput, $text) {
   	$text = str_replace(
         	array('__WIKIA_BANNER__','__WIKIA_BOXAD__'),
         	array('<!--__WIKIA_BANNER__-->','<!--__WIKIA_BOXAD__-->'),
		$text);
	return true;
}

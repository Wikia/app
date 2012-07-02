<?php
/**
 * Link Attributes - easy modification of rel/rev/class on <a> elements.
 *
 * @author Toby Inkster <http://tobyinkster.co.uk/>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name'         => 'Link Attributes',
	'version'      => '1.0',
	'author'       => 'Toby Inkster',
	'url'          => 'http://www.mediawiki.org/wiki/Extension:Link_Attributes',
	'description'  => 'easy modification of rel/rev/class on <a> elements'
);

$wgHooks['LinkEnd'][] = 'linkattr_InternalLink';
$wgHooks['LinkerMakeExternalLink'][] = 'linkattr_ExternalLink';

function linkattr_ModifyLink (&$text, &$attribs, $isExternal = 0)
{
	if ( preg_match('/^(.+)\(\((.*)\)\)$/', $text, $matches) )
	{
		$text = trim($matches[1]);
		$rels = preg_split('/\s+/', $matches[2]);

		foreach ($rels as $r)
		{
			if ($isExternal && (strtolower($r)=='-nofollow'))
				continue; # Not allowed!!

			if ((substr($r, 0, 2) == '-~' || substr($r, 0, 2) == '~-') && isset($attribs['rev']))
				$attribs['rev'] = str_ireplace(substr($r, 2), '', $attribs['rev']);
			elseif ((substr($r, 0, 2) == '-.' || substr($r, 0, 2) == '.-') && isset($attribs['class']))
				$attribs['class'] = str_ireplace(substr($r, 2), '', $attribs['class']);
			elseif ((substr($r, 0, 1) == '-') && isset($attribs['rel']))
				$attribs['rel'] = str_ireplace(substr($r, 1), '', $attribs['rel']);
			elseif (substr($r, 0, 1) == '~')
				$attribs['rev'] .= ' ' . substr($r, 1);
			elseif (substr($r, 0, 1) == '.')
				$attribs['class'] .= ' ' . substr($r, 1);
			else
				$attribs['rel'] .= ' ' . $r;
		}

		if (isset($attribs['rel']))
			$attribs['rel'] = trim(preg_replace('/\s+/', ' ', $attribs['rel']));
		if (isset($attribs['rev']))
			$attribs['rev'] = trim(preg_replace('/\s+/', ' ', $attribs['rev']));
		if (isset($attribs['class']))
			$attribs['class'] = trim(preg_replace('/\s+/', ' ', $attribs['class']));
	}
}

function linkattr_InternalLink ($skin, $target, $options, &$text, &$attribs, &$ret)
{
	linkattr_ModifyLink($text, $attribs);
	return true;
}

function linkattr_ExternalLink (&$url, &$text, &$link, &$attribs, $linktype)
{
	$attribsText = Linker::getExternalLinkAttributes('external '.$linktype);
	$mergedattribs = array_merge($attribs, Sanitizer::decodeTagAttributes($attribsText));

	linkattr_ModifyLink($text, $mergedattribs, 1);
	if ($mergedattribs)
			$attribsText = Xml::expandAttributes( $mergedattribs );

	$link = sprintf('<a href="%s"%s>%s</a>', $url, $attribsText, $text);

	return false;
}

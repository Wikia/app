<?php
/* The ImageLink extension allows to define a link for an image:
 *
 *<imagelink>mediawiki.png|http://www.mediawiki.org/|MediaWiki</imagelink>
 * Adapted from http://leuksman.com/extensions/ImageLink.phps
 *
 * Further reading:
 * http://meta.wikimedia.org/wiki/Write_your_own_MediaWiki_extension
 */

$wgHooks['ParserFirstCallInit'][] = "wfImageLinkExtension";

/**
 * @param Parser $parser
 * @return bool
 */
function wfImageLinkExtension( $parser ) {
  $parser->setHook( 'imagelink', 'imageLinkHandler' );
  return true;
}

function imageLinkHandler( $data ) {

  $bits = array_map( 'trim', explode( '|', $data ) );
  $nbits = count( $bits );
  if( $nbits < 1 ) return "(invalid image link)";
  else $imageName = $bits[0];

  if( $nbits < 2 ) $linkTarget = 'Image:' . $imageName;
  else $linkTarget = $bits[1];

  if( $nbits < 3 ) $altText = $linkTarget;
  else $altText = $bits[2];

  return formatImageLink( $imageName, $linkTarget, $altText );
}

function formatImageLink( $imageName, $linkTarget, $altText ) {

  if (preg_match('/^(http|ftp)/', $imageName)) {
    $imageUrl = $imageName;
    $sizeAttrs = "";
  } else {
    $imageTitle = Title::makeTitleSafe( NS_IMAGE, $imageName );
    if(is_null($imageTitle)) return "(invalid image name)";

    $image = wfFindFile( $imageTitle );
    if(is_null($image)) return "(invalid image)";

    $imageUrl = $image->getViewURL();
    $sizeAttrs = 'width="' . IntVal($image->getWidth()) . '" height="' . IntVal($image->getHeight()) . '"';
  }

  if (preg_match('/^(http|ftp)/', $linkTarget)) {
    $linkUrl = $linkTarget;
  } else {
    $linkTitle = Title::newFromText( $linkTarget );
    if(is_null($linkTitle)) return "(invalid link target)";
    $linkUrl = $linkTitle->getLocalUrl();
  }

  return '<a href="' .
    htmlspecialchars( $linkUrl ) .
    '"><img src="' .
    htmlspecialchars( $imageUrl ) .
    '" ' .
    $sizeAttrs .
    ' alt="' .
    htmlspecialchars( $altText ) .
    '" title="' .
    htmlspecialchars( $altText ) .
    '" /></a>';
}


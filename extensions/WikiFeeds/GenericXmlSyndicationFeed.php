<?php
/*
  Generic XML Syndication Feed Class
  Gregory Szorc <gregory.szorc@case.edu>

  This library is free software; you can redistribute it and/or
  modify it under the terms of the GNU Lesser General Public
  License as published by the Free Software Foundation; either
  version 2.1 of the License, or (at your option) any later version.

  This library is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  Lesser General Public License for more details.

  You should have received a copy of the GNU Lesser General Public
  License along with this library; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA

  This is a minimal syndicated feed class.

*/

class GenericXmlSyndicationFeed {
  const FORMAT_ATOM10 = "ATOM10";
  const FORMAT_ATOM = "ATOM";
  const FORMAT_RSS20 = "RSS20";
  const FORMAT_RSS = "RSS";

  protected $_vars = array();
  protected $allowedVars = array(
    'encoding','format','contentType','items','guid','title','description',
    'lastUpdated','authors','linkSelf','linkAlternate','categories','contributors',
    'generator'
  );

  protected $allowedArrays = array(
    'items','authors','categories','contributors'
  );

  public function __get($k) {
    return array_key_exists($k, $this->_vars) ? $this->_vars[$k] : null;
  }

  public function __set($k, $v) {
    if (in_array($k, $this->allowedVars)) {
      $this->_vars[$k] = $v;
    }
    else {
      trigger_error("cannot set $k on ".get_class($this));
    }
  }

  public function __construct($format = self::FORMAT_ATOM10, $encoding = 'utf-8') {
    foreach ($this->allowedArrays as $v) {
      $this->$v = array();
    }

    $this->encoding = $encoding;

    //set the feed format
    switch ($format) {
      case self::FORMAT_RSS20:
      case self::FORMAT_RSS:
        $this->format = self::FORMAT_RSS20;
        $this->contentType = 'application/rss+xml';
        break;

      //default to ATOM 1.0 because it rocks
      case self::FORMAT_ATOM10:
      case self::FORMAT_ATOM:
      default:
        $this->format = self::FORMAT_ATOM10;
        $this->contentType = 'application/atom+xml';
        break;
    }
  }

  public function __toString() {
    return $this->getContent();
  }

  protected static function XMLEncode($s) {
    $string = preg_replace( '/[\x00-\x08\x0b\x0c\x0e-\x1f]/', '', $s);
    return htmlspecialchars( $string );
  }


  public function addItem($i) {
    if ($i instanceof GenericXmlSyndicationFeedItem) {
      $this->_vars['items'][] = $i;

      //perhaps we should re-evaluate the lastUpdated field here?
    }
  }

  public function addAuthor($a) {
    if (is_array($a)) {
      $this->_vars['authors'][] = $a;
    }
  }

  public function getContent($returnDOM = false) {
    switch ($this->format) {
      case self::FORMAT_ATOM10:
      case self::FORMAT_ATOM:
        return $this->getAtom10($returnDOM);
        break;

      case self::FORMAT_RSS20:
      case self::FORMAT_RSS:
        return $this->getRSS20($returnDOM);
        break;

      default:
        return '';
    }
  }

  public function sendOutput() {
    $this->sendHeader();
    echo $this;
  }

  public function sendHeader() {
    header("Content-Type: {$this->contentType}");
  }

  protected function getAtom10($returnDOM = false) {
    $doc = new DOMDocument('1.0', $this->encoding);

    $doc->formatOutput = true;

    $feed = $doc->createElementNS('http://www.w3.org/2005/Atom', 'feed');
    $title = $doc->createElement('title', $this->title);
    $feed->appendChild($title);
    $id = $doc->createElement('id', $this->linkSelf);
    $feed->appendChild($id);
    $updated = $doc->createElement('updated', date('c', $this->lastUpdated));
    $feed->appendChild($updated);

    if ($this->linkSelf) {
      $linkSelf = $doc->createElement('link');
      $linkSelf->setAttribute('rel', 'self');
      $linkSelf->setAttribute('href', $this->linkSelf);
      $feed->appendChild($linkSelf);
    }

    if ($this->linkAlternate) {
      $linkAlt = $doc->createElement('link');
      $linkAlt->setAttribute('rel', 'alternate');
      $linkAlt->setAttribute('href', $this->linkAlternate);
      $feed->appendChild($linkAlt);
    }

    /*
    foreach ($this->authors as $a) {
      $eAuthor = $doc->createElement('author');
      $eAuthorName = $doc->createElement('name', $a['name']);

    }
    */

    foreach ($this->items as $i) {
      $entry = $doc->createElement('entry');
      $id = $doc->createElement('id', $i->guid);
      $entry->appendChild($id);
      $eTitle = $doc->createElement('title', $i->title);
      $entry->appendChild($eTitle);
      $eUpdated = $doc->createElement('updated', date('c', $i->publishTime));
      $entry->appendChild($eUpdated);

      if ($i->linkSelf) {
        $eLinkSelf = $doc->createElement('link');
        $eLinkSelf->setAttribute('rel', 'self');
        $eLinkSelf->setAttribute('href', $i->linkSelf);
        $entry->appendChild($eLinkSelf);
      }

      if ($i->linkAlternate) {
        $eLinkAlternate = $doc->createElement('link');
        $eLinkAlternate->setAttribute('rel', 'alternate');
        $eLinkAlternate->setAttribute('href', $i->linkAlternate);
        $entry->appendChild($eLinkAlternate);
      }

      foreach ($i->authors as $author) {
        $eAuthor = $doc->createElement('author');

        if (@$author['name']) {
          $eAuthorName = $doc->createElement('name', $author['name']);
          $eAuthor->appendChild($eAuthorName);
        }

        if (@$author['email']) {
          $eAuthorEmail = $doc->createElement('email', $author['email']);
          $eAuthor->appendChild($eAuthorEmail);
        }

        if (@$author['uri']) {
          $eAuthorURI = $doc->createElement('uri', $author['uri']);
          $eAuthor->appendChild($eAuthorURI);
        }

        $entry->appendChild($eAuthor);
      }

      foreach ($i->categories as $c) {
        $category = $doc->createElement('category');
        $category->setAttribute('term', $c);
        $category->setAttribute('label', $c);
        $entry->appendChild($category);
      }

      $content = $doc->createElement('content', self::XMLEncode($i->content));
      $content->setAttribute('type', 'html');
      $entry->appendChild($content);

      $feed->appendChild($entry);

    }

    $doc->appendChild($feed);

    return $returnDOM ? $doc : $doc->saveXML();

  }

  protected function getRSS20($returnDOM = false) {
    $doc = new DOMDocument('1.0', $this->encoding);
    $doc->formatOutput = true;

    $rss = $doc->createElement('rss');
    $rss->setAttribute('version', '2.0');

    $channel = $doc->createElement('channel');
    $title = $doc->createElement('title', $this->title);
    $channel->appendChild($title);
    $desc = $doc->createElement('description', $this->description);
    $channel->appendChild($desc);
    $link = $doc->CreateElement('link', $this->linkSelf);
    $channel->appendChild($link);
    $lastBuildDate = $doc->createElement('lastBuildDate', date('r', $this->lastUpdated));
    $channel->appendChild($lastBuildDate);

    foreach ($this->items as $i) {
      $item = $doc->createElement('item');

      $iGuid = $doc->createElement('guid', $i->guid);
      $item->appendChild($iGuid);

      $iTitle = $doc->createElement('title', $i->title);
      $item->appendChild($iTitle);

      $iLink = $doc->createElement('link', $i->guid);
      $item->appendChild($iLink);

      $iPubDate = $doc->createElement('pubDate', date('r', $this->lastUpdated));
      $item->appendChild($iPubDate);

      $iDesc = $doc->createElement('description', self::XMLEncode($i->content));
      $item->appendChild($iDesc);

      $channel->appendChild($item);
    }

    $rss->appendChild($channel);
    $doc->appendChild($rss);

    return $returnDOM ? $doc : $doc->saveXML();

  }

}

 /**
  * This is a generic class to define an item in a syndicated feed
  */
class GenericXmlSyndicationFeedItem {
  protected $_vars = array();
  protected $allowedVars = array(
    'guid','title','updated','authors',
    'content','linkSelf','linkAlternate','summary','categories',
    'contributors','publishTime','source'
  );

  protected $allowedArrays = array(
    'authors','categories'
  );

  public function __construct() {
    foreach ($this->allowedArrays as $a) {
      $this->$a = array();
    }
  }

  public function __get($k) {
    return array_key_exists($k, $this->_vars) ? $this->_vars[$k] : null;
  }

  public function __set($k, $v) {
    if (in_array($k, $this->allowedVars)) {
      $this->_vars[$k] = $v;
    }
    else {
      trigger_error("cannot set $k on ".get_class($this));
    }
  }

  /**
   * Appends value to end of an array
   */
  public function appendValue($k, $v) {
    if (in_array($k, $this->allowedVars) && in_array($k, $this->allowedArrays)) {
      $this->_vars[$k][] = $v;
    }
    else {
      trigger_error("cannot append value for $k on ".get_class($this));
    }
  }

}

?>
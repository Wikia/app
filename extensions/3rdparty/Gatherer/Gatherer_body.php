<?php

/**
 * Special page for the Gatherer extension
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

class Gatherer extends SpecialPage {
	public $name, $gatherer;

	var $rejectedNames = array(
		'Plains',
		'Mountain',
		'Swamp',
		'Forest',
		'Island');

	public function __construct() {
		parent::__construct( 'Gatherer', 'upload' );
	}

	public function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut;
		// we need some settings to be true in order for this to work
		if( !ini_get( 'allow_url_fopen' ) ) {
			@ini_set( 'allow_url_fopen', 1 );
			if( !ini_get( 'allow_url_fopen' ) ) {
				$wgOut->addWikiMsg( 'gatherer-phperr' );
				return;
			}
		}

		if( !$wgUser->isAllowed( 'upload' ) ) {
			$wgOut->permissionRequired( 'upload' );
			return;
		}
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		$this->setHeaders();
		$this->name = $wgRequest->getVal( 'wpName' );
		if( $wgRequest->wasPosted() && !empty( $this->name ) ) {
			$this->name = ucfirst( $this->name );

			// check for split/flip card or rejected name
			if( strpos( $this->name, '//' ) !== false || in_array( $this->name, $this->rejectedNames ) ) {
				$wgOut->addWikiMsg( 'gatherer-notsup' );
				return;
			}

			$err = $this->doQuery();
			if( $err ) {
				$wgOut->addWikiMsg( $err );
			} else {
				$wgOut->addWikiMsg( 'gatherer-done', Title::newFromText( $this->name )->getFullURL( array( 'action' => 'purge' ) ) );
			}
		} else {
			$wgOut->addWikiMsg( 'gatherer-bepatient' );
			$wgOut->addHTML( $this->mainForm() );
		}
	}

	protected function mainForm() {
		$html = '<form method="post"><fieldset><legend>' . wfMsgHtml( 'gatherer-create' ) . "</legend>\n";
		$html .= '<label for="wpName">' . wfMsgHtml( 'gatherer-name' ) . '</label> <input name="wpName" id="wpName" type="text" />';
		$html .= "\n<br /><input type=\"submit\" value=\"" . wfMsgHtml( 'gatherer-submit' ) . "\" />\n";
		$html .= '</fieldset></form>';
		return $html;
	}

	protected function doQuery() {
		global $wgOut;
		$g = $this->gatherer = new GathererQuery( $this->name );
		if( !$g->execute() ) {
			return $g->err;
		}
		$g->cleanup();
		$this->uploadPics( $g );
		$this->createCardPage( $g );
		return false; // false means no errors
	}

	private function uploadPics( $gatherer ) {
		// first check for the set symbols
		foreach( $gatherer->sets as $set => $info ) {
			foreach( $info as $rarity => $file ) {
				switch( $rarity ) {
					case 'R':
						$rarity = 'Rare';
						break;
					case 'U':
						$rarity = 'Uncommon';
						break;
					case 'C':
						$rarity = 'Common';
						break;
					case 'S':
						if( $set == 'Time Spiral "Timeshifted"' ) {
							$rarity = 'Timeshifted';
							$set = 'Time Spiral';
						} else {
							$rarity = 'Special';
						}
						break;
					case 'M':
						$rarity = 'Mythic Rare';
						break;
					case 'L':
						$rarity = 'Land';
					default:
						continue;
				}
				$set = wfStripIllegalFilenameChars( str_replace( ':', '', $set ) ); // we want colons to just disappear, escape everything else to -
				$rarityTitle = Title::newFromText( "{$set} {$rarity}.gif", NS_FILE );
				if( !$rarityTitle->exists() ) {
					$this->doUpload( $rarityTitle, $file, wfMsg( 'gatherer-rarity-desc' ), wfMsg( 'gatherer-rarity-com' ) );
				}
			}
		}

		// now the card images
		foreach( $gatherer->images as $set => $pic ) {
			$name = wfStripIllegalFilenameChars( str_replace( ':', '', $this->name ) );
			$cardTitle = Title::newFromText( "{$name} {$gatherer->rels[$set]['abbr']}.jpg", NS_FILE );
			if( !$cardTitle->exists() ) {
				$this->doUpload( $cardTitle, $pic, wfMsg( 'gatherer-card-desc', $this->name, $set ), wfMsg( 'gatherer-card-com' ) );
			}
		}
	}

	private function doUpload( $title, $file, $msg, $comment ) {
		global $wgTmpDirectory;

		/* @var File $fileObj */
		$fileObj = wfLocalFile( $title );
		$dir = sys_get_temp_dir();
		$path = tempnam( $wgTmpDirectory, 'MTG' );
		$f = fopen( $path, 'w' );
		fwrite( $f, $file );
		fclose( $f );
		$props = File::getPropsFromPath( $path );
		$fileObj->upload( $path, $comment, $msg, File::DELETE_SOURCE, $props );
	}

	private function createCardPage( $gatherer ) {
		$title = Title::newFromText( $this->name );
		$info = array();
		$i = 0;
		foreach( $gatherer->sets as $set => $stuff ) {
			$image = wfStripIllegalFilenameChars( str_replace( ':', '', $this->name ) ) . ' ' . $gatherer->rels[$set]['abbr'] . '.jpg';
			if( isset( $gatherer->borders[$set] ) && $gatherer->borders[$set] ) {
				$border = $gatherer->rels[$set]['border'];
				$info['image' . ++$i] = "{{Border|[[Image:{$image}]]|{$border}}}";
			} else {
				$info['image' . ++$i] = "[[Image:{$image}]]";
			}
			foreach( $stuff as $rarity => $meh ) {
				switch( $rarity ) {
					case 'R':
						$rarity = 'Rare';
						break;
					case 'U':
						$rarity = 'Uncommon';
						break;
					case 'C':
						$rarity = 'Common';
						break;
					case 'S':
						if( $set == 'Time Spiral "Timeshifted"' ) {
							$rarity = 'Timeshifted';
							$set = 'Time Spiral';
						} else {
							$rarity = 'Special';
						}
						break;
					case 'M':
						$rarity = 'Mythic Rare';
						break;
					case 'L':
						$rarity = 'Land';
						break;
				}
				$set = wfStripIllegalFilenameChars( str_replace( ':', '', $set ) );
				$info['p/r' . $i] = "{{Rarity|{$set}|{$rarity}}}";
			}
		}
		for( $i = 1; $i <= 15; $i++ ) {
			if( !isset( $info['image' . $i] ) ) {
				$info['image' . $i] = '';
			}
			if( !isset( $info['p/r' . $i] ) ) {
				$info['p/r' . $i] = '';
			}
		}
		$article = new WikiPage( $title );
		$article->doEdit(
			wfMsgForContentNoTrans( 'gatherer-cardpage', array(
				$gatherer->info['name'],
				$gatherer->info['type'],
				$gatherer->info['cost'],
				$gatherer->info['cmc'],
				$gatherer->info['rules'],
				$gatherer->info['flavor'],
				$gatherer->info['p/t'],
				$gatherer->info['planeswalker'],
				$info['image1'],
				$info['p/r1'],
				$info['image2'],
				$info['p/r2'],
				$info['image3'],
				$info['p/r3'],
				$info['image4'],
				$info['p/r4'],
				$info['image5'],
				$info['p/r5'],
				$info['image6'],
				$info['p/r6'],
				$info['image7'],
				$info['p/r7'],
				$info['image8'],
				$info['p/r8'],
				$info['image9'],
				$info['p/r9'],
				$info['image10'],
				$info['p/r10'],
				$info['image11'],
				$info['p/r11'],
				$info['image12'],
				$info['p/r12'],
				$info['image13'],
				$info['p/r13'],
				$info['image14'],
				$info['p/r14'],
				$info['image15'],
				$info['p/r15']
				) ),
			wfMsg( 'gatherer-cardpage-com' )
		);
	}
}

/**
 * class that queries/stores info from Gatherer
 * @TODO: flip/split cards
 */
class GathererQuery {
	public $name, $err, $sets, $info, $images, $rels, $borders;

	public function __construct( $name ) {
		$this->name = $name;
		$this->err = '';
		$this->sets = array();
		$this->info = array();
		$this->images = array();
		$this->borders = array();

		// parse relations
		$rels = explode( "\n", wfMsgForContent( 'gatherer-sets' ) );
		$this->rels = array();
		foreach( $rels as $rel ) {
			$r = explode( '=', $rel );
			if( count( $r ) != 3 ) {
				continue;
			}
			$this->rels[$r[0]] = array( 'abbr' => $r[1], 'border' => $r[2] );
		}
	}

	public function execute() {
		$un = urlencode( $this->name );
		$c1 = $this->fetchCardInfo( 'http://gatherer.wizards.com/Pages/Card/Details.aspx?name=' . $un );
		$c2 = $this->fetchCardInfo( 'http://gatherer.wizards.com/Pages/Card/Printings.aspx?name=' . $un );
		if( empty($c1) || empty($c2)  ) {
			return false;
		} else {
			$this->detailStr( $c1 );
			$this->printStr( $c2 );
			return $this->err === '';
		}
	}

	function fetchCardInfo( $url ) {
			global $wgHTTPTimeout, $wgHTTPProxy, $wgVersion, $wgTitle;

			$c = curl_init( $url );

			curl_setopt( $c, CURLOPT_PROXY, $wgHTTPProxy );
			curl_setopt( $c, CURLOPT_TIMEOUT, $wgHTTPTimeout );
			curl_setopt( $c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt( $c, CURLOPT_HEADER, false );

			# Don't follow -- catches 302 code, see below
			curl_setopt( $c, CURLOPT_FOLLOWLOCATION, false );

			# Let's be nice and introduce ourselves
			curl_setopt( $c, CURLOPT_USERAGENT, "MediaWiki/$wgVersion" );
                        if ( is_object( $wgTitle ) ) {
                                curl_setopt( $c, CURLOPT_REFERER, $wgTitle->getFullURL() );
                        }

			$text = curl_exec( $c );

                        # Don't return the text of error messages, return false on error
			# 302 means card was not found
                        if ( curl_getinfo( $c, CURLINFO_HTTP_CODE ) == 302 ) {
				$this->err = 'gatherer-nocard';
                                $text = false;
                        }

			# If we get anything else besides 200, something went horribly wrong
			if ( curl_getinfo( $c, CURLINFO_HTTP_CODE ) !== 200 ) {
				$this->err = 'gatherer-connerror';
                                $text = false;
			}

			return $text;
	}

	public function cleanup() {
		foreach( $this->images as $s => $p ) {
			if( !$p ) {
				unset( $this->sets[$s] );
				unset( $this->images[$s] );
			}
		}
		foreach( $this->sets as $s => $info ) {
			foreach( $info as $r => $p ) {
				if( !$p ) {
					unset( $this->sets[$s] );
					unset( $this->images[$s] );
					break;
				}
			}
		}
	}

	// Regex-based parsing for data
	private function detailStr( $str ) {
		preg_match( '/<!-- Card Details Table -->(.*?)<!-- End Card Details Table -->/s', $str, $matches );
		$str = str_replace( '</div><div class="cardtextbox">', '<br />', $matches[1] );

		// card name
		preg_match( '/<div .*?_nameRow".*?<div class="value">(.*?)<\/div>/s', $str, $n );
		$info['name'] = trim( $n[1] );

		// mana cost
		if( preg_match( '/<div .*?_manaRow".*?<div class="value">(.*?)<\/div>/s', $str, $m ) ) {
			$m = explode( '/>', $m[1] );
			$info['cost'] = '';
			foreach( $m as $c ) {
				if( preg_match( '/name=(.*?)&amp;/', $c, $c2 ) ) {
					$info['cost'] .= '{{Cost|' . $c2[1] . '}}';
				}
			}
			$info['cost'] = str_replace( '}}{{Cost', '', $info['cost'] );
		} else {
			$info['cost'] = ' ';
		}

		// converted mana cost (unused in Cardpage, but here for future expansion)
		if( preg_match( '/<div .*?_cmcRow".*?<div class="value">(.*?)<\/div>/s', $str, $c ) ) {
			$info['cmc'] = trim( str_replace( '<br />', '', $c[1] ) );
		} else {
			$info['cmc'] = ' ';
		}

		// type
		preg_match( '/<div .*?_typeRow".*?<div class="value">(.*?)<\/div>/s', $str, $t );
		$pw = ( strpos( $t[1], 'Planeswalker' ) !== false );
		if( $pw ) {
			$info['planeswalker'] = 'yes';
		} else {
			$info['planeswalker'] = '';
		}
		$info['type'] = trim( $t[1] );

		// card text
		if( preg_match( '/<div .*?_textRow".*?<div class="value">(.*?)<\/div>/s', $str, $x ) ) {
			$x = trim( str_replace( '<br />', "\n\n", $x[1] ) );
			$x = preg_replace( '/<img .*?name=(.*?)&amp;.*?\/>/', '{{Cost|$1}}', $x );
			$x = str_replace( '}}{{Cost', '', $x );
			if( $pw ) {
				$x = preg_replace( "/(\n\n)?(.)(.):/", "\n\n{{Loyalty|$2|$3}}:", $x );
			}
			$info['rules'] = str_replace( '<div class="cardtextbox">', '', $x );
		} else {
			$info['rules'] = ' ';
		}

		// flavor text
		if( preg_match( '/<div .*?_flavorRow".*?<div class="cardtextbox">(.*?)<\/div>/s', $str, $f ) ) {
			$f = trim( str_replace( '<br />', "\n\n", $f[1] ) );
			$f = str_replace( '<i>', '', $f );
			$f = str_replace( '</i>', '', $f );
			$info['flavor'] = str_replace( '<div class="cardtextbox">', '', $f );
		} else {
			$info['flavor'] = '';
		}

		// power/toughness
		if( preg_match( '/<div .*?_ptRow".*?<div class="value">(.*?)<\/div>/s', $str, $p ) ) {
			$info['p/t'] = trim( str_replace( ' ', '', $p[1] ) );
		} else {
			$info['p/t'] = '';
		}

		$this->info = $info;
	}

	private function printStr( $str ) {
		preg_match( '/<table class="cardList"(.*?)<\/table>/s', $str, $matches );
		$str = $matches[1];

		// get all sets
		$rows = explode( '<tr', $str );
		foreach( $rows as $row ) {
			if( strpos( $row, $this->info['name'] ) === false ) {
				continue;
			}
			$cells = explode( '<td', $row );
			preg_match( '/>(.*)<\/td>/s', $cells[3], $s );
			preg_match( '/rarity=(.*?)"/', $cells[2], $r );
			$sets[trim( $s[1] )] = $r[1];
			preg_match( '/multiverseid=(.*?)"/', $cells[1], $i );
			$ids[trim( $s[1] )] = trim( $i[1] );
		}

		$this->sets = $this->getSets( $sets );
		$this->images = $this->getPics( $ids );
	}

	private function getSets( $sets ) {
		$ret = array();
		foreach( $sets as $s => $r ) {
			if( !array_key_exists( $s, $this->rels ) ) {
				continue;
			}
			$exp = "http://gatherer.wizards.com/Handlers/Image.ashx?type=symbol&set={$this->rels[$s]['abbr']}&size=small&rarity={$r}";
			$ret[$s][$r] = @file_get_contents( $exp );
			if( !$ret[$s][$r] ) {
				unset( $ret[$s] );
			}
			if( $ret == array() ) {
				$this->err = 'gatherer-imgerr';
			}
		}
		return $ret;
	}

	private function getPics( $ids ) {
		$ret = array();
		foreach( $ids as $set => $id ) {
			if( !array_key_exists( $set, $this->rels ) ) {
				continue;
			}
			$pic = "http://gatherer.wizards.com/Handlers/Image.ashx?multiverseid={$id}&type=card";
			$ret[$set] = @file_get_contents( $pic );
			if( !$ret[$set] ) {
				$this->borders[$set] = true;
				$pic = "http://resources.wizards.com/Magic/Cards/{$this->rels[$set]['abbr']}/EN/Card{$id}.jpg";
				$ret[$set] = @file_get_contents( $pic );
				if( !$ret[$set] ) {
					$pic = "http://resources.wizards.com/Magic/Cards/{$this->rels[$set]['abbr']}/en-us/Card{$id}.jpg";
					$ret[$set] = @file_get_contents( $pic );
					if( !$ret[$set] ) {
						unset( $ret[$set] );
					}
				}
			}
		}
		if( $ret == array() ) {
			$this->err = 'gatherer-imgerr';
		}
		return $ret;
	}
}

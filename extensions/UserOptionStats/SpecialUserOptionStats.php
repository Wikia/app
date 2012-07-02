<?php

/**
 * Special page for generating pie charts of user options
 *
 * @file
 * @ingroup SpecialPages
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class SpecialUserOptionStats extends SpecialPage {

	function __construct() {
		parent::__construct( 'UserOptionStats' );
	}

	public $blacklist = array( 'nickname' );

	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgLang, $wgAutoloadClasses;

		$this->setHeaders();
		$this->outputHeader();

		if ( !class_exists( 'PHPlot' ) && !isset($wgAutoloadClasses['PHPlot'] ) ) {
			$wgOut->addWikiMsg( 'uos-warn' );
			return;
		}

		$par = trim(strtolower($par));

		foreach ( $this->blacklist as $b ) {
			if ( $b === $par ) {
				$par = false;
				break;
			}
		}

		if ( !$par ) {
			$opts = array();
			$hiddenoptions = $this->getHiddenOptions();
			$name = SpecialPage::getTitleFor( 'UserOptionStats' )->getPrefixedText();
			foreach ( $this->getOptions() as $k ) {
				if( in_array( $k, $hiddenoptions ) ) {
					continue; # List hidden options separately (see below)
				}
				$opts[] = "[[$name/$k|$k]]";
			}
			$wgOut->addWikiMsg( 'uos-choose', $wgLang->commaList( $opts ) );
			if ( count( $hiddenoptions ) > 0 ) {
				$hiddenopts = array();
				foreach ( $hiddenoptions as $hk ) {
					$hiddenopts[] = "[[$name/$hk|$hk]]";
				}
				$wgOut->addWikiMsg( 'uos-choose-hidden', $wgLang->commaList( $hiddenopts ) );
			}
			return;
		}

		$dbr = wfGetDB( DB_SLAVE );

		$users = $dbr->select( 'user', '*', '', __METHOD__ );
		$data = array();
		$optionName = $par;
		foreach ( $users as $u ) {
			// New from row doesn't load user_properties, hence this is slow!
			$obj = User::newFromRow( $u );
			$opt = $obj->getOption( $optionName, wfMsg( 'uos-unknown' ) );

			if ( !isset($data[$opt]) ) $data[$opt] = 0;
			$data[$opt]++;
		}

		$realdata = array();
		$labels = array();

		// Most popular first, barring other
		arsort( $data );

		// After more than 7 the default colors start to loop :(
		// So use the last free color for "other" which includes the rest
		$max = 7;
		$rest = array_slice( $data, $max );
		$data = array_slice( $data, 0, $max );
		foreach ( $data as $k => $d ) {
			$labels[] = "$k ($d)";
			$realdata[] = array( $k, $d );
		}
		if ( count($rest) ) {
			$other = 0;
			foreach ( $rest as $v ) $other += $v;
			$labels[] = wfMsg( 'uos-other' ) . " ($other)";
			$realdata[] = array( 'other', $other );
		}

		$title = $wgRequest->getText( 'pietitle', wfMsg( 'uos-title', $optionName ) );
		$width = $wgRequest->getInt( 'width', 700 );
		$height = $wgRequest->getInt( 'height', 500 );
		$width = max( 200, min( 1000, $width ) );
		$height = max( 200, min( 1000, $height ) );
		$shading = $wgRequest->getInt( 'shading', 10 );
		$height = max( 0, min( 1000, $height ) );

		// Define the object
		$plot = new PHPlot( $width, $height );
		$plot->SetDataType('text-data-single');
		$plot->setDataValues( $realdata );
		$plot->SetPlotType('pie');
		$plot->SetLegend($labels);
		$plot->SetShading( $shading );
		$plot->SetLabelScalePosition(0.3);
		$plot->SetTitle( $title );

		// Better fonts
		$realFunction = array( 'FCFontFinder', 'find' );
		if ( is_callable( $realFunction ) ) {
			$font = FCFontFinder::find( $wgLang->getCode() );
			if ( $font ) {
				$plot->SetDefaultTTFont( $font );
			}
		}

		global $wgOut;
		$wgOut->disable();
		$plot->DrawGraph();
	}

	public function getOptions() {
		global $wgDefaultUserOptions;

		$opts = array();
		foreach ( $wgDefaultUserOptions as $k => $v ) $opts[$k] = true;

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'user_properties', 'DISTINCT(up_property) as value', '', __METHOD__ );
		foreach ( $res as $r ) $opts[$r->value] = true;

		foreach ( $this->blacklist as $b ) unset( $opts[$b] );

		$opts = array_keys( $opts );
		sort($opts);

		return $opts;
	}

	public function getHiddenOptions() {
		global $wgHiddenPrefs;
		if ( isset( $wgHiddenPrefs ) && is_array( $wgHiddenPrefs ) ) {
			return $wgHiddenPrefs;
		}
		return array();
	}
}

<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

class SpecialTranslationStats extends SpecialPage {

	public function __construct() {
		parent::__construct( 'TranslationStats' );
		$this->includable( true );
	}

	public function execute( $par ) {
		global $wgOut, $wgRequest;

		$opts = new FormOptions();
		$opts->add( 'graphit', false );
		$opts->add( 'preview', false );
		$opts->add( 'language', '' );
		$opts->add( 'count', 'edits' );
		$opts->add( 'scale', 'days' );
		$opts->add( 'days', 30 );
		$opts->add( 'width', 600 );
		$opts->add( 'height', 400 );
		$opts->add( 'group', '' );
		$opts->add( 'uselang', '' );
		$opts->fetchValuesFromRequest( $wgRequest );

		$pars = explode( ';', $par );
		foreach ( $pars as $item ) {
			if ( strpos( $item, '=' ) === false ) continue;
			list( $key, $value ) = array_map( 'trim', explode( '=', $item, 2 ) );
			if ( isset( $opts[$key] ) )
				$opts[$key] = $value;
		}

		$opts->validateIntBounds( 'days', 1, 300 );
		$opts->validateIntBounds( 'width', 200, 1000 );
		$opts->validateIntBounds( 'height', 200, 1000 );

		$validScales = array( 'days', 'hours' );
		if ( !in_array( $opts['scale'], $validScales ) ) $opts['scale'] = 'days';
		if ( $opts['scale'] === 'hours' ) $opts->validateIntBounds( 'days', 1, 4 );

		foreach ( array( 'group', 'language' ) as $t ) {
			$values = array_map( 'trim', explode( ',', strtolower( $opts[$t] ) ) );
			$values = array_splice( $values, 0, 4 );
			$opts[$t] = implode( ',', $values );
		}

		if ( $this->including() ) {
			$wgOut->addHTML( $this->image( $opts ) );
		} elseif ( $opts['graphit'] ) {

			// Cache for two hours
			$lastMod = $wgOut->checkLastModified( wfTimestamp( TS_MW, time() - 2 * 3600 ) );
			if ( $lastMod ) return;

			$wgOut->disable();

			if ( !class_exists( 'PHPlot' ) ) {
				header( "HTTP/1.0 500 Multi fail" );
				echo "PHPlot not found";
			}

			$this->draw( $opts );
		} else {
			$this->form( $opts );
		}
	}

	protected function form( $opts ) {
		global $wgOut, $wgScript;
		wfLoadExtensionMessages( 'Translate' );
		$this->setHeaders();
		$wgOut->addWikiMsg( 'translate-statsf-intro' );

		$wgOut->addHTML(
			Xml::fieldset( wfMsg( 'translate-statsf-options' ) ) .
			Xml::openElement( 'form', array( 'action' => $wgScript ) ) .
			Xml::hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Xml::hidden( 'preview', 1 ) .
			'<table>'
		);

		$submit = Xml::submitButton( wfMsg( 'translate-statsf-submit' ) );

		$wgOut->addHTML(
			$this->eInput( 'width', $opts ) .
			$this->eInput( 'height', $opts ) .
			'<tr><td colspan="2"><hr /></td></tr>' .
			$this->eInput( 'days', $opts ) .
			$this->eRadio( 'scale', $opts, array( 'days', 'hours' ) ) .
			$this->eRadio( 'count', $opts, array( 'edits', 'users' ) ) .
			'<tr><td colspan="2"><hr /></td></tr>' .
			$this->eLanguage( 'language', $opts ) .
			$this->eGroup( 'group', $opts ) .
			'<tr><td colspan="2"><hr /></td></tr>' .
			'<tr><td colspan="2">' . $submit . '</td></tr>'
		);

		$wgOut->addHTML(
			'</table>' .
			'</form>' .
			'</fieldset>'
		);

		if ( !$opts['preview'] ) return;

		$spiParams = '';
		foreach ( $opts->getChangedValues() as $key => $v ) {
			if ( $key === 'preview' ) continue;
			if ( $spiParams !== '' ) $spiParams .= ';';
			$spiParams .= wfEscapeWikiText( "$key=$v" );
		}

		if ( $spiParams !== '' ) $spiParams = '/' . $spiParams;

		$titleText = $this->getTitle()->getPrefixedText();

		$wgOut->addHTML(
			'<hr />' .
			Xml::element( 'pre', null, "{{{$titleText}{$spiParams}}}" )
		);

		$wgOut->addHTML(
			'<hr />' .
			Xml::tags( 'div', array( 'style' => 'margin: 1em auto; text-align: center;' ), $this->image( $opts ) )
		);
	}

	protected function eInput( $name, FormOptions $opts ) {
		$value = $opts[$name];

		return
			'<tr><td>' . $this->eLabel( $name ) . '</td><td>' .
			Xml::input( $name, 4, $value, array( 'id' => $name ) ) .
			'</td></tr>' . "\n";
	}

	protected function eLabel( $name ) {
		$label = 'translate-statsf-' . $name;
		$label = wfMsgExt( $label, array( 'parsemag', 'escapenoentities' ) );
		return Xml::tags( 'label', array( 'for' => $name ), $label );
	}

	protected function eRadio( $name, FormOptions $opts, array $alts ) {
		$value = $opts[$name];

		$s = '<tr><td>' . $this->eLabel( $name ) . '</td><td>';

		$options = array();
		foreach ( $alts as $alt ) {
			$radio = Xml::radio( $name, $alt, $alt === $opts[$name] ) . ' ';
			$label = wfMsgExt( "translate-statsf-$name-$alt", array( 'parsemag', 'escapenoentities' ) );
			$options[] = Xml::tags( 'label', null, "$radio $label" );
		}

		$s .= Xml::tags( 'span', array( 'id' => $name ), implode( ' ', $options ) );

		$s .= '</td></tr>' . "\n";
		return $s;
	}

	protected function eLanguage( $name, FormOptions $opts ) {
		global $wgLang;
		$value = $opts[$name];

		$select = $this->languageSelector();
		$select->setTargetId( 'language' );

		return
			'<tr><td>' . $this->eLabel( $name ) . '</td><td>' .
			Xml::input( $name, 20, $value, array( 'id' => $name ) ) .
			$select->getHtmlAndPrepareJs() .
			'</td></tr>' . "\n";
	}

	protected function languageSelector() {
		global $wgLang;
		if ( is_callable( array( 'LanguageNames', 'getNames' ) ) ) {
			$languages = LanguageNames::getNames( $wgLang->getCode(),
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW_AND_CLDR
			);
		} else {
			$languages = Language::getLanguageNames( false );
		}

		ksort( $languages );

		$selector = new XmlSelect( 'mw-language-selector', 'mw-language-selector'  );
		foreach ( $languages as $code => $name ) {
			$selector->addOption( "$code - $name", $code );
		}

		$jsSelect = new JsSelectToInput( $selector );
		$jsSelect->setSourceId( 'mw-language-selector' );
		return $jsSelect;
	}

	protected function eGroup( $name, FormOptions $opts ) {
		global $wgLang;
		$value = $opts[$name];

		$select = $this->groupSelector();
		$select->setTargetId( 'group' );

		return
			'<tr><td>' . $this->eLabel( $name ) . '</td><td>' .
			Xml::input( $name, 20, $value, array( 'id' => $name ) ) .
			$select->getHtmlAndPrepareJs() .
			'</td></tr>' . "\n";
	}

	protected function groupSelector() {
		$groups = MessageGroups::singleton()->getGroups();
		foreach ( $groups as $key => $group ) {
			if ( !$group->exists() ) {
				unset( $groups[$key] );
				continue;
			}

			if ( $group->isMeta() ) {
				unset( $groups[$key] );
			}
		}

		ksort( $groups );

		$selector = new XmlSelect( 'mw-group-selector', 'mw-group-selector'  );
		foreach ( $groups as $code => $name ) {
			$selector->addOption( $name->getLabel(), $code );
		}

		$jsSelect = new JsSelectToInput( $selector );
		$jsSelect->setSourceId( 'mw-group-selector' );
		return $jsSelect;
	}

	protected function image( $opts ) {
		$title = $this->getTitle();
		$cgiparams = wfArrayToCgi( array( 'graphit' => true ), $opts->getAllValues() );
		$href = $title->getLocalUrl( $cgiparams );
		return Xml::element( 'img',
			array(
				'src' => $href,
				'width' => $opts['width'],
				'height' => $opts['height'],
			)
		);
	}

	protected function getData( FormOptions $opts ) {
		global $wgLang, $wgTranslateMessageNamespaces;
		$dbr = wfGetDB( DB_SLAVE );

		$now = time();
		$cutoff = $now - ( 3600 * 24 * $opts->getValue( 'days' ) - 1 );
		if ( $opts['scale'] === 'days' ) $cutoff -= ( $cutoff % 86400 );
		$cutoffDb = $dbr->timestamp( $cutoff );

		$so = new TranslatePerLanguageStats( $opts );

		$tables = array( 'recentchanges' );
		$fields = array( 'rc_timestamp' );

		$conds = array(
			"rc_timestamp >= '$cutoffDb'",
			'rc_namespace' => $wgTranslateMessageNamespaces,
			'rc_bot' => 0
		);

		$type = __METHOD__;
		$options = array( 'ORDER BY' => 'rc_timestamp' );

		$so->preQuery( $tables, $fields, $conds, $type, $options );
		$res = $dbr->select( $tables, $fields, $conds, $type, $options );


		// Initialisations
		$so->postQuery( $res );

		$dateFormat = 'Y-m-d';
		if ( $opts['scale'] === 'hours' ) $dateFormat .= ';H';

		$increment = 3600 * 24;
		if ( $opts['scale'] === 'hours' ) $increment = 3600;

		$data = array();
		while ( $cutoff < $now ) {
			$date = $wgLang->sprintfDate( $dateFormat, wfTimestamp( TS_MW, $cutoff )  );
			$so->preProcess( $data[$date] );
			$cutoff += $increment;
		}

		// Processing
		foreach ( $res as $row ) {
			$date = $wgLang->sprintfDate( $dateFormat, $row->rc_timestamp );

			$index = $so->indexOf( $row );
			if ( $index < 0 ) continue;

			if ( !isset( $data[$date][$index] ) ) $data[$date][$index] = 0;
			$data[$date][$index]++;
		}

		$labels = null;
		$so->labels( $labels );

		return array( $labels, $data );
	}

	public function draw( FormOptions $opts ) {
		wfLoadExtensionMessages( 'Translate' );
		global $wgTranslatePHPlotFont, $wgLang;

		$width = $opts->getValue( 'width' );
		$height = $opts->getValue( 'height' );
		// Define the object
		$plot = new PHPlot( $width, $height );

		list( $legend, $resData ) = $this->getData( $opts );
		$count = count( $resData );
		$skip = intval( $count / ( $width / 60 ) - 1 );
		$i = $count;
		foreach ( $resData as $date => $edits ) {
			if ( $skip > 0 ) {
				if ( ( $count - $i ) % $skip !== 0 ) $date = '';
			}
			if ( strpos( $date, ';' ) !== false ) {
				list( , $date ) = explode( ';', $date, 2 );
			}
			array_unshift( $edits, $date );
			$data[] = $edits;
			$i--;
		}

		$font = FCFontFinder::find( $wgLang->getCode() );
		if ( $font ) {
			$plot->SetDefaultTTFont( $font );
		} else {
			$plot->SetDefaultTTFont( $wgTranslatePHPlotFont );
		}
		$plot->SetDataValues( $data );

		if ( $legend !== null )
			$plot->SetLegend( $legend );

		$plot->setFont( 'x_label', null, 8 );
		$plot->setFont( 'y_label', null, 8 );

		$yTitle = wfMsg( 'translate-stats-' . $opts['count'] );

		// Turn off X axis ticks and labels because they get in the way:
		$plot->SetYTitle( $yTitle );
		$plot->SetXTickLabelPos( 'none' );
		$plot->SetXTickPos( 'none' );
		$plot->SetXLabelAngle( 45 );

		$max = max( array_map( 'max', $resData ) );
		$yTick = 5;
		while ( $max / $yTick > $height / 20 ) $yTick *= 2;

		$plot->SetYTickIncrement( $yTick );

		$plot->SetTransparentColor( 'white' );
		$plot->SetBackgroundColor( 'white' );
		// $plot->SetFileFormat('gif');

		// Draw it
		$plot->DrawGraph();
	}
}

class TranslatePerLanguageStats {
	protected $opts;
	protected $cache;
	protected $index;
	protected $filters;
	protected $usercache;

	public function __construct( FormOptions $opts ) {
		$this->opts = $opts;
	}

	public function preQuery( &$tables, &$fields, &$conds, &$type, &$options ) {
		$db = wfGetDB( DB_SLAVE );

		$groups = explode( ',', $this->opts['group'] );
		$codes = explode( ',', $this->opts['language'] );

		$filters['language'] = trim( $this->opts['language'] ) !== '';
		$filters['group'] = trim( $this->opts['group'] ) !== '';

		foreach ( $groups as $group ) {
			
			foreach ( $codes as $code ) {
				if ( $code !== '' ) $key = "$group ($code)";
				else $key = $group;
				$this->cache[$key] = count( $this->cache );
			}
		}

		if ( $filters['language'] ) {
			$myconds = array();
			foreach ( $codes as $code ) {
				$myconds[] = 'rc_title like \'%%/' . $db->escapeLike( $code ) . "'";
			}

			$conds[] = $db->makeList( $myconds, LIST_OR );
		}

		if ( max( $filters ) ) $fields[] = 'rc_title';
		if ( $filters['group'] ) $fields[] = 'rc_namespace';
		if ( $this->opts['count'] === 'users' ) $fields[] = 'rc_user_text';

		$type .= '-perlang';

		$this->filters = $filters;
	}

	public function postQuery( $rows ) { }

	public function preProcess( &$initial ) {
		$initial = array_pad( array(), max( 1, count( $this->cache ) ), 0 );
	}

	public function indexOf( $row ) {
		global $wgContLang;

		if ( $this->opts['count'] === 'users' ) {
			$dateFormat = 'Y-m-d';
			if ( $this->opts['scale'] === 'hours' ) $dateFormat .= ';H';
			$date = $wgContLang->sprintfDate( $dateFormat, $row->rc_timestamp );

			if ( isset( $this->usercache[$date][$row->rc_user_text] ) ) {
				return - 1;
			} else {
				$this->usercache[$date][$row->rc_user_text] = 1;
			}
		}

		if ( !max( $this->filters ) ) return 0;
		if ( strpos( $row->rc_title, '/' ) === false ) return - 1;

		list( $key, $code ) = explode( '/', $wgContLang->lcfirst( $row->rc_title ), 2 );
		$indexKey = '';

		if ( $this->filters['group'] ) {
			$group = TranslateUtils::messageKeyToGroup( $row->rc_namespace, $key );
			if ( $group === null ) return - 1;
			$indexKey .= $group;
		}

		if ( $this->filters['language'] ) {
			$indexKey .= " ($code)";
		}

		if ( count( $this->cache ) ) {
			return isset( $this->cache[$indexKey] ) ? $this->cache[$indexKey] : - 1;
		} else {
			return 0;
		}
	}

	public function labels( &$labels ) {
		if ( count( $this->cache ) > 1 ) {
			$labels = array_keys( $this->cache );
		}
	}
}
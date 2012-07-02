<?php

class SpecialApiSandbox extends SpecialPage {

	/**
	 * @var ApiQuery
	 */
	private $apiQuery;
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ApiSandbox', '', true );
	}

	/**
	 * Main execution function
	 * @param $par Parameters passed to the page
	 */
	public function execute( $par ) {
		global $wgEnableAPI;

		$out = $this->getContext()->getOutput();

		if ( !$wgEnableAPI ) {
			$out->showErrorPage( 'error', 'apisb-api-disabled' );
		}
		
		$this->setHeaders();
		$out->addModules( 'ext.apiSandbox' );

		$out->addHTML( '<noscript>' . wfMessage( 'apisb-no-js' )->parse() . '</noscript>
<div id="api-sandbox-content" style="display: none;">' );
		$out->addWikiMsg( 'apisb-intro' );
		$out->addHTML( '<form id="api-sandbox-form">'
			. $this->openFieldset( 'parameters' )
			. $this->getInputs()
			. '</fieldset>'
			. $this->openFieldset( 'result' )
			. '<table class="api-sandbox-result-container"><tbody>
'
			. '<tr><th class="api-sandbox-result-label"><label for="api-sandbox-url">'
			. wfMessage( 'apisb-result-request-url' )->parse() . '</label></th>'
			. '<td><input id="api-sandbox-url" readonly="readonly" /></td></tr>
'
			. '<tr id="api-sandbox-post-row"><th class="api-sandbox-result-label"><label for="api-sandbox-post">'
			. wfMessage( 'apisb-result-request-post' )->parse() . '</label></th>'
			. '<td><input id="api-sandbox-post" readonly="readonly" /></td></tr>
'
			. '<tr><td colspan="2"><div id="api-sandbox-output"></div></td></tr>'
			. "\n</tbody></table>"
			. "\n</fieldset>\n</form>" );
		
		$out->addHTML( "\n</div>" ); # <div id="api-sandbox-content">
	}

	/**
	 * @return string
	 */
	private function getInputs() {
		global $wgEnableWriteAPI;

		$apiMain = new ApiMain( new FauxRequest( array() ), $wgEnableWriteAPI );
		$this->apiQuery = new ApiQuery( $apiMain, 'query' );

		$formats = array_filter( array_keys( $apiMain->getFormats() ), 'SpecialApiSandbox::filterFormats' );
		sort( $formats );
		$formatOptions = array_combine( $formats, $formats );

		$modules = array_keys( $apiMain->getModules() );
		sort( $modules );
		$key = array_search( 'query', $modules );
		if ( $key !== false ) {
			array_splice( $modules, $key, 1 );
			array_unshift( $modules, 'query' );
		}
		$moduleOptions = array_combine( $modules, $modules );

		$queryModules = array_merge(
			$this->getQueryModules( 'list' ),
			$this->getQueryModules( 'prop' ),
			$this->getQueryModules( 'meta' )
		);

		#$s = '<div id="api-sandbox-buttons"></div>';
		#$s .= '<div id="api-sandbox-examples" style="display: none;"></div>';
		$s = '
<table class="api-sandbox-options">
	<tbody>
		<tr>
			<th><label for="api-sandbox-format">Format</label></th>
			<th><label for="api-sandbox-action">Action</label></th>
			<th class="api-sandbox-docs-col">Documentation</th>
		</tr>
		<tr>
			<td>' . self::getSelect( 'format', $formatOptions, 'json' ) . '</td>
			<td>
				' . self::getSelect( 'action', $moduleOptions ) . '
				<div id="api-sandbox-query-row" style="display: none;">
					' . self::getSelect( 'query', $queryModules ) . '
				</div>
			</td>
			<td class="api-sandbox-docs-col">
				<div id="api-sandbox-buttons"></div>
				<span id="api-sandbox-help"></span>
				<div id="api-sandbox-examples" style="display: none;"></div>
			</td>
		</tr>
	</tbody>
</table>
';
		$s .= '<div id="api-sandbox-main-inputs"></div><div id="api-sandbox-query-inputs" style="display: none"></div>'
			. $this->openFieldset( 'generic-parameters' ) 
			. '<div id="api-sandbox-generic-inputs" class="mw-collapsible mw-collapsed"></div></fieldset>'
			. $this->openFieldset( 'generator-parameters', array( 'style' => 'display: none;' ) )
			. '<div id="api-sandbox-generator-inputs"></div></fieldset>
';
		return $s;
	}

	/**
	 * @param $type string
	 * @return array
	 */
	private function getQueryModules( $type ) {
		$options = array();
		$params = $this->apiQuery->getAllowedParams();
		sort( $params[$type][ApiBase::PARAM_TYPE] );
		foreach ( $params[$type][ApiBase::PARAM_TYPE] as $module ) {
			$options["$type=$module"] = "$type=$module";
		}
		
		$optgroup = array();
		$optgroup[wfMessage( "apisb-query-$type" )->parse()] = $options;
		
		return $optgroup;
	}

	/**
	 * @param $name string
	 * @param $items array
	 * @param $default mixed
	 * @return string
	 */
	private static function getSelect( $name, $items, $default = false ) {
		$s = Html::openElement( 'select', array(
			'class' => 'api-sandbox-input',
			'name' => $name,
			'id' => "api-sandbox-$name" )
		);
		if ( $default === false ) {
			$s .= Xml::option( wfMessage( "apisb-select-$name" )->text(), '', true );
		}
		$s .= XmlSelect::formatOptions( $items, $default );
		$s .= Html::closeElement( 'select' );
		return $s;
	}

	/**
	 * @param $name string
	 * @param $attribs Array
	 * @return string
	 */
	private function openFieldset( $name, $attribs = array() ) {
		return "\n" . Html::openElement( 'fieldset', array( 'id' => "api-sandbox-$name" ) + $attribs )
			. "\n\t" . Html::rawElement( 'legend', array(), wfMessage( "apisb-legend-$name" )->parse() )
			. "\n";
	}

	/**
	 * Callback that returns false if its argument (format name) ends with 'fm'
	 *
	 * @param $value string
	 * @return boolean
	 */
	private static function filterFormats( $value ) {
		return !preg_match( '/fm$/', $value );
	}
}
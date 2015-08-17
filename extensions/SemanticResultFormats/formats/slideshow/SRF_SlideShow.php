<?php
/**
 * File holding the SRF_SlideShow class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

/**
 * The SRF_SlideShow class.
 *
 * @ingroup SemanticResultFormats
 */
class SRFSlideShow extends SMWResultPrinter {

	/**
	 * Get a human readable label for this printer.
	 *
	 * @return string
	 */
	public function getName() {
		return wfMessage( 'srf-printername-slideshow' )->text();
	}

	/**
	 * Return serialised results in specified format.
	 * Implemented by subclasses.
	 */
	protected function getResultText( SMWQueryResult $res, $outputmode ) {

		$html = '';
		$id = uniqid();

		// build an array of article IDs contained in the result set
		$objects = array();
		foreach ( $res->getResults() as $key => $object ) {

			$objects[] = array( $object->getTitle()->getArticleId() );

			$html .= $key . ': ' . $object->getSerialization() . "<br>\n";
		}

		// build an array of data about the printrequests
		$printrequests = array();
		foreach ( $res->getPrintRequests() as $key => $printrequest ) {
			$data = $printrequest->getData();
			if ( $data instanceof SMWPropertyValue ) {
				$name = $data->getDataItem()->getKey();
			} else {
				$name = null;
			}
			$printrequests[] = array(
				$printrequest->getMode(),
				$printrequest->getLabel(),
				$name,
				$printrequest->getOutputFormat(),
				$printrequest->getParameters(),
			);

		}

		// write out results and query params into JS arrays
		// Define the srf_filtered_values array
		SMWOutputs::requireScript( 'srf_slideshow', Html::inlineScript(
				'srf_slideshow = {};'
			)
		);

		SMWOutputs::requireScript( 'srf_slideshow' . $id, Html::inlineScript(
				'srf_slideshow["' . $id . '"] = ' . json_encode(
					array(
						$objects,
						$this->params['template'],
						$this->params['delay'] * 1000,
						$this->params['height'],
						$this->params['width'],
						$this->params['nav controls'],
						$this->params['effect'],
						json_encode( $printrequests ) ,
					)
				) . ';'
			)
		);

		SMWOutputs::requireResource( 'ext.srf.slideshow' );

		if ( $this->params['nav controls'] ) {
			SMWOutputs::requireResource( 'jquery.ui.slider' );
		}

		return Html::element(
			'div',
			array(
				'id' => $id,
				'class' => 'srf-slideshow ' . $id . ' ' . $this->params['class']
			)
		);
	}

	/**
	 * Check whether a "further results" link would normally be generated for this
	 * result set with the given parameters.
	 *
	 * @param SMWQueryResult $results
	 *
	 * @return boolean
	 */
	protected function linkFurtherResults( SMWQueryResult $results ) {
		return false;
	}

	/**
	 * @see SMWResultPrinter::getParamDefinitions
	 *
	 * @since 1.8
	 *
	 * @param $definitions array of IParamDefinition
	 *
	 * @return array of IParamDefinition|array
	 */
	public function getParamDefinitions( array $definitions ) {
		$params = parent::getParamDefinitions( $definitions );

		$params['template'] = array(
			'default' => '',
			'message' => 'smw_paramdesc_template',
		);

		// TODO: Implement named args
//		$params['named args'] = new Parameter( 'named args', Parameter::TYPE_BOOLEAN, false );
//		$params['named args']->setMessage( 'smw_paramdesc_named_args' );

		$params['class'] = array(
			'default' => '',
			'message' => 'srf-paramdesc-class',
		);

		$params['height'] = array(
			'default' => '100px',
			'message' => 'srf-paramdesc-height',
		);

		$params['width'] = array(
			'default' => '200px',
			'message' => 'srf-paramdesc-width',
		);

		$params['delay'] = array(
			'type' => 'integer',
			'default' => 5,
			'message' => 'srf-paramdesc-delay',
		);

		$params['nav controls'] = array(
			'type' => 'boolean',
			'default' => false,
			'message' => 'srf-paramdesc-navigation-controls',
		);

		$params['effect'] = array(
			'default' => 'none',
			'message' => 'srf-paramdesc-effect',
			'values' => array(
				'none',
				'slide left',
				'slide right',
				'slide up',
				'slide down',
				'fade',
				'hide',
			),
		);

		return $params;
	}

	/**
	 * Handles Ajax call
	 * @param integer $pageId
	 * @param type $template
	 * @param type $printrequests
	 * @return type
	 */
	static public function handleGetResult( $pageId, $template, $printrequests ) {

		$title = Title::newFromID( $pageId )->getPrefixedText();

		$rp = new SMWListResultPrinter( 'template', true );

		$paramDefinitions = ParamDefinition::getCleanDefinitions( $rp->getParamDefinitions( array() ) );

		$params = array();

		/**
		 * @param IParamDefinition $def
		 */
		foreach ( $paramDefinitions as $def ) {
			$params[ $def->getName() ] = $def->getDefault();
		}

		$params = array_merge( $params, array(
			'format' => 'template',
			'template' => $template,
			'mainlabel' => '',
			'sort' => '',
			'order' => '',
			'intro' => null,
			'outro' => null,
			'searchlabel' => null,
			'link' => null,
			'default' => null,
			'headers' => null,
			'introtemplate' => '',
			'outrotemplate' => '',
			) );

		$params = SMWQueryProcessor::getProcessedParams($params, array());

		$p = json_decode( $printrequests, true );
		$extraprintouts = array();

		foreach ( $p as $key => $prData ) {

			// if printout mode is PRINT_PROP
			if ( $prData[0] == SMWPrintRequest::PRINT_PROP ) {
				// create property from property key
				$data = SMWPropertyValue::makeUserProperty( $prData[2] );
			} else {
				$data = null;
			}

			// create printrequest from request mode, label, property name, output format, parameters
			$extraprintouts[] = new SMWPrintRequest( $prData[0], $prData[1], $data, $prData[3], $prData[4] );
		}

		return SMWQueryProcessor::getResultFromQueryString( '[[' . $title . ']]', $params, $extraprintouts, SMW_OUTPUT_HTML, SMWQueryProcessor::INLINE_QUERY );

	}

}

<?php
class RDFImport extends SpecialPage {

	protected $m_action;
	protected $m_dataformat;
	protected $m_importdata;
	protected $m_edittoken;
	protected $m_smwbatchwriter;
	protected $m_haswriteaccess;
	protected $m_nsprefix_in_wikititles_properties;
	protected $m_nsprefix_in_wikititles_entities;
	protected $m_show_abbrscreen_properties;
	protected $m_show_abbrscreen_entities;

	function __construct() {
		global $wgUser;

		$userrights = $wgUser->getRights();
		if ( in_array( 'edit', $userrights ) && in_array( 'createpage', $userrights ) ) {
			$this->m_haswriteaccess = true;
		} else {
			$this->m_haswriteaccess = false;
		}
		parent::__construct( 'RDFImport' );
    }

	function execute( $par ) {
		global $wgOut, $wgUser;

		$this->setHeaders();
		$this->handleRequestData();
		$showscreensonly = false;

		if ( $this->m_action == 'Import' ) {
			if ( !$wgUser->matchEditToken( $this->m_edittoken ) ) {
				die( 'Cross-site request forgery detected!' );
			} elseif ( !$this->m_haswriteaccess ) {
				$errortitle = "Permission error";
				$errormessage = "The current user lacks access either to edit or create pages (or both) in this wiki.";
				$wgOut->addHTML( RDFIOUtils::formatErrorHTML( $errortitle, $errormessage ) );
				$this->outputHTMLForm();
			} else {
				$this->initSMWBatchWriter();
				$existunabbrpropertyuris = $this->m_smwbatchwriter->checkForNamespacesWithoutPrefix();
				$abbreviateuriscreen = '';
				$unabbrentityurilist = '';
				if ( $existunabbrpropertyuris && $this->m_show_abbrscreen_properties ) {
					$suggestedbaseuris = $this->m_smwbatchwriter->getNamespacesWithoutPrefix();
					$abbreviateuriscreen = $this->generateURIAbbreviationScreen( $suggestedbaseuris );
					$showscreensonly = true;
				}
				if ( $this->m_show_abbrscreen_entities ) {
					$unabbrentityuris = $this->m_smwbatchwriter->getUnabbrEntityURIs();
					$unabbrentityurilist = $this->generateUnabbrEntityList( $unabbrentityuris );
					$showscreensonly = true;
				}
				if ( $showscreensonly ) {
					$contentbeforehtmlform = $abbreviateuriscreen . "\n" . $unabbrentityurilist;
					$wgOut->addHTML( $this->getHTMLFormContent( $contentbeforehtmlform ) );
				} else {
					$this->executeSMWBatchWriter();
				}
			}
		} elseif ( $this->m_action == 'AddNsPrefixes' ) {
			$this->addNewNsPrefixes();
			$this->executeSMWBatchWriter();
		} else {
			$this->outputHTMLForm();
		}
	}

	/**
	 * Get data from the request object and store it in class variables
	 */
	function handleRequestData() {
		global $wgRequest;
		$this->m_action = $wgRequest->getText( 'action' );
		$this->m_dataformat = $wgRequest->getText( 'dataformat' );
		$this->m_importdata = $wgRequest->getText( 'importdata' );
		$this->m_edittoken = $wgRequest->getText( 'token' );
		$this->m_nsprefix_in_wikititles_properties = $wgRequest->getBool( 'nspintitle_prop', false );
		$this->m_show_abbrscreen_properties = $wgRequest->getBool( 'abbrscr_prop', false );
		$this->m_nsprefix_in_wikititles_entities = $wgRequest->getBool( 'nspintitle_ent', false );
		$this->m_show_abbrscreen_entities = $wgRequest->getBool( 'abbrscr_ent', false );
	}

	/**
	 * Create a new SMWBatchWriter object, store it in a class variable, and
	 * set some options, like which ns prefixes to use.
	 */
	function initSMWBatchWriter() {
		$this->m_smwbatchwriter = new RDFIOSMWBatchWriter( $this->m_importdata, $this->m_dataformat );
		$this->m_smwbatchwriter->setUseNSPInTitlesForProperties(  $this->m_nsprefix_in_wikititles_properties );
		$this->m_smwbatchwriter->setUseNSPInTitlesForEntities( $this->m_nsprefix_in_wikititles_entities );
	}

	/**
	 * Tell the SMWBatchWriter object to execute the import
	 */
	function executeSMWBatchWriter() {
		global $wgOut;
		$this->m_smwbatchwriter->execute();
		$wgOut->addScript( $this->getExampleDataJs() );
		$wgOut->addHTML( $this->getHTMLFormContent() );
	}

	/**
	 * Add more namespace prefixes in the configured namespace mapping
	 */
	function addNewNsPrefixes() {
		$nss = $wgRequest->getArray( 'ns', array() );
		$nsprefixes = $wgRequest->getArray( 'nsprefixes', array() );
		$newnsmappings = array();
		$nsid = 0;
		foreach ( $nss as $ns ) {
			$nsprefix = $nsprefixes[$nsid];
			$newnsmappings[$ns] = $nsprefix;
			$nsid++;
		}
		$this->initSMWBatchWriter();
		$this->m_smwbatchwriter->AddNamespacePrefixes( $newnsmappings );
	}

	/**
	 * Output the HTML for the form, to the user
	 */
	function outputHTMLForm() {
		global $wgOut;
		$wgOut->addScript( $this->getExampleDataJs() );
		$wgOut->addHTML( $this->getHTMLFormContent() );
	}

	/**
	 * For a number of base uri:s, generate the HTML for a screen for
	 * configuring abbreviation for them
	 * @param array $baseuris
	 */
	public function generateURIAbbreviationScreen( $baseuris ) {
	$baseuriscreen = "<fieldset><label><b>Choose Prefix for unabbreviated property namespaces:</b></label>
						<table class=\"wikitable\">";
	$fieldid = 0;
		foreach ( $baseuris as $baseuri ) {
			$baseuriscreen .= "\n<tr><td style=\"color:#777\">$baseuri<input type=\"hidden\" name=\"ns[$fieldid]\" value=\"$baseuri\" /></input></td>
							   <td><input type=\"text\" name=\"nsprefixes[$fieldid]\" size=\"7\" /></td>
							   </tr>\n";
			$fieldid++;
		}
		$baseuriscreen .= "</table>
					   <input type=\"hidden\" name=\"action\" value=\"AddNsPrefixes\">
					   <p><span style=\"font-size: 11px\"><b>Note:</b> These abbreviations will not be used if, for a property, there already exists a wiki article with the same uri set as \"Original URI\".</span></p>
					   </fieldset>
                           ";
		return $baseuriscreen;
	}

	/**
	 * For an array of unabbreviated entities, generate HTML for a
	 * formatted list of these entities' URIs
	 * @param array $unabbrentities
	 * @return array $unabbrentitylist
	 */
	public function generateUnabbrEntityList( $unabbrentities ) {
		$unabbrentitylist = "<fieldset><label><b>Entity (i.e: non-property) URIs lacking namespace prefix</b></label>
						<table class=\"wikitable\">";
		$rowdid = 0;
		foreach ( $unabbrentities as $unabbrentity ) {
			$unabbrentitylist .= "\n<tr><td style=\"color:#777\">$unabbrentity</td></tr>\n";
			$fieldid++;
		}
	$unabbrentitylist .= "</table>
						      <p><span style=\"font-size: 11px\"><b>Hint:</b> Namespace prefix configuration can be added as an attribute in in the RDF tag below according to the following syntax: <code>xmlns:[prefix]=\"[namespace-uri]\"</code></span></p>
						      </fieldset>";
		return $unabbrentitylist;
	}

	/**
	 * Get RDF/XML stub for for the import form, including namespace definitions
	 * @return string
	 */
	public function getExampleRDFXMLData() {
		return '<rdf:RDF\\n\
		        xmlns:rdfs=\\"http://www.w3.org/2000/01/rdf-schema#\\"\\n\
		        xmlns:rdf=\\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\\"\\n\
		        xmlns:n0pred=\\"http://bio2rdf.org/go_resource:\\"\\n\
		        xmlns:ns0pred=\\"http://www.w3.org/2002/07/owl#\\">\\n\
		        \\n\
		        <rdf:Description rdf:about=\\"http://bio2rdf.org/go:0032283\\">\\n\
		            <n0pred:accession>GO:0032283</n0pred:accession>\\n\
		            <rdfs:label>plastid acetate CoA-transferase complex [go:0032283]</rdfs:label>\\n\
		            <n0pred:definition>An acetate CoA-transferase complex located in the stroma of a plastid.</n0pred:definition>\\n\
		            <rdf:type rdf:resource=\\"http://bio2rdf.org/go_resource:term\\"/>\\n\
		            <n0pred:name>plastid acetate CoA-transferase complex</n0pred:name>\\n\
		            <n0pred:is_a rdf:resource=\\"http://bio2rdf.org/go:0009329\\"/>\\n\
		            <rdf:type rdf:resource=\\"http://bio2rdf.org/go_resource:Term\\"/>\\n\
		            <urlImage xmlns=\\"http://bio2rdf.org/bio2rdf_resource:\\">http://bio2rdf.org/image/go:0032283</urlImage>\\n\
		            <xmlUrl xmlns=\\"http://bio2rdf.org/bio2rdf_resource:\\">http://bio2rdf.org/xml/go:0032283</xmlUrl>\\n\
		            <rights xmlns=\\"http://purl.org/dc/terms/\\" rdf:resource=\\"http://www.geneontology.org/GO.cite.shtml\\"/>\\n\
		            <ns0pred:sameAs rdf:resource=\\"http://purl.org/obo/owl/GO#GO_0032283\\"/>\\n\
		            <url xmlns=\\"http://bio2rdf.org/bio2rdf_resource:\\">http://bio2rdf.org/html/go:0032283</url>\\n\
		        </rdf:Description>\\n\
		        \\n\
		        </rdf:RDF>';
	}

	/**
	 * Generate the main HTML form, if the variable $extraFormContent is set, the
	 * content of it will be prepended before the form
	 * @param string $extraFormContent
	 * @return string $htmlFormContent
	 */
	public function getHTMLFormContent( $extraFormContent = '' ) {
		global $wgRequest, $wgUser, $wgArticlePath;

		// Abbreviation (and screen) options for properties
		$checked_nspintitle_properties = $wgRequest->getBool( 'nspintitle_prop', false ) == 1 ? ' checked="true" ' : '';
		$checked_abbrscr_properties = $wgRequest->getBool( 'abbrscr_prop', false ) == 1 ? ' checked="true" ' : '';

		// Abbreviation (and screen) options for entities
		$checked_nspintitle_entities = $wgRequest->getBool( 'nspintitle_ent', false ) == 1 ? ' checked="true" ' : '';
		$checked_abbrscr_entities = $wgRequest->getBool( 'abbrscr_ent', false ) == 1 ? ' checked="true" ' : '';

		$this->m_importdata = $wgRequest->getText( 'importdata', '' );

		// Create the HTML form for RDF/XML Import
		$htmlFormContent = '<form method="post" action="' . str_replace( '/$1', '', $wgArticlePath ) . '/Special:RDFImport"
			name="createEditQuery"><input type="hidden" name="action" value="Import">
			' . $extraFormContent . '
			<table border="0"><tbody>
			<tr><td colspan="3">RDF/XML data to import:</td><tr>
			<tr><td colspan="3"><textarea cols="80" rows="9" name="importdata" id="importdata">' . $this->m_importdata . '</textarea>
			</td></tr>
			<tr><td width="100">Data format:</td>
			<td>
			<select id="dataformat" name="dataformat">
			  <option value="rdfxml" selected="selected">RDF/XML</option>
			  <option value="turtle" >Turtle</option>
			</select>
			</td>
			<td style="text-align: right; font-size: 10px;">
			[<a href="#" onClick="pasteExampleRDFXMLData(\'importdata\');">Paste example data</a>]
			[<a href="#" onClick="document.getElementById(\'importdata\').value = \'\';">Clear</a>]
			</td>
			</tr>
			<tr>
			<td colspan="3">
			<table width="100%" class="wikitable">
			<tr>
			<th style="text-size: 11px">
			Options for properties
			</th>
			<th style="text-size: 11px">
			Options for non-properties
			</th>
			</tr>
			<tr>
			<td style="font-size: 11px">
			<input type="checkbox" name="nspintitle_prop" id="abbrprop" value="1" ' . $checked_nspintitle_properties . ' /> Use namespace prefixes in wiki titles
			</td>
			<td style="font-size: 11px">
			<input type="checkbox" name="nspintitle_ent" id="abbrent" value="1" ' . $checked_nspintitle_entities . ' /> Use namespace prefixes in wiki titles
			</td>
			</tr>
			<tr>
			<td style="font-size: 11px">
			<input type="checkbox" name="abbrscr_prop" id="abbrscrprop" value="1" ' . $checked_abbrscr_properties . ' /> Show abbreviation screen
			</td>
			<td style="font-size: 11px">
			<input type="checkbox" name="abbrscr_ent" id="abbrscrent" value="1" ' . $checked_abbrscr_entities . ' /> Show abbreviation screen
			</td>
			</tr>
			</table>
			</td>
			</tr>
			</tbody></table>
			<input type="submit" value="Submit">' . Html::Hidden( 'token', $wgUser->editToken() ) . '
			</form>';
		return $htmlFormContent;
	}

	/**
	 * Generate the javascriptcode used in the main HTML form for
	 * loading example data into the main textarea
	 * @return string $exampleDataJs
	 */
	public function getExampleDataJs() {
		$exampleDataJs = '
			<script type="text/javascript">
			function pasteExampleRDFXMLData(textFieldId) {
			var textfield = document.getElementById(textFieldId);
			var exampledata = "' . $this->getExampleRDFXMLData() . '";
			textfield.value = exampledata;
			}
			</script>
			';
		return $exampleDataJs;
	}

}

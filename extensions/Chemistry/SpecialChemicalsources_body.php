<?php

if ( ! defined( 'MEDIAWIKI' ) )
	die();

class SpecialChemicalsources extends SpecialPage {
	private $Parameters, $Prefix;

	/**
	 * To write the i18n so that it functions with another listpage:
	 *   1) copy this file to the i18n of your choice
	 *   2) Choose your prefix (the best way, if this i18n file is called YourPrefix, then choose that as your Prefix
	 *   3) Replace all occurences of ChemFunctions with the name of your Prefix.
	 *   4) $wgYourPrefix_Parameters should contain the names of the parameters as they can be given to your specialpage
	 *		In the ListPage you have created, the Magiccodes are then $ParameterName, so if the Parameter is called 'WhAtEvEr',
	 *		then in the ListPage $WhAtEvEr will be replaced with the value of the parameter WhAtEvEr
	 *   5) In the internationalisation messages, you need the following values:
	 *		1) The name of your specialpage
	 *		2) YourPrefix_ListPage -> the name of the page which will hold the links, this page should be in the project namespace
	 *		3) YourPrefix_SearchExplanation -> a text which can appear as help above the input boxes, when no parameter is given to the page
	 *		4) YourPrefix_DataList -> If the ListPage does not exist, this is a html string that is displayed as alternative
	 *		5) For each of the parameters in $wgYourPrefix_Parameters you should have a YourPrefix_ParameterName,
	 *			containing the string as you want it displayed.
	 *			So, if you have a parameter 'WhAtEvEr', you should have a 'YourPrefix_WhAtEvEr' with value 'Whatever'
	 */
	
	/**
	 * This is a list of all the possible parameters supplied to Special:ChemicalSources
	 *  Note: The names must be the same (also same case) as supplied in wgChemFunctions_Messages after the 'chemFunctions_'
	 *
	 * Variables to be handled in parameters:
	 *   CAS = The CAS-number of the chemical
	 *   EINECS = The EINECS number of the chemical
	 *   Name = The name of the chemical (not specific)
	 *   Formula = The formula of the chemical (not by definition specific)
	 *   PubChem = The PubChem number of the chemical
	 *   SMILES = The SMILES notation of the chemical
	 *   InChI = The InChI notation of the chemical
	 *   ATCCode = The ATCCode for the chemical
	 *   KEGG = The KEGG for the chemical
	 *   RTECS = The RTECS code for the chemical
	 *   DrugBank = The DrugBank code for the chemical
	 *   ECNumber = The EC Number for the compound
	 */
	
	protected $wgChemFunctions_Prefix = "chemFunctions";
	protected $wgChemFunctions_Parameters = array (
		'CAS',
		'Formula',
		'Name',
		'EINECS',
		'CHEBI',
		'PubChem',
		'SMILES',
		'InChI',
		'ATCCode',
		'DrugBank',
		'KEGG',
		'ECNumber',
		'RTECS',
	);

	public function __construct() {
		SpecialPage::SpecialPage( 'ChemicalSources' );
	}

	public function execute( $params ) {
		global $wgOut, $wgRequest, $wgChemFunctions_Parameters, $wgChemFunctions_Prefix;

		$this->Parameters = $this->wgChemFunctions_Parameters;
		$this->Prefix = $this->wgChemFunctions_Prefix;

		wfLoadExtensionMessages( 'SpecialChemicalsources' );

		$Params = $wgRequest->getValues();

		$ParamsCheck = "";
		foreach ($this->Parameters as $key) {
			  if ( isset( $Params [$key] ) )
				$ParamsCheck .= $Params [$key];
		}

		if ($ParamsCheck) {
			$transParams = $this->TransposeAndCheckParams($Params);
			$this->OutputListPage($transParams);
		} else {
			$Params = $this->getParams();
		}
	}

	# Check the parameters supplied, make the mixed parameters, and put them into the transpose matrix.

	function TransposeAndCheckParams($Params) {
		if ( isset( $Params['CAS'] ) )
			$Params['CAS'] = preg_replace( '/[^0-9\-]/', "", $Params['CAS'] );
		else $Params['CAS'] = '';
		if ( isset( $Params['EINECS'] ) )
			 $Params['EINECS'] = preg_replace( '/[^0-9\-]/', "", $Params['EINECS'] );
		else $Params['EINECS'] = '';
		if ( isset( $Params['CHEBI'] ) )
			$Params['CHEBI'] = preg_replace( '/[^0-9\-]/', "", $Params['CHEBI'] );
		else $Params['CHEBI'] = '';
		if ( isset( $Params['PubChem'] ) )
			$Params['PubChem'] = preg_replace( '/[^0-9\-]/', "", $Params['PubChem'] );
		else $Params['PubChem'] = '';
		if ( isset( $Params['SMILES'] ) )
			$Params['SMILES'] = preg_replace( '/\ /', "", $Params['SMILES'] );
		else $Params['SMILES'] = '';
		if ( isset( $Params['InChI'] ) )
			$Params['InChI'] = preg_replace( '/\ /', "", $Params['InChI'] );
		else $Params['InChI'] = '';
		if ( isset( $Params['ATCCode'] ) )
			$Params['ATCCode'] = preg_replace( '/[^0-9\-]/', "", $Params['ATCCode'] );
		else $Params['ATCCode'] = '';
		if ( isset( $Params['KEGG'] ) )
			$Params['KEGG'] = preg_replace( '/[^C0-9\-]/', "", $Params['KEGG'] );
		else $Params['KEGG'] = '';
		if ( isset( $Params['RTECS'] ) )
			$Params['RTECS'] = preg_replace( '/\ /', "", $Params['RTECS'] );
		else $Params['RTECS'] = '';
		if ( isset( $Params['ECNumber'] ) )
			$Params['ECNumber'] = preg_replace( '/[^0-9\-]/', "", $Params['ECNumber'] );
		else $Params['ECNumber'] = '';
		if ( isset( $Params['Drugbank'] ) )
			$Params['Drugbank'] = preg_replace( '/[^0-9\-]/', "", $Params['Drugbank'] );
		else $Params['Drugbank'] = '';
		if ( isset( $Params['Formula']  ) )
			$Params['Formula'] = preg_replace( '/\ /', "" , $Params['Formula'] );
		else $Params['Formula'] = '';
		if ( isset( $Params['Name'] ) )
			$Params['Name'] = preg_replace( '/\ /', "%20", $Params['Name'] );
		else $Params['Name'] = '';

		# Create some new from old ones

		$TEMPCASNAMEFORMULA = $Params["CAS"];
		if(empty ($TEMPCASNAMEFORMULA)){
			$TEMPCASNAMEFORMULA = $Params["Formula"];
		}
		if(empty ($TEMPCASNAMEFORMULA)){
			$TEMPCASNAMEFORMULA = $Params["Name"];
		}

		$TEMPNAMEFORMULA = $Params["Name"];
		if(empty ($TEMPNAMEFORMULA)){
			$TEMPNAMEFORMULA = $Params["Formula"];
		}

		$TEMPCASFORMULA = $Params["CAS"];
		if(empty ($TEMPCASFORMULA)){
			$TEMPCASFORMULA = $Params["Formula"];
		}

		$TEMPCASNAME = $Params["CAS"];
		if(empty ($TEMPCASNAME)){
			$TEMPCASNAME = $Params["Name"];
		}

		# Put the parameters into the transpose array:

		$transParams = array("\$MIXCASNameFormula" => $TEMPCASNAMEFORMULA,
							 "\$MIXCASName" => $TEMPCASNAME,
							 "\$MIXCASFormula" => $TEMPCASFORMULA,
							 "\$MIXNameFormula" => $TEMPNAMEFORMULA);
		foreach ($this->Parameters as $key) {
			if ( isset( $Params[$key] ) ) {
				$transParams["\$" . $key] =  $Params[$key] ;
			} else {
				$transParams["\$" . $key] =  "" ;
			}
		}
		return $transParams;
	}

	#Create the actual page
	function OutputListPage($transParams) {
		global $wgOut;

		# check all the parameters before we put them in the page

		foreach ($transParams as $key => $value) {
			 $transParams[$key] = wfUrlEncode( htmlentities( preg_replace( "/\<.*?\>/","", $value) ) );
		}

		# First, see if we have a custom list setup
		$bstitle = Title::makeTitleSafe( NS_PROJECT, wfMsg( $this->Prefix . '_ListPage' ) );
		if( $bstitle ) {
			$revision = Revision::newFromTitle( $bstitle );
			if( $revision ) {
				$bstext = $revision->getText();
				if( $bstext ) {
					$bstext = strtr($bstext, $transParams);
					$wgOut->addWikiText( $bstext );
				}
			} else {
				$bstext = wfMsg( $this->Prefix . '_DataList' );
				$bstext = strtr($bstext, $transParams);
				$wgOut->addHTML( $bstext );
			}
		}
	}

	#If no parameters supplied, get them!
	function getParams() {
		global $wgTitle, $wgOut;
		if( !empty($wgTitle) ) {
			$action = $wgTitle->escapeLocalUrl();
			$go = htmlspecialchars( wfMsg( "go" ) );

			$wgOut->addWikitext ( wfMsg($this->Prefix . '_SearchExplanation'));
			$wgOut->addHTML("<table><tr><td>");
			foreach ($this->Parameters as $key) {
				$this->GetParam_Row($this->Prefix . "_" . $key, $key, $action, $go);
			}
			$wgOut->addHTML("</table>");
		}
	}

	#Creates a table row
	function GetParam_Row($p, $q, $action, $go) {
		global $wgOut;
		$wgOut->addHTML ( wfMsg( $p ) . ": ");
		$wgOut->addHTML("</td><td>
			<form action=\"$action\" method='post'>
				<input name=\"$q\" id=\"$q\" />
				<input type='submit' value=\"$go\" />
			</form>
		</td></tr>");
		$wgOut->addHTML("<tr><td>");
	}
}

<?php
/**
 * Create vCard exports
 * @file
 * @ingroup SemanticResultFormats
 */

/**
 * Printer class for creating vCard exports
 * 
 * @author Markus Krötzsch
 * @author Denny Vrandecic
 * @author Frank Dengler
 * 
 * @ingroup SemanticResultFormats
 * 
 * TODO: fix the insane case
 * TODO: make SRFvCardAddress constructor sane
 */
class SRFvCard extends SMWExportPrinter {
	
	protected $m_title = '';
	protected $m_description = '';

	/**
	 * @see SMWIExportPrinter::getMimeType
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $queryResult
	 *
	 * @return string
	 */
	public function getMimeType( SMWQueryResult $queryResult ) {
		return 'text/x-vcard';
	}

	/**
	 * @see SMWIExportPrinter::getFileName
	 *
	 * @since 1.8
	 *
	 * @param SMWQueryResult $queryResult
	 *
	 * @return string|boolean
	 */
	public function getFileName( SMWQueryResult $queryResult ) {
		if ( $this->getSearchLabel( SMW_OUTPUT_WIKI ) != '' ) {
			return str_replace( ' ', '_', $this->getSearchLabel( SMW_OUTPUT_WIKI ) ) . '.vcf';
		} else {
			return 'vCard.vcf';
		}
	}

	public function getQueryMode( $context ) {
		return ( $context == SMWQueryProcessor::SPECIAL_PAGE ) ? SMWQuery::MODE_INSTANCES : SMWQuery::MODE_NONE;
	}

	public function getName() {
		return wfMessage( 'srf_printername_vcard' )->text();
	}

	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		global $wgSitename;
		$result = '';
		$items = array();
		if ( $outputmode == SMW_OUTPUT_FILE ) { // make vCard file
			if ( $this->m_title == '' ) {
				$this->m_title = $wgSitename;
			}
			$row = $res->getNext();
			while ( $row !== false ) {
				$wikipage = $row[0]->getResultSubject(); // get Subject of the Result
				// name
				$prefix = ''; // something like 'Dr.'
				$firstname = ''; // given name
				$additionalname = ''; // typically the "middle" name (second first name)
				$lastname = ''; // family name
				$suffix = ''; // things like "jun." or "sen."
				$fullname = ''; // the "formatted name", may be independent from first/lastname & co.
				// contacts
				$emails = array();
				$tels = array();
				$addresses = array();
				// organisational details:
				$organization = ''; // any string
				$jobtitle = '';
				$role = '';
				$department = '';
				// other stuff
				$category = '';
				$birthday = ''; // a date
				$url = ''; // homepage, a legal URL
				$note = ''; // any text
				$workaddress = false;
				$homeaddress = false;

				$workpostofficebox = '';
				$workextendedaddress = '';
				$workstreet = '';
				$worklocality = '';
				$workregion = '';
				$workpostalcode = '';
				$workcountry = '';


				$homepostofficebox = '';
				$homeextendedaddress = '';
				$homestreet = '';
				$homelocality = '';
				$homeregion = '';
				$homepostalcode = '';
				$homecountry = '';

				foreach ( $row as $field ) {
					// later we may add more things like a generic
					// mechanism to add non-standard vCard properties as well
					// (could include funny things like geo, description etc.)
					$req = $field->getPrintRequest();
					
					switch( strtolower( $req->getLabel() ) ) {
						case "name":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$fullname = $value->getShortWikiText();
							}
						break;

						case "prefix":
							while( $value = $field->getNextDataValue() ) {
								$prefix .= ( $prefix ? ',':'' ) . $value->getShortWikiText();
							}
						break;

						case "suffix":
							while( $value = $field->getNextDataValue() ) {
								$suffix .= ( $suffix ? ',':'' ) . $value->getShortWikiText();
							}
						break;

						case "firstname":
							$value = $field->getNextDataValue(); // save only the first
							if ( $value !== false ) {
								$firstname = $value->getShortWikiText();
							}
						break;

						case "extraname":
							while( $value = $field->getNextDataValue() ) {
								$additionalname .= ( $additionalname ? ',':'' ) . $value->getShortWikiText();
							}
						break;

						case "lastname":
							$value = $field->getNextDataValue(); // save only the first
							if ( $value !== false ) {
								$lastname = $value->getShortWikiText();
							}
						break;

						case "note":
							while( $value = $field->getNextDataValue() ) {
								$note .= ( $note ? ', ':'' ) . $value->getShortWikiText();
							}
						break;

						case "email":
							while( $value = $field->getNextDataValue() ) {
								$emails[] = new SRFvCardEmail( 'internet', $value->getShortWikiText() );
							}
					 	break;

						case "workphone":
							while( $value = $field->getNextDataValue() ) {
								$tels[] = new SRFvCardTel( 'WORK', $value->getShortWikiText() );
							}
					 	break;

						case "cellphone":
							while( $value = $field->getNextDataValue() ) {
								$tels[] = new SRFvCardTel( 'CELL', $value->getShortWikiText() );
							}
						break;

						case "homephone":
							while( $value = $field->getNextDataValue() ) {
								$tels[] = new SRFvCardTel( 'HOME', $value->getShortWikiText() );
							}
						break;

						case "organization":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$organization = $value->getShortWikiText();
							}
						break;

						case "workpostofficebox":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$workpostofficebox = $value->getShortWikiText();
								$workaddress = true;
							}
						break;

						case "workextendedaddress":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$workextendedaddress = $value->getShortWikiText();
								$workaddress = true;
							}
						break;

						case "workstreet":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$workstreet = $value->getShortWikiText();
								$workaddress = true;
							}
						break;

						case "worklocality":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$worklocality = $value->getShortWikiText();
								$workaddress = true;
							}
						break;

						case "workregion":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$workregion = $value->getShortWikiText();
								$workaddress = true;
							}
						break;

						case "workpostalcode":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$workpostalcode = $value->getShortWikiText();
								$workaddress = true;
							}
						break;

						case "workcountry":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$workcountry = $value->getShortWikiText();
								$workaddress = true;
							}
						break;

						case "homepostofficebox":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$homepostofficebox = $value->getShortWikiText();
								$homeaddress = true;
							}
						break;

						case "homeextendedaddress":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$homeextendedaddress = $value->getShortWikiText();
								$homeaddress = true;
							}
						break;

						case "homestreet":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$homestreet = $value->getShortWikiText();
								$homeaddress = true;
							}
						break;

						case "homelocality":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$homelocality = $value->getShortWikiText();
								$homeaddress = true;
							}
						break;

						case "homeregion":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$homeregion = $value->getShortWikiText();
								$homeaddress = true;
							}
						break;

						case "homepostalcode":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$homepostalcode = $value->getShortWikiText();
								$homeaddress = true;
							}
						break;

						case "homecountry":
							$value = $field->getNextDataValue();
							if ( $value !== false ) {
								$homecountry = $value->getShortWikiText();
								$homeaddress = true;
							}
						break;

						case "birthday":
							if ( $req->getTypeID() == "_dat" )  {
								$value = $field->getNextDataValue();
								if ( $value !== false ) {
									$birthday =  $value->getXMLSchemaDate();
								}
							}
						break;

						case "homepage":
							if ( $req->getTypeID() == "_uri" )  {
								$value = $field->getNextDataValue();
								if ( $value !== false ) {
									$url =  $value->getWikiValue();
								}
							}
						break;
					}
				}
				$pagetitle = $wikipage->getTitle();
				if ( $workaddress ) $addresses[] = new SRFvCardAddress ( 'WORK', $workpostofficebox, $workextendedaddress, $workstreet, $worklocality, $workregion, $workpostalcode, $workcountry );
				if ( $homeaddress ) $addresses[] = new SRFvCardAddress ( 'HOME', $homepostofficebox, $homeextendedaddress, $homestreet, $homelocality, $homeregion, $homepostalcode, $homecountry );
				$items[] = new SRFvCardEntry( $pagetitle, $prefix, $firstname, $lastname, $additionalname, $suffix, $fullname, $tels, $addresses, $emails, $birthday, $jobtitle, $role, $organization, $department, $category, $url, $note );
            	$row = $res->getNext();
			}
            foreach ( $items as $item ) {
				$result .= $item->text();
			}
		} else { // just make link to vcard
			if ( $this->getSearchLabel( $outputmode ) ) {
				$label = $this->getSearchLabel( $outputmode );
			} else {
				$label = wfMessage( 'srf_vcard_link' )->inContentLanguage()->text();
			}
			$link = $res->getQueryLink( $label );
			$link->setParameter( 'vcard', 'format' );
			if ( $this->getSearchLabel( SMW_OUTPUT_WIKI ) != '' ) {
				$link->setParameter( $this->getSearchLabel( SMW_OUTPUT_WIKI ), 'searchlabel' );
			}
			if ( array_key_exists( 'limit', $this->m_params ) ) {
				$link->setParameter( $this->m_params['limit'], 'limit' );
			} else { // use a reasonable default limit
				$link->setParameter( 20, 'limit' );
			}
			$result .= $link->getText( $outputmode, $this->mLinker );
			$this->isHTML = ( $outputmode == SMW_OUTPUT_HTML ); // yes, our code can be viewed as HTML if requested, no more parsing needed
		}
		return $result;
	}
}

/**
 * Represents a single entry in an vCard
 * @ingroup SemanticResultFormats
 */
class SRFvCardEntry {
	private $uri;
	private $label;
	private $fullname;
	private $firstname;
	private $lastname;
	private $additionalname;
	private $prefix;
	private $suffix;
	private $tels = array();
	private $addresses = array();
	private $emails = array();
	private $birthday;
	private $dtstamp;
	private $title;
	private $role;
	private $organization;
	private $department;
	private $category;
	private $note;

	/**
	 * Constructor for a single item in the vcard. Requires the URI of the item.
	 */
	public function __construct( Title $t, $prefix, $firstname, $lastname, $additionalname, $suffix, $fullname, $tels, $addresses, $emails, $birthday, $jobtitle, $role, $organization, $department, $category, $url, $note ) {
		$this->uri = $t->getFullURL();
		$this->url = $url;
		// read fullname or guess it in a simple way from other names that are given
		if ( $fullname != '' ) {
			$this->label = $fullname;
		} elseif ( $firstname . $lastname != '' ) {
			$this->label = $firstname . ( ( ( $firstname != '' ) && ( $lastname != '' ) ) ? ' ':'' ) .  $lastname;
		} else {
			$this->label = $t->getText();
		}
		$this->label = SRFVCardEntry::vCardEscape( $this->label );
		// read firstname and lastname, or guess it from other names that are given
		if ( $firstname . $lastname == '' ) { // guessing needed
			$nameparts = explode( ' ', $this->label );
			// Accepted forms for guessing:
			// "Lastname"
			// "Firstname Lastname"
			// "Firstname <Additionalnames> Lastname"
			$this->lastname = SRFvCardEntry::vCardEscape( array_pop( $nameparts ) );
			if ( count( $nameparts ) > 0 ) $this->firstname = SRFvCardEntry::vCardEscape( array_shift( $nameparts ) );
			foreach ( $nameparts as $name ) {
				$this->additionalname .= ( $this->additionalname != '' ? ',':'' ) . SRFvCardEntry::vCardEscape( $name );
			}
		} else {
			$this->firstname = SRFvCardEntry::vCardEscape( $firstname );
			$this->lastname = SRFvCardEntry::vCardEscape( $lastname );
		}
		if ( $additionalname != '' ) $this->additionalname = $additionalname; // no escape, can be a value list
			// ^ overwrite above guessing in that case
		$this->prefix = SRFvCardEntry::vCardEscape( $prefix );
		$this->suffix = SRFvCardEntry::vCardEscape( $suffix );
		$this->tels = $tels;
		$this->addresses = $addresses;
		$this->emails = $emails;
		$this->birthday = $birthday;
		$this->title = SRFvCardEntry::vCardEscape( $jobtitle );
		$this->role = SRFvCardEntry::vCardEscape( $role );
		$this->organization = SRFvCardEntry::vCardEscape( $organization );
		$this->department = SRFvCardEntry::vCardEscape( $department );
		$this->category = $category; // allow non-escaped "," in here for making a list of categories
		$this->note = SRFvCardEntry::vCardEscape( $note );

		$article = new Article( $t );
		$this->dtstamp  = $article->getTimestamp();
	}


	/**
	 * Creates the vCard output for a single item.
	 * 
	 * CAUTION: this might hurt your eyes
	 */
	public function text() {
		$text  = "BEGIN:VCARD\r\n";
		$text .= "VERSION:3.0\r\n";
		// N and FN are required properties in vCard 3.0, we need to write something there
		$text .= "N;CHARSET=UTF-8:$this->lastname;$this->firstname;$this->additionalname;$this->prefix;$this->suffix\r\n";
		$text .= "FN;CHARSET=UTF-8:$this->label\r\n";
		// heuristic for setting confidentiality level of vCard:
		global $wgGroupPermissions;
		if ( ( array_key_exists( '*', $wgGroupPermissions ) ) &&
		     ( array_key_exists( 'read', $wgGroupPermissions['*'] ) ) ) {
			$public = $wgGroupPermissions['*']['read'];
		} else {
			$public = true;
		}
		$text .= ( $public ? 'CLASS:PUBLIC':'CLASS:CONFIDENTIAL' ) . "\r\n";
		if ( $this->birthday !== "" ) $text .= "BDAY:$this->birthday\r\n";
		if ( $this->title !== "" ) $text .= "TITLE;CHARSET=UTF-8:$this->title\r\n";
		if ( $this->role !== "" ) $text .= "ROLE;CHARSET=UTF-8:$this->role\r\n";
		if ( $this->organization !== "" ) $text .= "ORG;CHARSET=UTF-8:$this->organization;$this->department\r\n";
		if ( $this->category !== "" ) $text .= "CATEGORIES;CHARSET=UTF-8:$this->category\r\n";
		foreach ( $this->emails as $entry ) $text .= $entry->createVCardEmailText();
		foreach ( $this->addresses as $entry ) $text .= $entry->createVCardAddressText();
		foreach ( $this->tels as $entry ) $text .= $entry->createVCardTelText();
		if ( $this->note !== "" ) $text .= "NOTE;CHARSET=UTF-8:$this->note\r\n";
		$text .= "SOURCE;CHARSET=UTF-8:$this->uri\r\n";
		$text .= "PRODID:-////Semantic MediaWiki\r\n";
		$text .= "REV:$this->dtstamp\r\n";
		$text .= "URL:" . ( $this->url ? $this->url:$this->uri ) . "\r\n";
		$text .= "UID:$this->uri\r\n";
		$text .= "END:VCARD\r\n";
		return $text;
	}

	public static function vCardEscape( $text ) {
		return str_replace( array( '\\', ',', ':', ';' ), array( '\\\\', '\,', '\:', '\;' ), $text );
	}

}

/**
 * Represents a single address entry in an vCard entry.
 * @ingroup SemanticResultFormats
 */
class SRFvCardAddress {
	private $type;
	private $postofficebox;
	private $extendedaddress;
	private $street;
	private $locality;
	private $region;
	private $postalcode;
	private $country;

	/**
	 * Constructor for a single address item in the vcard item.
	 */
	public function __construct( $type, $postofficebox, $extendedaddress, $street, $locality, $region, $postalcode, $country ) {
		$this->type = $type;
		$this->postofficebox = SRFvCardEntry::vCardEscape( $postofficebox );
		$this->extendedaddress = SRFvCardEntry::vCardEscape( $extendedaddress );
		$this->street = SRFvCardEntry::vCardEscape( $street );
		$this->locality = SRFvCardEntry::vCardEscape( $locality );
		$this->region = SRFvCardEntry::vCardEscape( $region );
		$this->postalcode = SRFvCardEntry::vCardEscape( $postalcode );
		$this->country = SRFvCardEntry::vCardEscape( $country );
	}

	/**
	 * Creates the vCard output for a single address item.
	 */
	public function createVCardAddressText() {
		if ( $this->type == "" ) $this->type = "work";
		$text  =  "ADR;TYPE=$this->type;CHARSET=UTF-8:$this->postofficebox;$this->extendedaddress;$this->street;$this->locality;$this->region;$this->postalcode;$this->country\r\n";
		return $text;
	}
}

/**
 * Represents a single telephone entry in an vCard entry.
 * @ingroup SemanticResultFormats
 */
class SRFvCardTel {
	private $type;
	private $telnumber;

	/**
	 * Constructor for a single telephone item in the vcard item.
	 */
	public function __construct( $type, $telnumber ) {
		$this->type = $type;  // may be a vCard value list using ",", no escaping
		$this->telnumber = SRFvCardEntry::vCardEscape( $telnumber ); // escape to be sure
	}

	/**
	 * Creates the vCard output for a single telephone item.
	 */
	public function createVCardTelText() {
		if ( $this->type == "" ) $this->type = "work";
		$text  =  "TEL;TYPE=$this->type:$this->telnumber\r\n";
		return $text;
	}
}

/**
 * Represents a single email entry in an vCard entry.
 * @ingroup SemanticResultFormats
 */
class SRFvCardEmail {
	private $type;
	private $emailaddress;

	/**
	 * Constructor for a email telephone item in the vcard item.
	 */
	public function __construct( $type, $emailaddress ) {
		$this->type = $type;
		$this->emailaddress = $emailaddress; // no escape, normally not needed anyway
	}

	/**
	 * Creates the vCard output for a single email item.
	 */
	public function createVCardEmailText() {
		if ( $this->type == "" ) $this->type = "internet";
		$text  =  "EMAIL;TYPE=$this->type:$this->emailaddress\r\n";
		return $text;
	}
}

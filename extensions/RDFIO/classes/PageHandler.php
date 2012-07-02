<?php

class RDFIOPageHandler {
    protected $m_wikititle;
    protected $m_wikititlefull;
    protected $m_ns;
    protected $m_properties;
    protected $m_edittoken;
    protected $m_smwwriter;
    protected $m_smwwriter_add;
    protected $m_smwwriter_remove;
    protected $m_errors;
    protected $m_haserrors;

    function __construct( $wikititle, $ns, $properties ) {
        $this->m_wikititle = $wikititle;
        $this->m_ns = $ns;
        if ( $ns == SMW_NS_PROPERTY ) {
            $wikititle = str_replace( 'Property-3A', '', $wikititle );
            $wikititle = str_replace( 'Property:', '', $wikititle );
            $this->m_wikititlefull = 'Property:' . $wikititle;
        } else {
            $this->m_wikititlefull = $wikititle;
        }
        $this->m_properties = $properties;
        $this->m_haserrors = false;
    }

    /**
     * Write (or delte, if $delete is set to true) the data in the object
     * variables, to the wiki page corresponding to this page handler
     * @param boolean $delete
     */
    public function writeOrDeleteDataToWiki( $delete = false ) {
        if ( $delete ) {
            if ( $this->checkWikiPageExists() ) {
                $this->initSMWWriter( $delete = true );
            } else {
                return;
            }
        } else {
            $this->ensureWikiPageExists();
            $this->initSMWWriter();
        }

        $properties = $this->m_properties;
        foreach ( $properties as $cur_prop ) {
            $propertystring = $cur_prop['p'];
            // TODO: Remove old code:
            // $property = SMWPropertyValue::makeUserProperty( $propertystring );
            $property_di = SMWDIProperty::newFromUserLabel($propertystring);
            $valuestring = RDFIOUtils::sanitizeSMWValue( $cur_prop['v'] );
            $value    = SMWDataValueFactory::newPropertyObjectValue( $property_di, $valuestring );

            $propertyErrorText = $property->getErrorText();
            $propertyHasError = ( $propertyErrorText != '' );
            if ( $propertyHasError ) {
                $this->addError( "<p>In RDFIOPageHandler::writeOrDeleteDataToWiki(): " . $property->getErrorText() . "</p>" );
            }

            $valueErrorText = $value->getErrorText();
            $valueHasError = ( $valueErrorText != '' );
            if ( $valueHasError ) {
                $this->addError( "<p>Error creating property value object in RDFIOPageHandler::writeOrDeleteDataToWiki():</p><p>" . $value->getErrorText() . "</p>" );
            }
            if ( $delete ) {
                $this->m_smwwriter_remove->addPropertyObjectValue( $property, $value );
                $editmessage = "Deleting properties. Last property delete: " . $propertystring . " : " . $valuestring;
            } else {
                $this->m_smwwriter_add->addPropertyObjectValue( $property, $value );
                $editmessage = "Importing properties. Last property added: " . $propertystring . " : " . $valuestring;
            }
        }

        $this->m_smwwriter->update( $this->m_smwwriter_remove, $this->m_smwwriter_add, $editmessage );
        $smwWriterError = $this->m_smwwriter->getError();
        $smwWriterHasError = ( $smwWriterError != '' );
        if ( $smwWriterHasError ) {
            $this->addError( "<p>SMWWriter Error: " . $smwWriterError . "</p>" );
        }
    }

    /**
     * Delete the data in the object variables from the wiki page
     * corresponding to this page handler
     */
    public function deleteDataFromWiki() {
        $this->writeOrDeleteDataToWiki( $delete = true );
    }

    /**
     * Wrapper method for wikiPageExistsSaveEditToken()
     * TODO Is this really needed?
     */
    private function checkWikiPageExists() {
        $this->m_wikipageexists = $this->wikiPageExistsSaveEditToken();
        return $this->m_wikipageexists;
    }

    /**
     * For a wiki page title, check if it exists (and at the same time, store an edit token),
     * and if not, create it.
     * @param string $wikititle
     */
    private function ensureWikiPageExists() {
        $this->m_wikipageexists = $this->wikiPageExistsSaveEditToken();
        if ( !$this->m_wikipageexists ) {
            $this->createWikiPage();
        }
    }

    /**
     * For a create the wiki page, without writing any content to it.
     */
    private function createWikiPage() {
        // Prepare a 'fake' request to the MediaWiki API, which we use internally
        // See http://www.mediawiki.org/wiki/API:Calling_internally for more info
        $fauxEditRequest = new FauxRequest( array (
                        'action' => 'edit',
                        'title' => $this->m_wikititlefull, // For the faux request, the namespace must be included in text form
                        'section' => '0',
                        'summary' => 'New Page (by RDFIO)',
                        'text' => '<!-- Empty page -->',
                        'token' => $this->m_edittoken
        ) );
        $editApi = new ApiMain( $fauxEditRequest, $enableWrite = true );
        $editApi->execute();
        $editApiOutput = & $editApi->getResultData(); // TODO: Take care of this
    }

    /**
     * Checks whether a wiki article with the given title exists. It also receives
     * an edit token for this article and stores in a class variable.
     * @return boolean
     */
    private function wikiPageExistsSaveEditToken() {
        $fauxRequest = new FauxRequest( array (
                    'action' => 'query',
                    'prop' => 'info',
                    'intoken' => 'edit',
                    'titles' => $this->m_wikititlefull
        ) );
        // We are using the MediaWiki API internally.
        // See http://www.mediawiki.org/wiki/API:Calling_internally
        // for more info
        $api = new ApiMain( $fauxRequest );
        $api->execute();
        $apioutput = & $api->getResultData(); // TODO: Take care of this
        $apioutputpages = $apioutput['query']['pages'];
        foreach ( $apioutputpages as $page ) {
            $this->m_edittoken = $page['edittoken'];
        }
        // Using intricacies of array structure to determine if page exists
        // TODO: Use more robust method
        $pageismissing = count( $apioutput['query']['pages'][ -1] ) > 0;
        return !$pageismissing;
    }

    /**
     * Initialize SMWWriter for the page corresponding to title
     * in object variable
     * @param boolean $delete
     */
    private function initSMWWriter( $delete = false ) {
        // Create add and remove objects, to use in SMWWriter calls
		
        // TODO: Should rather use (but not possible with current SMWWriter API?):
    	// $page_di = SMWDIWikiPage::newFromTitle( Title::makeTitle($this->m_ns, $this->m_wikititle) );
    	$page = SMWWikiPageValue::makePage( $this->m_wikititle, $this->m_ns );
    	$page_di = $page->getDataItem(); 
    	$page_data = new SMWSemanticData( $page_di ); 
    	
    	$dummypage = SMWWikiPageValue::makePage( false, $this->m_ns );
    	$dummypage_di = $dummypage->getDataItem();
        $dummypag_data = new SMWSemanticData( $dummypage_di ); 
    	
        
        $this->m_smwwriter = new SMWWriter( $page->getTitle() );
        if ( $delete ) {
            $this->m_smwwriter_add    = $page_data;
            $this->m_smwwriter_remove = $dummypag_data;
        } else {
            $this->m_smwwriter_add    = $dummypag_data;
            $this->m_smwwriter_remove = $page_data;
        }
    }

    public function getWikiTitleFull() {
        return $this->m_wikititlefull;
    }

    private function addError( $errormessage ) {
        $this->m_errors[] = $errormessage;
        $this->m_haserrors = true;
    }

    public function hasErrors() {
        return $this->m_haserrors;
    }

    public function getErrors( ) {
        return $this->m_errors;
    }

    public function getErrorText() {
        $errors = $this->m_errors;
        $errortext = '';
        $i = 1;
        foreach ( $errors as $error ) {
            $errortext .= "$error\n";
            $i++;
        }
        return $errortext;
    }
}

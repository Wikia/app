<?php
/**
 * Job that assigns a type to some properties used in the DSMW ontology.
 * 
 * @copyright 2009 INRIA-LORIA-Score Team
 * 
 * @author jean-philippe muller
 */
class DSMWPropertyTypeJob extends Job {

	public function  __construct( $title ) {
        parent::__construct( __CLASS__, $title );
    }

    public function run() {
        wfProfileIn( 'DSMWPropertyTypeJob::run()' );

        $this->addProperty( 'changeSetID', '[[has type::String]]' );
        $this->addProperty( 'hasSemanticQuery', '[[has type::String]]' );
        $this->addProperty( 'patchID', '[[has type::String]]' );
        $this->addProperty( 'siteID', '[[has type::String]]' );
        $this->addProperty( 'pushFeedServer', '[[has type::URL]]' );
        $this->addProperty( 'pushFeedName', '[[has type::String]]' );
        $this->addProperty( 'hasOperation', '[[has type::Record]] [[has fields::String;String;Text;Text]]' );

        wfProfileOut( 'DSMWPropertyTypeJob::run()' );
        
        return true;
    }
    
    /**
     * Adds a property.
     * 
     * @since 1.1
     * 
     * @param string $titleName The name of the property
     * @param string $propertyProperties A string of properties to assign to the propery (such as "has type")
     */
    protected function addProperty( $titleName, $propertyProperties ) {
		$title = Title::newFromText( $titleName, SMW_NS_PROPERTY );
		
        if ( !$title->exists() ) {
	        $article = new Article( $title, 0 );
	        $article->doEdit( $article->getRawText() . $propertyProperties, '' ); // TODO: add summary
        }    	
    }
    
}

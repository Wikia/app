<?php

namespace Wikia\Search\Traits;
use SearchEngine, User;

trait NamespaceConfigurable
{
	/**
	 * Called in WikiaSearchController and Oasis SearchController index action. 
	 * Sets the SearchConfigs namespaces based on MW-core NS request style.
	 * @see    WikiSearchControllerTest::testSetNamespacesFromRequest
	 * @param  Wikia\Search\Config $searchConfig
	 * @param  User $user
	 * @return boolean true
	 */
	protected function setNamespacesFromRequest( $searchConfig, User $user ) {
		$searchEngine = (new SearchEngine);
		$searchableNamespaces = $searchEngine->searchableNamespaces();
		$namespaces = array();
		foreach( $searchableNamespaces as $i => $name ) {
		    if ( $this->getVal( 'ns'.$i, false ) ) {
		        $namespaces[] = $i;
		    }
		}
		if ( empty($namespaces) ) {
		    if ( $user->getOption( 'searchAllNamespaces' ) ) {
			    $namespaces = array_keys($searchableNamespaces);
		    } else {
		    	$profiles = $searchConfig->getSearchProfiles();
		    	// this is mostly needed for unit testing
		    	$defaultProfile = !empty( $this->wg->DefaultSearchProfile ) ? $this->wg->DefaultSearchProfile : 'default';
		    	$namespaces = $profiles[$defaultProfile]['namespaces'];
		    }

		}
		$searchConfig->setNamespaces( $namespaces );

		return true;
	}

}
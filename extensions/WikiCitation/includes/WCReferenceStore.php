<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * Represents a cache of unique WCReference objects.
 */
class WCReferenceStore {

	/**
	 * List of unique references
	 * @var array
	 */
	protected $referenceList = array();

	/**
	 * Array of references keyed to ID.
	 * Each entry in the array is not necessarily unique
	 * @var array [ intR ] => WCReference
	 */
	protected $references = array();

	/**
	 * Hash table for references.
	 * @var array ( stringH => array ( int => intR ) )
	 */
	protected $hashTable = array(); # Hash array for unique citations.

	/**
	 * Constructor.
	 */
#	public function __construct() {
#	}

	/**
	 * Add a reference to the cache, checking for prior duplicates.
	 * @param integer $key = a unique key
	 * @param WCReference $reference
	 * @return integer = number of citations from last use of this reference.
	 */
	public function addUniqueReference( $key, WCReference $reference ) {
		$referenceKey = array( $key );

		$hash = $reference->getHash();
		if ( empty( $hash ) ) {
			# If empty hash, search all prior hashed references.
			foreach( $this->hashTable as &$hashArray ) {
				foreach( $hashArray as &$testKey ) {
					$testReference = $this->references[ $testKey ];
					# If $reference can be considered a short form of prior reference:
					if ( $reference->shortFormMatches( $testReference ) ) {
						$lastKey = end( $testReference ->keys );
						$testReference->keys += $referenceKey;
						# Forget this reference:
						$this->references[ $key ] = $testReference;
						return $key - $lastKey;
					}
					# If prior reference can be considered a short form of $reference:
					elseif ( $testReference->shortFormMatches( $reference ) ) {
						$lastKey = end( $testReference ->keys );
						$reference->keys = $testReference->keys + $referenceKey;
						# Forget the earlier reference.
						unset( $this->referenceList [ $testKey ] );
						$this->referenceList[ $key ] = $reference;
						$this->references[ $testKey ] = $reference;
						$this->references[ $key ] = $reference;
						$testKey = $key;
						return $key - $lastKey;
					}
				}
			}
		}
		# Handle hash table collisions.
		elseif ( isset( $this->hashTable[ $hash ] ) ) {
			# Search collision entries.
			foreach( $this->hashTable[ $hash ] as &$testKey ) {
				$testReference = $this->references[ $testKey ];
				# If $reference can be considered a short form of prior reference:
				if ( $reference->shortFormMatches( $testReference ) ) {
					$lastKey = end( $testReference ->keys );
					$testReference->keys += $referenceKey;
					# Forget this reference:
					$this->references[ $key ] = $testReference;
					return $key - $lastKey;
				}
				# if prior reference can be considered a short form of $reference:
				elseif ( $testReference->shortFormMatches( $reference ) ) {
					$lastKey = end( $testReference ->keys );
					$reference->keys = $testReference->keys + $referenceKey;
					# Forget the earlier reference.
					unset( $this->referenceList [ $testKey ] );
					$this->referenceList[ $key ] = $reference;
					$this->references[ $testKey ] = $reference;
					$this->references[ $key ] = $reference;
					$testKey = $key;
					return $key - $lastKey;
				}
			}
			# If no collision yet, search prior empty hashes.
			foreach( $this->hashTable[ '' ] as $id => &$testKey ) {
				$testReference = $this->references[ $testKey ];
				if ( $testReference->shortFormMatches( $reference ) ) {
					$lastKey = end( $testReference ->keys );
					$reference->keys = $testReference->keys + $referenceKey;
					# Forget the earlier reference.
					unset( $this->referenceList [ $testKey ] );
					$this->referenceList [ $key ] = $reference;
					$this->references[ $testKey ] = $reference;
					$this->references[ $key ] = $reference;
					# Correct hash table
					unset( $this->hashTable[ '' ][ $id ] );
					$this->hashTable[ $hash ][] = $key;
					return $key - $lastKey;
				}
			}
		}
		# If no hash table match:
		$reference->keys = $referenceKey;
		$this->referenceList[ $key ] = $reference;
		$this->references[ $key ] = $reference;
		$this->hashTable[ $hash ][] = $key;
		return 0;
	}

	public function getReference( $key ) {
		return $this->references[ $key ];
	}

	public function getReferences() {
		return $this->referenceList;
	}

}

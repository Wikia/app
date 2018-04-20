<?php
namespace Wikia\Localisation;

/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

/**
 * LCStore implementation which uses the standard DB functions to store data.
 * This will work on any MediaWiki installation.
 */
class LCStoreDB implements \LCStore {

	/** @var string $currentLang */
	private $currentLang;
	/** @var bool $writesDone */
	private $writesDone = false;
	/** @var \DatabaseBase $dbw */
	private $dbw;
	/** @var array $batch */
	private $batch = [];
	/** @var bool $readOnly */
	private $readOnly = false;
	/** @var string $localisationCachePrefix */
	private $localisationCachePrefix;

	public function __construct( string $localisationCachePrefix ) {
		$this->localisationCachePrefix = $localisationCachePrefix;
	}

	private function getDB() : \DatabaseBase {
		if ( $this->writesDone && $this->dbw ) {
			$db = $this->dbw; // see the changes in finishWrite()
		} else {
			global $wgExternalSharedDB;
			$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		}

		return $db;
	}

	public function get( $code, $key ) {
		wfProfileIn( __METHOD__ );

		$db = $this->getDB();

		$value = $db->selectField(
			'l10n_cache',
			'lc_value',
			[ 'lc_prefix' => $this->localisationCachePrefix, 'lc_lang' => $code, 'lc_key' => $key ],
			__METHOD__
		);

		$ret =  ( $value !== false ) ? unserialize( $db->decodeBlob( $value ), [ 'allowed_classes' => false ] ) : null;

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Return the list of all messages that are kept in localisation cache in the database.
	 *
	 * @param string $code
	 * @return string[]
	 */
	public function getAllKeys( $code ) : array {
		wfProfileIn( __METHOD__ );

		return $this->getDB()->selectFieldValues(
			'l10n_cache',
			'lc_key',
			[ 'lc_prefix' => $this->localisationCachePrefix, 'lc_lang' => $code ],
			__METHOD__
		);
	}

	public function startWrite( $code ) {
		if ( $this->readOnly ) {
			return;
		} elseif ( !$code ) {
			throw new \MWException( __METHOD__ . ": Invalid language \"$code\"" );
		}

		global $wgExternalSharedDB;

		$this->dbw = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		$this->readOnly = wfReadOnly();

		$this->currentLang = $code;
		$this->batch = [];
	}

	public function finishWrite() {
		if ( $this->readOnly ) {
			return;
		} elseif ( is_null( $this->currentLang ) ) {
			throw new \MWException( __CLASS__ . ': must call startWrite() before finishWrite()' );
		}

		// Wikia: avoid "Warning: Error while sending QUERY packet"
		$this->dbw->ping();

		$this->dbw->begin( __METHOD__ );
		try {
			$this->dbw->delete(
				'l10n_cache',
				[ 'lc_lang' => $this->currentLang ],
				__METHOD__
			);

			$primaryKey = [ 'lc_prefix', 'lc_lang', 'lc_key' ];
			foreach ( array_chunk( $this->batch, 50 ) as $rows ) {
				$this->dbw->upsert( 'l10n_cache', $rows, [ $primaryKey ], [ 'lc_value = VALUES(lc_value)' ], __METHOD__ );
			}
			$this->writesDone = true;
		} catch ( \DBQueryError $e ) {
			if ( $this->dbw->wasReadOnlyError() ) {
				$this->readOnly = true; // just avoid site down time
			} else {
				throw $e;
			}
		}
		$this->dbw->commit( __METHOD__ );

		$this->currentLang = null;
		$this->batch = [];
	}

	public function set( $key, $value ) {
		if ( $this->readOnly ) {
			return;
		} elseif ( is_null( $this->currentLang ) ) {
			throw new \MWException( __CLASS__ . ': must call startWrite() before set()' );
		}

		$this->batch[] = [
			'lc_prefix' => $this->localisationCachePrefix,
			'lc_lang' => $this->currentLang,
			'lc_key' => $key,
			'lc_value' => $this->dbw->encodeBlob( serialize( $value ) )
		];
	}

}

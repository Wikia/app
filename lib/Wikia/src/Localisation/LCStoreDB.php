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
	/** @var array $batch */
	private $batch = [];
	/** @var string $localisationCachePrefix */
	private $localisationCachePrefix;

	public function __construct( string $localisationCachePrefix ) {
		$this->localisationCachePrefix = $localisationCachePrefix;
	}

	public function get( $code, $key ) {
		global $wgSpecialsDB;

		if ( $this->writesDone ) {
			$db = wfGetDB( DB_MASTER, [], $wgSpecialsDB ); // see the changes in finishWrite()
		} else {
			$db = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
		}

		$value = $db->selectField(
			'l10n_cache',
			'lc_value',
			[ 'lc_prefix' => $this->localisationCachePrefix, 'lc_lang' => $code, 'lc_key' => $key ],
			__METHOD__
		);

		return ( $value !== false ) ? unserialize( $value, [ 'allowed_classes' => false ] ) : null;
	}

	public function startWrite( $code ) {
		$this->currentLang = $code;
		$this->batch = [];
	}

	public function finishWrite() {
		global $wgSpecialsDB;
		$dbw = wfGetDB( DB_MASTER, [], $wgSpecialsDB );

		$dbw->delete(
			'l10n_cache',
			[ 'lc_prefix' => $this->localisationCachePrefix, 'lc_lang' => $this->currentLang ],
			__METHOD__
		);

		foreach ( array_chunk( $this->batch, 500 ) as $rows ) {
			$dbw->insert( 'l10n_cache', $rows, __METHOD__ );
		}

		$this->writesDone = true;

		$this->currentLang = null;
		$this->batch = [];
	}

	public function set( $key, $value ) {
		$this->batch[] = [
			'lc_prefix' => $this->localisationCachePrefix,
			'lc_lang' => $this->currentLang,
			'lc_key' => $key,
			'lc_value' => serialize( $value )
		];
	}

}

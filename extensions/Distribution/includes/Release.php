<?php

/**
 * TODO: doc
 * 
 * @since 0.1
 * 
 * @ingroup Distribution
 * 
 * @author Chad Horohoe
 */
interface Release {
	const SUPPORT_TIL_EOL = 0;
	const UNSUPPORTED = 1;
	const SUPPORTED = 2;
}

/**
 * TODO: doc
 * 
 * @since 0.1
 * 
 * @ingroup Distribution
 * 
 * @author Chad Horohoe
 */
class MediaWikiRelease implements Release {

	private $id, $name, $number, $reldate, $eoldate, $branch, $tag,
		$announcement, $supported = null;

	public static function newFromRow( $row ) {
		$mw = new self();
		foreach( self::getFieldNames() as $f ) {
			$func = 'set' . ucfirst( $f );
			$col = "mwr_$f";
			$v = isset( $row->$col ) ? $row->$col : null;
			$mw->$func( $v );
		}
		return $mw;
	}

	public static function getFieldNames() {
		return array( 'id', 'name', 'number', 'reldate', 'eoldate', 'branch',
			'tag', 'announcement', 'supported' );
	}

	public function getId() { return $this->id; }
	public function getName() { return $this->name; }
	public function getNumber() { return $this->number; }
	public function getReldate() { return $this->reldate; }
	public function getEoldate() { return $this->eoldate; }
	public function getBranch() { return $this->branch; }
	public function getTag() { return $this->tag; }
	public function getAnnouncement() { return $this->announcement; }
	public function getSupported() { return intval( $this->supported ); }
	public function setId( $i ) { $this->id = $i; }
	public function setName( $n ) { $this->name = $n; }
	public function setNumber( $n ) { $this->number = $n; }
	public function setReldate( $d ) { $this->reldate = $d; }
	public function setEoldate( $d ) { $this->eoldate = $d; }
	public function setBranch( $b ) { $this->branch = $b; }
	public function setTag( $t ) { $this->tag = $t; }
	public function setAnnouncement( $a ) { $this->announcement = $a; }
	public function setSupported( $s ) { $this->supported = $s; }

	public function isSupported() {
		switch( $this->supported ) {
			case self::SUPPORT_TIL_EOL:
				return wfTimestampNow() < wfTimestamp( TS_UNIX, $this->eoldate );
				break;
			case self::SUPPORTED:
				return true;
			case self::UNSUPPORTED:
			default:
				return false;
		}
	}

	public function getBranchUrl() {
		global $wgMWRSvnUrl;
		return $wgMWRSvnUrl . 'branches/' . $this->branch . '/phase3/';
	}

	public function getTagUrl() {
		global $wgMWRSvnUrl;
		return $wgMWRSvnUrl . 'tags/' . $this->tag . '/phase3/';
	}

	public function delete() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'mwreleases', array( 'mwr_id' => $this->getId() ), __METHOD__ );
	}
}

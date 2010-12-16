<?php

/**
 * Support for OpenLayers.
 *
 * @author Robert Leverington <robert@rhl.me.uk>
 * @copyright Copyright © 2009 Robert Leverington
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class OpenLayersMessageGroup extends MessageGroupOld {
	protected $label = 'OpenLayers (slippy maps)';
	protected $id    = 'out-openlayers';
	protected $type  = 'openlayers';

	protected $fileDir  = '__BUG__';

	public function getPath() { return $this->fileDir; }
	public function setPath( $value ) { $this->fileDir = $value; }

	protected $codeMap = array(
		'cs' => 'cs-CZ',
		'da' => 'da-DK',
		'pt-br' => 'pt-BR',
		'sv' => 'sv-SE',
		'zh-hans' => 'zh-CN',
		'zh-tw' => 'zh-TW',
	);

	protected $ignored = array(
		'end'
	);

	public function getMessageFile( $code ) {
		if ( isset( $this->codeMap[ $code ] ) ) {
			$code = $this->codeMap[ $code ];
		}
		return "$code.js";
	}

	protected function getFileLocation( $code ) {
		return $this->fileDir . '/' . $this->getMessageFile( $code );
	}

	public function getReader( $code ) {
		return new OpenLayersFormatReader( $this->getFileLocation( $code ) );
	}

	public function getWriter() {
		return new OpenLayersFormatWriter( $this );
	}
}
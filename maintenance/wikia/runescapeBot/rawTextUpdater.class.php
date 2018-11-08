<?php

class RawTextUpdater {

	/**
	 * @param string $rawText
	 * @param GrandExchangeItem $grandExchangeItem
	 * @param $tradeCount
	 * @return string
	 * @throws Exception
	 */
	public function updateModuleText(string $rawText, GrandExchangeItem $grandExchangeItem, $tradeCount ) : string {
		$oldPrice = $this->extractPrice( $rawText );
		$oldDate = $this->extractDate( $rawText );

		$rawText = $this->replacePrice( $grandExchangeItem->getPrice(), $rawText );
		$rawText = $this->replaceDate( $rawText );
		$rawText = $this->replaceLastPrice( $oldPrice, $rawText );
		$rawText = $this->replaceLastDate( $oldDate, $rawText );
		$rawText = $this->replaceVolume( $tradeCount, $rawText );

		return $rawText;
	}

	public function updateDataText(string $rawText, GrandExchangeItem $grandExchangeItem, $tradeCount ) : string {
		if ( empty( $rawText ) ) {
			$rawText = "return {\n}";
		}

		return $this->appendLatestPrice( $rawText, $grandExchangeItem, $tradeCount );
	}

	private function appendLatestPrice( string $rawText, GrandExchangeItem $item, $tradeCount ) {
		if ( $tradeCount === null ) {
			$lineToAppend = sprintf( ",\n    '%s:%s'\n}", $item->getTimeStamp(), $item->getPrice() );
		} else {
			$lineToAppend = sprintf( ",\n    '%s:%s:%s'\n}", $item->getTimeStamp(), $item->getPrice(), $tradeCount );
		}

		return preg_replace( "/\n}/", $lineToAppend, $rawText );
	}

	/**
	 * @param string $rawText
	 * @return string
	 * @throws Exception
	 */
	private function extractPrice(string $rawText ) : string  {
		return $this->extractPattern( '/price\s+= (\d+)/', $rawText );
	}

	/**
	 * @param string $rawText
	 * @return string
	 * @throws Exception
	 */
	private function extractDate(string $rawText ) : string {
		return $this->extractPattern( '/date\s+= \'(.*)\',/', $rawText );
	}

	/**
	 * @param string $pattern
	 * @param string $rawText
	 * @return string
	 * @throws Exception
	 */
	private function extractPattern(string $pattern, string $rawText ) : string {
		$matches = [];
		preg_match( $pattern, $rawText, $matches );
		if ( count( $matches ) !== 2 ) {
			throw new Exception( "Unable to extract value from text" );
		}
		return $matches[1];
	}

	private function replacePrice( string $replacement, string $rawText ) : string {
		return preg_replace( '/price\s+=.*/', "price      = $replacement,", $rawText  );
	}

	private function replaceDate( string $rawText ) : string {
		return preg_replace( '/date\s+=.*/', "date       = '~~~~~',", $rawText  );
	}

	private function replaceLastPrice( string $replacement, string $rawText ) : string {
		return preg_replace( '/last\s+=.*/', "last       = $replacement,", $rawText  );
	}

	private function replaceLastDate( string $replacement, string $rawText ) : string {
		return preg_replace( '/lastDate\s+=.*/', "lastDate   = '$replacement',", $rawText  );
	}

	private function replaceVolume( $replacement, string $rawText ) : string {
		$rawText = $this->stripOldVolumeData( $rawText );

		// Item doesn't have volume (aka tradecount) data. Either it fell out of the top 100 items so we aren't given
		// trade counts for it anymore, or it was never a top 100 traded item to begin with. Either way, just return
		// the rawText here.
		if ( $replacement === null ) {
			return $rawText;
		}

		return $this->appendVolumeDataAfterLastDateLine( $replacement, $rawText );
	}

	private function stripOldVolumeData( $rawText ) {
		return preg_replace( "/\s+volume.*/", "", $rawText );
	}

	private function appendVolumeDataAfterLastDateLine( $replacement, $rawText ) {
		$volumeString = sprintf( "    volume     = %s,\n    volumeDate = '~~~~~',", $replacement );
		return preg_replace( "/(\s+lastDate.*)/", "$1\n" . $volumeString, $rawText );
	}
}

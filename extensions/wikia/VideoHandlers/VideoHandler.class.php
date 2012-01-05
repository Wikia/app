<?php

/*
 * Handler layer between specyfic video handler and the rest of BitmapHandlers
 * Used mainly for identyfication of Video hanlders
 *
 * In future common handler logic will be migrated here
 * If you are using public video handler specyfic function write them down here
 * 
 */

class VideoHandler extends BitmapHandler
{
	function getEmbed(){
		/* override */
		return false;
	}
}

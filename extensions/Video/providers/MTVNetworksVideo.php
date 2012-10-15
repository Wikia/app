<?php

abstract class MTVNetworksVideoProvider extends BaseVideoProvider {
	protected $embedTemplate = '<embed src="http://media.mtvnservices.com/$video_id" width="$width" height="$height" type="application/x-shockwave-flash" allowFullScreen="true" allowScriptAccess="always" base="." flashVars=""></embed>';

	protected function getRatio() {
		return 512 / 288;
	}
}

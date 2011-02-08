<?php

class WikiaResponseHTMLPrinter extends WikiaResponsePrinter {

	public function render( WikiaResponse $response ) {
		$data = $response->getData();
		if( !empty( $data ) ) {
			extract( $data );
		}

		ob_start();
		require $response->getTemplatePath();
		$out = ob_get_clean();

		return $out;
	}
}
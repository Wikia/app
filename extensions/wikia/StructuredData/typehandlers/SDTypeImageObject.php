<?php
/**
 * @author: Jacek Jursza
 */
class SDTypeImageObject extends SDTypeHandlerAnyType {

	public function handleSaveData( array $data ) {

		$data = parent::handleSaveData( $data );

		if ( !empty( $data['schema:url'] ) ) {
			$pattern = '/(File:)(.+)$/';
			if (preg_match($pattern, $data['schema:url'], $matches)) {
				$file = wfFindFile( $matches[2] );
				if ( !$file ) {
					$file = wfFindFile( urldecode($matches[2]) );
				}
			}
		}

		if ( !empty( $file ) && $file instanceof LocalFile ) {

			$contentUrl = $file->getFullUrl();
			$width = $file->getWidth();
			$height = $file->getHeight();
			$thumb = $file->transform( array('width'=> $this->config['ImageObjectThumbnailMaxWidth']), 0 );
			$url = "";
			if ( !empty( $thumb ) && $thumb instanceof MediaTransformOutput ) {
				$url = $thumb->getUrl();
			}

			$data['schema:thumbnailUrl'] = $url;
			$data['schema:contentURL']  =  $contentUrl;
			$data['schema:width']  = $width;
			$data['schema:height'] = $height;
			//var_dump( $data );			die;

		} else {
			$this->addError('schema:url', wfMsg('structureddata-file-page-doesnt-exist'));
		}

		return $data;
	}
}

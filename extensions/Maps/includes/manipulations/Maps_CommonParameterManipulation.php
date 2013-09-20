<?php
/**
 * Class with public static methods to handle shared parameter definitions
 * based on interfaces.
 *
 * @since 2.0
 *
 * @deprecated This needs to be refactored away since ItemParameterManipulation is deprecated
 */
abstract class MapsCommonParameterManipulation extends ItemParameterManipulation {


	/**
	 * This method requires that parameters are positionally correct,
	 * 1. Link (one parameter) or bubble data (two parameters)
	 * 2. Stroke data (three parameters)
	 * 3. Fill data (two parameters)
	 * e.g ...title~text~strokeColor~strokeOpacity~strokeWeight~fillColor~fillOpacity
	 * @static
	 * @param $obj
	 * @param $metadataParams
	 */
	protected function handleCommonParams( array &$params , &$model ) {

		//Handle bubble and link parameters
		if ( $model instanceof iBubbleMapElement && $model instanceof iLinkableMapElement ) {
			//create link data
			$linkOrTitle = array_shift( $params );
			if ( $link = $this->isLinkParameter( $linkOrTitle ) ) {
				$this->setLinkFromParameter( $model , $link );
			} else {
				//create bubble data
				$this->setBubbleDataFromParameter( $model , $params , $linkOrTitle );
			}
		} else if ( $model instanceof iLinkableMapElement ) {
			//only supports links
			$link = array_shift( $params );
			if ( $link = $this->isLinkParameter( $link ) ) {
				$this->setLinkFromParameter( $model , $link );
			}
		} else if ( $model instanceof iBubbleMapElement ) {
			//only supports bubbles
			$title = array_shift( $params );
			$this->setBubbleDataFromParameter( $model , $params , $title );
		}

		//handle stroke parameters
		if ( $model instanceof iStrokableMapElement ) {
			if ( $color = array_shift( $params ) ) {
				$model->setStrokeColor( $color );
			}

			if ( $opacity = array_shift( $params ) ) {
				$model->setStrokeOpacity( $opacity );
			}

			if ( $weight = array_shift( $params ) ) {
				$model->setStrokeWeight( $weight );
			}
		}

		//handle fill parameters
		if ( $model instanceof iFillableMapElement ) {
			if ( $fillColor = array_shift( $params ) ) {
				$model->setFillColor( $fillColor );
			}

			if ( $fillOpacity = array_shift( $params ) ) {
				$model->setFillOpacity( $fillOpacity );
			}
		}

		//handle hover parameter
		if ( $model instanceof iHoverableMapElement ) {
			if ( $visibleOnHover = array_shift( $params ) ) {
				$model->setOnlyVisibleOnHover( filter_var( $visibleOnHover , FILTER_VALIDATE_BOOLEAN ) );
			}
		}
	}

	private function setBubbleDataFromParameter( &$model , &$params , $title ) {
		if ( $title ) {
			$model->setTitle( $title );
		}
		if ( $text = array_shift( $params ) ) {
			$model->setText( $text );
		}
	}

	private function setLinkFromParameter( &$model , $link ) {
		if ( filter_var( $link , FILTER_VALIDATE_URL , FILTER_FLAG_SCHEME_REQUIRED ) ) {
			$model->setLink( $link );
		} else {
			$title = Title::newFromText( $link );
			$model->setLink( $title->getFullURL() );
		}
	}

	/**
	 * Checks if a string is prefixed with link:
	 * @static
	 * @param $link
	 * @return bool|string
	 * @since 2.0
	 */
	private function isLinkParameter( $link ) {
		if ( strpos( $link , 'link:' ) === 0 ) {
			return substr( $link , 5 );
		}

		return false;
	}
}

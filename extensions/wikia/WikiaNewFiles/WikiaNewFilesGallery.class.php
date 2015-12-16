<?php

class WikiaNewFilesGallery extends WikiaPhotoGallery {
	const ANCHOR_LENGTH = 60;

	/**
	 * Generate WikiaPhotoGallery object from the images array
	 *
	 * @param Skin $skin
	 */
	public function __construct( Skin $skin ) {
		$this->parseParams( array(
			"rowdivider" => true,
			"hideoverflow" => true
		) );

		if ( $skin->getSkinName() === 'oasis' ) {
			$this->setWidths( 212 );
		}
	}

	public function addImages( array $images ) {
		foreach ( $images as $s ) {
			$name = $s->img_name;
			$ut = $s->img_user_text;

			$nt = Title::newFromText( $name, NS_FILE );
			$ul = Linker::link(
				Title::makeTitle( NS_USER, $ut ),
				$ut,
				[ 'class' => 'wikia-gallery-item-user' ]
			);
			$timeago = wfTimeFormatAgo( $s->img_timestamp );

			$links = [];
			foreach ( $s->linkingArticles as $row ) {
				$name = Title::makeTitle( $row['ns'], $row['title'] );
				$links[] = Linker::link(
					$name,
					wfShortenText( $name, self::ANCHOR_LENGTH ),
					[ 'class' => 'wikia-gallery-item-posted' ]
				);
			}

			// If there are more than two files, remove the 2nd and link to the image page
			if ( count( $links ) == 2 ) {
				array_splice( $links, 1 );
				$moreFiles = true;
			} else {
				$moreFiles = false;
			}

			$caption = wfMessage( 'wikianewfiles-uploadby' )->rawParams( $ul )->params( $ut )->escaped();
			$caption .= "<br />\n<i>$timeago</i><br />\n";

			if ( count( $links ) ) {
				$caption .= wfMessage( 'wikianewfiles-postedin' )->escaped() . "&nbsp;" . $links[0];
			}

			if ( $moreFiles ) {
				$caption .= ", " . '<a href="' . $nt->getLocalUrl() .
					'#filelinks" class="wikia-gallery-item-more">' .
					wfMessage( 'wikianewfiles-more' )->escaped() . '</a>';
			}

			$this->add( $nt, $caption );
		}
	}
}

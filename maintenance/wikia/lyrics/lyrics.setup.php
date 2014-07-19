<?php
$dir = dirname( __FILE__ );

require_once( $dir . '/../../../extensions/wikia/LyricsApi/LyricsUtils.class.php' );

require_once( $dir . '/../../../lib/vendor/Solarium/Autoloader.php' );
require_once( $dir . '/SolrAdapter.class.php' );
require_once( $dir . '/LyricsScraper.class.php' );

require_once( $dir . '/scrapers/BaseScraper.class.php' );
require_once( $dir . '/scrapers/ArtistScraper.class.php' );
require_once( $dir . '/scrapers/AlbumScraper.class.php' );
require_once( $dir . '/scrapers/SongScraper.class.php' );

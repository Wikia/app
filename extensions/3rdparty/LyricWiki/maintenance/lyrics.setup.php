<?php

require_once( __DIR__ . '/../../../../extensions/wikia/LyricsApi/LyricsUtils.class.php' );

require_once( __DIR__ . '/../../../../lib/vendor/Solarium/Autoloader.php' );
require_once( __DIR__ . '/SolrAdapter.class.php' );
require_once( __DIR__ . '/LyricsScraper.class.php' );

require_once( __DIR__ . '/scrapers/BaseScraper.class.php' );
require_once( __DIR__ . '/scrapers/ArtistScraper.class.php' );
require_once( __DIR__ . '/scrapers/AlbumScraper.class.php' );
require_once( __DIR__ . '/scrapers/SongScraper.class.php' );

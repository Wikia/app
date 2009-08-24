<?php

class SmoothGalleryParser {

	var $set;
	var $argumentArray;
	var $galleriesArray;

	function SmoothGalleryParser( $input, $argv, &$parser, $calledAsSet=false ) {
		$this->set = $calledAsSet;
		$this->parseArguments( $argv );
		$this->parseGalleries( $input, $parser );
	}

	function getArguments() {
		return $this->argumentArray;
	}

	function getGalleries() {
		return $this->galleriesArray;
	}

	function parseArguments( $argv ) {
		//Parse arguments, set defaults, and do sanity checks
		if ( isset( $argv["height"] ) && is_numeric( $argv["height"] ) ) {
			$this->argumentArray["height"] = $argv["height"] . "px";
		} else {
			$this->argumentArray["height"] = "300px";
		}
	
		if ( isset( $argv["width"] ) && is_numeric( $argv["width"] ) ) {
			$this->argumentArray["width"] = $argv["width"] . "px";
		} else {
			$this->argumentArray["width"] = "400px";
		}
	
		if ( isset( $argv["showcarousel"] ) && $argv["showcarousel"] == "false" ) {
			$this->argumentArray["carousel"] = false;
		} else {
			$this->argumentArray["carousel"] = true;
		}
	
		if ( isset( $argv["timed"] ) && $argv["timed"] == "true" ) {
			$this->argumentArray["timed"] = true;
		} else {
			$this->argumentArray["timed"] = false;
		}
	
		if ( isset( $argv["delay"] ) && is_numeric($argv["delay"]) ) {
			$this->argumentArray["delay"] = $argv["delay"];
		} else {
			$this->argumentArray["delay"] = "9000";
		}
	
		if ( isset( $argv["showarrows"] ) && $argv["showarrows"] == "false" ) {
			$this->argumentArray["showarrows"] = false;
		} else {
			$this->argumentArray["showarrows"] = true;
		}
	
		if ( isset( $argv["showinfopane"] ) && $argv["showinfopane"] == "false" ) {
			$this->argumentArray["showinfopane"] = false;
		} else {
			$this->argumentArray["showinfopane"] = true;
		}
	
		if ( isset( $argv["fallback"] ) ) {
			$this->argumentArray["fallback"] = htmlspecialchars( $argv["fallback"] );
		} else {
			$this->argumentArray["fallback"] = "gallery";
		}
	
		if ( isset( $argv["nolink"] ) && $argv["nolink"] == "true" ) {
			$this->argumentArray["nolink"] = true;
		} else {
			$this->argumentArray["nolink"] = false;
		}
	}
	
	function parseGalleries( $input, $parser ) {
		$this->galleriesArray = Array();
	
		if ( $this->set ) {
			//This isn't currently working right, I need to enter
			//a bug report with smooth gallery, so we'll leave
			//the name alone for now.
			#$this->galleriesArray["gallery_set_name"] = "MediaWikiSGallerySet" . mt_rand();
			$this->galleriesArray["gallery_set_name"] = "MediaWikiSGallerySet";
	
			//parse set into separate galleries
			preg_match_all( "/<sgallery([\w]+)?[^>]*>(.*)<\/sgallery>/smU", $input, $galleries, PREG_SET_ORDER );
	
			//iterate through galleries, call renderGallery on each, and
			//collect the fallback output
			$i = 0;
			foreach ( $galleries as $galleryInput ) {
				//TOFIX:
				//This couldn't possibly be right... If these are different
				//galleries in a gallery set, shouldn't they have unique names?
				$name = "MediaWikiSGallery" . $i;
	
				$this->galleriesArray["galleries"][$i] = $this->parseGallery( $galleryInput[2], $parser );
				$this->galleriesArray["galleries"][$i]["gallery_name"] = $name;
	
				$i++;
			}
		} else {
			$name = "MediaWikiSGallery" . mt_rand();
	
			$this->galleriesArray["galleries"][0] = $this->parseGallery( $input, $parser);
			$this->galleriesArray["galleries"][0]["gallery_name"] = $name;
		}
	
		return $this->galleriesArray;
	}
	
	function parseGallery( $input, $parser ) {
		global $wgTitle;
		global $wgSmoothGalleryDelimiter;
		global $wgSmoothGalleryAllowExternal;
	
		$galleryArray = Array();
	
		//We need a parser to pass to the render function, this
		//seems kinda dirty, but it works on MediaWiki 1.6-1.9...
		$local_parser = clone $parser;
		$local_parser_options = new ParserOptions();
		$local_parser->mOptions = $local_parser_options;
		$local_parser->Title( $wgTitle );
		$local_parser->mArgStack = array();
	
		//Expand templates in the input
		$local_parser->replaceVariables( $input );
	
		//The image array is a delimited list of images (strings)
		$line_arr = preg_split( "/$wgSmoothGalleryDelimiter/", $input, -1, PREG_SPLIT_NO_EMPTY );
	
		foreach ( $line_arr as $line ) {
			$img_arr = explode( "|", $line, 2 );
			$img = $img_arr[0];
			if ( count( $img_arr ) > 1 ) {
				$img_desc = $img_arr[1];
			} else {
				$img_desc = '';
			}

			if ( $wgSmoothGalleryAllowExternal &&
			     ( ( strlen( $img ) >= 7 && substr( $img, 0, 7 ) == "http://" ) ||
			       ( strlen( $img ) >= 7 && substr( $img, 0, 8 ) == "https://" ) )
			   ) {
				$imageArray["title"] = null;
				//TODO: internationalize
				$imageArray["heading"] = "External Image";
				$imageArray["description"] = $img_desc;
				$imageArray["full_url"] = $img;
				$imageArray["view_url"] = $img;
				$imageArray["full_thumb_url"] = $img;
				$imageArray["icon_thumb_url"] = $img;
				$imageArray["image_object"] = null;
				$imageArray["external"] = true;

				$galleryArray["images"][] = $imageArray;

				continue;
			}
	
			$title = Title::newFromText( $img, NS_IMAGE );
	
			if ( is_null($title) ) {
				$galleryArray["missing_images"][] = $title;
				continue;
			}
	
			$ns = $title->getNamespace();
	
			if ( $ns == NS_IMAGE ) {
				if ( $img_desc != '' ) {
					$galleryArray = $this->parseImage( $title, $parser, $galleryArray, true );
					if ( isset( $galleryArray["descriptions"]["$title"] ) ) {
						$galleryArray["descriptions"]["$title"] = $img_desc;
					}
				} else {
					$galleryArray = $this->parseImage( $title, $parser, $galleryArray );
				}
			} else if ( $ns == NS_CATEGORY ) {
				//list images in category
				$cat_images = $this->smoothGalleryImagesByCat( $title );
				if ( $cat_images ) {
					foreach ( $cat_images as $title ) {
						$galleryArray = $this->parseImage( $title, $parser, $galleryArray );
					}
				}
			}
		}
	
		return $galleryArray;
	}
	
	function parseImage( $title, $parser, $galleryArray, $getDescription=false ) {
		global $wgUser;
		global $wgSmoothGalleryThumbHeight, $wgSmoothGalleryThumbWidth;
	
		$imageArray = Array();
	
		//Get the image object from the database
		$img_obj = wfFindFile( $title );
	
		if ( !$img_obj->exists() ) {
			//The user asked for an image that doesn't exist, let's
			//add this to the list of missing objects
			$galleryArray["missing_images"][] = htmlspecialchars( $title->getDBkey() );
	
			return $galleryArray;
		}
	
		//check media type. Only images are supported
		$mtype = $img_obj->getMediaType();
		if ( $mtype != MEDIATYPE_DRAWING && $mtype != MEDIATYPE_BITMAP ) {
			$galleryArray["invalid_images"][] = htmlspecialchars( $title->getDBkey() );
	
			return $galleryArray;
		}
	
		//Create a thumbnail the same size as our gallery so that
		//full images fit correctly
		$full_thumb_obj = $img_obj->getThumbnail( $this->argumentArray["width"], $this->argumentArray["height"] );
		if ( !is_null($full_thumb_obj) ) {
			$full_thumb = $full_thumb_obj->getUrl();
		} else {
			$galleryArray["missing_images"][] = htmlspecialchars( $title->getDBkey() );
	
			return $galleryArray;
		}
	
		if ( $full_thumb == '' ) {
			//The thumbnail we requested was larger than the image;
			//we need to just provide the image
			$full_thumb = $img_obj->getUrl();
		}
	
		if ( $this->argumentArray["carousel"] ) {
			//We are going to show a carousel to the user; we need
			//to make icon thumbnails
			//$thumb_obj = $img_obj->getThumbnail( 120, 120 ); //would be nice to reuse images already loaded...
			$thumb_obj = $img_obj->getThumbnail( $wgSmoothGalleryThumbWidth, $wgSmoothGalleryThumbHeight );
			if ( $thumb_obj ) {
				$icon_thumb = $thumb_obj->getUrl();
			}
			else {
				//The thumbnail we requested was larger than the image;
				//we need to just provide the image
				$icon_thumb = $img_obj->getUrl();
			}
		}
	
		$fulldesc = '';
	
		if ( $this->argumentArray["showinfopane"] ) {
			if ( $getDescription ) {
				//Load the image page from the database with the provided title from
				//the image object
				$db = wfGetDB( DB_SLAVE );
				$img_rev = Revision::loadFromTitle( $db, $title );
	
				//Get the text from the image page's description
				$fulldesc = $img_rev->getText();
			}

			//convert wikitext to HTML
			//TODO: find out why this doesn't work with special pages
			if ( $parser ) {
				$pout = $parser->recursiveTagParse( $fulldesc, $title, $parser->mOptions, true );
				$fulldesc =  strip_tags( $pout );
				#$fulldesc =  strip_tags( $pout->getText() );
			} else { //fall back to HTML-escaping
				$fulldesc = htmlspecialchars( $fulldesc );
			}
		}
	
		$skin = $wgUser->getSkin();
	
		//Everything is checked, and converted; add to the array and return
		$imageArray["title"] = $title;
	
		# We need the following for the image's div
		$imageArray["heading"] = $skin->makeKnownLinkObj($img_obj->getTitle(), $img_obj->getName());
		$imageArray["description"] = $fulldesc;
		$imageArray["full_url"] = $title->getFullURL();
		$imageArray["view_url"] = $img_obj->getViewURL();
		$imageArray["full_thumb_url"] = $full_thumb;
		$imageArray["icon_thumb_url"] = $icon_thumb;
	
		# We need the image object for plain galleries
		$imageArray["image_object"] = $img_obj;
	
		$galleryArray["images"][] = $imageArray;
	
		return $galleryArray;
	}

	function smoothGalleryImagesByCat( $title ) {
		$name = $title->getDBkey();
	
		$dbr = wfGetDB( DB_SLAVE );
	
		list( $page, $categorylinks ) = $dbr->tableNamesN( 'page', 'categorylinks' );
		$sql = "SELECT page_namespace, page_title FROM $page " .
			"JOIN $categorylinks ON cl_from = page_id " .
			"WHERE cl_to = " . $dbr->addQuotes( $name ) . " " .
			"AND page_namespace = " . NS_IMAGE . " " .
			"ORDER BY cl_sortkey";
	
		$images = array();
		$res = $dbr->query( $sql, 'smoothGalleryImagesByCat' );
		while ( $row = $dbr->fetchObject( $res ) ) {
			$img = Title::makeTitle( $row->page_namespace, $row->page_title );
	
			$images[] = $img;
		}
		$dbr->freeResult($res);
	
		return $images;
	}

}

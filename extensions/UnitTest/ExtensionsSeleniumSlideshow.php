<?php
/**
 * Wikimedia
 *
 * @author Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/**
 * @see Debug
 */
require_once 'Debug.php';

/**
 * ExtensionsSeleniumSlideshow
 * 
 * Slideshow generator for Extensions and Selenium testing
 */
class ExtensionsSeleniumSlideshow
{

	/**
	 * The extension for the unit test
	 *
	 * @param string $extension
	 */
	protected $extension = '';

	/**
	 * The images extensions permitted for generation.
	 * Currently, Selenium only generates png images.
	 *
	 * @param array $imageExtensions
	 */
	protected $imageExtensions = array(
		'.png',
	);

	/**
	 * The image directory for the slideshow.
	 *
	 * @param string $imageDirectory
	 */
	protected $imageDirectory = '';

	/**
	 * The images for the slideshow.
	 *
	 * @param array $images
	 */
	protected $images = array();

	/**
	 * If the slideshow has images, this will hold the count of images
	 *
	 * @param integer $hasImages
	 */
	protected $hasImages = 0;

	/**
	 * Messages displayed for the user.
	 *
	 * @param array $messages
	 */
	protected $messages = array();

	/**
	 * The slideshow file
	 *
	 * @param string $slideshowFilePath
	 */
	protected $slideshowFilePath = '';

	/**
	 * The slideshow title
	 *
	 * @param string $title
	 */
	protected $title = 'Selenium Smoke Test';

	/**
	 * The webRoot to the mediawiki instance.
	 *
	 * @param string $webRoot
	 */
	protected $webRoot = '';

	/**
	 *
	 *
	 * @param	string	$file		The file running the slideshow
	 * @param	string	$matches	The matches found from the image path
	 */
	public function __construct( $file )
	{
		$this->setSlideshowFilePath( $file );

		// Set the webRoot of the site
		$this->setWebRoot();

		$this->parseFilePath();

		// The image directory
		$this->imageDirectory = realpath( dirname( $this->getSlideshowFilePath() ) );
	}

	/**
	 * Generate a slideshow
	 */
	public function run()
	{

		$this->loadImages();
		
		return $this->images;
	}

	############################################################################
	#
	# Paths
	#
	############################################################################
	
	/**
	 * Parse slideshow file path
	 */
	public function parseFilePath()
	{
		///www/sites/localhost/wikimedia-commit.localhost.wikimedia.org/extensions/UnitTest/tests/UnitTest/selenium/screenshots/2012-01-22-1154-14/

		$pattern = '/(?P<IP>.*)\/extensions\/(?P<extension>\w+)\/tests\/selenium\/screenshots\/(?P<stamp>.*)/';
		$pattern = '/(?P<IP>.*)\/extensions\/(?P<extension>\w+)\/tests\/(?P<extensionUnitTest>\w+)\/selenium\/screenshots\/(?P<stamp>.*)/';
		//$pattern = '/(?P<IP>.*)\/extensions\/(?P<extension>\w+)\/tests\/(?P<extensionUnitTest>\w+)/selenium\/screenshots\/(?P<stamp>.*)/';
		$matches = array();
		preg_match( $pattern, dirname( $this->getSlideshowFilePath() ), $matches );

		//Debug::dump( $this->getSlideshowFilePath(), eval(DUMP) . '\$this->getSlideshowFilePath()' );
		//Debug::dump( $matches, eval(DUMP) . '\$matches' );

		$IP = isset( $matches['IP'] ) ? $matches['IP'] : '';
		//Debug::puke( $IP, eval(DUMP) . '\$IP' );
		$this->extension = isset( $matches['extension'] ) ? $matches['extension'] : '';
		$this->stamp = isset( $matches['stamp'] ) ? $matches['stamp'] : '';


		if ( $IP != $this->getWebRoot() ) {
			$message  = 'The web root does not match what was found based on the extension gallery path.';
			$message .= "\n" . 'IP: ' . $IP;
			$message .= "\n" . 'this->getWebRoot(): ' . $this->getWebRoot();
			throw new Exception( $message );
		}

		// Add extension to title
		if ( $this->extension != '' ) {
			$this->appendTitle( ': ' . $this->extension );
		}

		// Add stamp to title
		if ( $this->stamp != '' ) {
			$this->appendTitle( ' - ' . $this->stamp );
		}

	}
	
	/**
	 * Get the slideshow file path
	 */
	public function getSlideshowFilePath()
	{
		return $this->slideshowFilePath;
	}

	/**
	 * Set the slideshow file path
	 */
	public function setSlideshowFilePath( $file )
	{
		$this->slideshowFilePath = realpath( $file );
	}
	/**
	 * Get the web root
	 */
	public function getWebRoot()
	{
		return $this->webRoot;
	}

	/**
	 * Set the web root
	 */
	public function setWebRoot()
	{
		$this->webRoot = realpath( dirname( dirname( dirname( __FILE__ ) ) ) );
		//Debug::puke( $this->webRoot, eval(DUMP) . "\$this->webRoot" );
	}
	

	############################################################################
	#
	# Slideshow image handling
	#
	############################################################################

	/**
	 * Load images for the slideshow
	 */
	public function loadImages()
	{

		$files = scandir( $this->imageDirectory );

		foreach ( $files as $file ) {

			// Check the extension of the file to see if it is an image.
			$extension = substr( $file, -4 );

			if ( in_array( $extension, $this->imageExtensions ) ) {

				$this->images[] = $file;
			}
		}

		$this->hasImages = count( $this->images );
	}

	/**
	 * Check to see if the slideshow has images loaded.
	 *
	 * @return integer	Returns a count of the images
	 */
	public function hasImages()
	{
		return $this->hasImages;
	}

	############################################################################
	#
	# Slideshow title
	#
	############################################################################

	/**
	 * Append a string to the slideshow title.
	 *
	 * @param string	$append
	 *
	 * @return ExtensionsSeleniumSlideshow
	 */
	public function appendTitle( $append )
	{

		$this->title .= $append;

		return $this;
	}

	/**
	 * Get the slideshow title.
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	############################################################################
	#
	# Slideshow messages
	#
	############################################################################

	/**
	 * Add a message for a user.
	 *
	 * @param string	$message
	 *
	 * @return ExtensionsSeleniumSlideshow
	 */
	public function addMessage( $message )
	{

		$this->messages[] = $message;

		return $this;
	}

	/**
	 * Get the slideshow messages.
	 *
	 * @return string
	 */
	public function getMessages()
	{
		return $this->messages;
	}
}


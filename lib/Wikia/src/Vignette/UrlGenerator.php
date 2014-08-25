<?php
/**
 * UrlGenerator
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Vignette;

use Wikia\Logger\Loggable;

class UrlGenerator {
	use Loggable;

	const MODE_ORIGINAL = 'original';
	const MODE_THUMBNAIL = 'thumbnail';
	const MODE_THUMBNAIL_DOWN = 'thumbnail-down';
	const MODE_FIXED_ASPECT_RATIO = 'fixed-aspect-ratio';
	const MODE_ZOOM_CROP = 'zoom-crop';
	const MODE_ZOOM_CROP_DOWN = 'zoom-crop-down';
	const MODE_REORIENT = 'reorient';

	const REVISION_LATEST = 'latest';

	/** @var string mode of the image we're requesting */
	private $mode = self::MODE_ORIGINAL;

	/** @var string revision of the image we're requesting */
	private $revision = self::REVISION_LATEST;

	/** @var int width of the image, in pixels */
	private $width = 100;

	/** @var int height of the image, in pixels */
	private $height = 100;

	/** @var FileInterface file object we're requesting */
	private $file;

	/** @var array hash of query parameters to send to the thumbnailer */
	private $query = [];

	public function __construct($file=null) {
		if ($file !== null) {
			$this->file($file);
		}
	}

	/**
	 * @param FileInterface $file
	 * @return $this
	 */
	public function file(FileInterface $file) {
		$this->file = $file;
		return $this;
	}

	/**
	 * use the thumbnailer in a specific mode
	 *
	 * @param string $mode one of the MODE_ constants defined above
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function mode($mode) {
		if (!in_array($mode, self::validModes())) {
			$this->error("invalid mode", [
				"mode" => $mode,
			]);
			throw new \InvalidArgumentException($mode);
		}

		$this->mode = $mode;
		return $this;
	}

	public function width($width) {
		$this->width = $width;
		return $this;
	}

	public function height($height) {
		$this->height = $height;
		return $this;
	}

	/**
	 * Request a specific revision of an image
	 * @param string $revision
	 * @return $this
	 */
	public function revision($revision) {
		$this->revision = $revision;
		return $this;
	}

	/**
	 * Fill the background with a specific color, instead of white
	 * @param string $color color accepted by ImageMagick (http://www.imagemagick.org/script/color.php), or a hex code
	 * @return $this
	 */
	public function backgroundFill($color) {
		$this->query['fill'] = $color;
		return $this;
	}

	/**
	 * get url for thumbnail/image that's been built up so far
	 * @return string
	 * @throws \Exception
	 */
	public function url() {
		global $wgVignetteUrl;

		if ($this->file == null) {
			$message = "trying to generate url without a file";
			$this->error($message);
			throw new \Exception($message);
		}

		$bucketPath = self::bucketPath();
		$url = "{$wgVignetteUrl}/{$bucketPath}/{$this->file->getRel()}/revision/{$this->revision}/width/{$this->width}/height/{$this->height}";

		if ($this->revision == self::REVISION_LATEST) {
			$this->query['cb'] = $this->file->getTimestamp();
		}

		if (!empty($this->query)) {
			$url .= '?'.implode('&', array_map(function($key, $val) {
					return "{$key}=".urlencode($val);
				}, array_keys($this->query), $this->query));
		}

		return $url;
	}

	protected function getLoggerContext() {
		return [
			'file' => $this->file == null ? "" : $this->file->getName(),
		];
	}

	/**
	 * get the top level bucket for a given wiki. this may or may not be the same as $wgDBName. This is done via
	 * regular expression because there is no variable that contains the bucket name :(
	 * @return mixed
	 */
	private static function bucketPath() {
		global $wgUploadPath;
		preg_match('/http(s?):\/\/(.*?)\/(.*?)\/(.*)$/', $wgUploadPath, $matches);
		return $matches[3];
	}

	private static function validModes() {
		return [
			self::MODE_ORIGINAL,
			self::MODE_THUMBNAIL,
			self::MODE_THUMBNAIL_DOWN,
			self::MODE_FIXED_ASPECT_RATIO,
			self::MODE_ZOOM_CROP,
			self::MODE_ZOOM_CROP_DOWN,
			self::MODE_REORIENT,
		];
	}
}
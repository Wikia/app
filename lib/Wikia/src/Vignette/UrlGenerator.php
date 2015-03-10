<?php
/**
 * UrlGenerator
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Vignette;

class UrlGenerator {
	const MODE_ORIGINAL = 'original';
	const MODE_THUMBNAIL = 'thumbnail';
	const MODE_THUMBNAIL_DOWN = 'thumbnail-down';
	const MODE_FIXED_ASPECT_RATIO = 'fixed-aspect-ratio';
	const MODE_FIXED_ASPECT_RATIO_DOWN = 'fixed-aspect-ratio-down';
	const MODE_SCALE_TO_WIDTH = 'scale-to-width';
	const MODE_TOP_CROP = 'top-crop';
	const MODE_TOP_CROP_DOWN = 'top-crop-down';
	const MODE_WINDOW_CROP = 'window-crop';
	const MODE_WINDOW_CROP_FIXED = 'window-crop-fixed';
	const MODE_ZOOM_CROP = 'zoom-crop';
	const MODE_ZOOM_CROP_DOWN = 'zoom-crop-down';

	const IMAGE_TYPE_AVATAR = "avatars";
	const IMAGE_TYPE_IMAGES = "images";

	const FORMAT_WEBP = "webp";
	const FORMAT_JPG = "jpg";

	const ZONE_TEMP = "temp";

	const REVISION_LATEST = 'latest';

	/** @var UrlConfig */
	private $config;

	/** @var string mode of the image we're requesting */
	private $mode = self::MODE_ORIGINAL;

	/** @var int width of the image, in pixels */
	private $width = 100;

	/** @var int height of the image, in pixels */
	private $height = 100;

	/** @var array hash of query parameters to send to the thumbnailer */
	private $query = [];

	/** @var string one of the IMAGE_TYPE_ constants */
	private $imageType = self::IMAGE_TYPE_IMAGES;

	/** @var int for window-crop modes, where to start the window (from the left) */
	private $xOffset = 0;

	/** @var int for window-crop modes, where to start the window (from the top) */
	private $yOffset = 0;

	/** @var int for window-crop modes, the width of the window that's cropped */
	private $windowWidth = 0;

	/** @var int for window-crop modes, the height of the window that's cropped */
	private $windowHeight = 0;

	public function __construct(UrlConfig $config) {
		$this->config = $config;
		$this->original();
	}

	public function width($width) {
		$this->width = $width;
		return $this;
	}

	public function height($height) {
		$this->height = $height;
		return $this;
	}

	public function xOffset($xOffset) {
		$this->xOffset = $xOffset;
		return $this;
	}

	public function yOffset($yOffset) {
		$this->yOffset = $yOffset;
		return $this;
	}

	public function windowWidth($width) {
		$this->windowWidth = $width;
		return $this;
	}

	public function windowHeight($height) {
		$this->windowHeight = $height;
		return $this;
	}

	/**
	 * set an image's path prefix
	 * @param string $pathPrefix
	 * @return $this
	 */
	public function pathPrefix($pathPrefix) {
		if (!empty($pathPrefix)) {
			$this->query['path-prefix'] = $pathPrefix;
		}

		return $this;
	}

	/**
	 * Fill the background with a specific color, instead of white
	 * @param string $color color accepted by ImageMagick (http://www.imagemagick.org/script/color.php), or a hex code.
	 * This only applies when $this->mode = self::MODE_FIXED_ASPECT_RATIO
	 * @return $this
	 */
	public function backgroundFill($color) {
		$this->query['fill'] = $color;
		return $this;
	}

	/**
	 * for animated gifs, capture a specific frame of animation
	 * @param int $frame the frame to capture, from 0
	 * @return $this
	 */
	public function frame($frame=0) {
		$this->query['frame'] = $frame;
		return $this;
	}

	/**
	 * original image
	 * @return $this
	 */
	public function original() {
		return $this->mode(self::MODE_ORIGINAL);
	}

	/**
	 * create a new thumbnail that is allowed to be bigger than the original
	 * @return $this
	 */
	public function thumbnail() {
		return $this->mode(self::MODE_THUMBNAIL);
	}

	/**
	 * create a new thumbnail that is not allowed to be bigger than the original
	 * @return $this
	 */
	public function thumbnailDown() {
		return $this->mode(self::MODE_THUMBNAIL_DOWN);
	}

	/**
	 * zoom crop, allowed to be bigger than the original
	 * @return $this
	 */
	public function zoomCrop() {
		return $this->mode(self::MODE_ZOOM_CROP);
	}

	/**
	 * zoom crop, not allowed to be bigger than the original
	 * @return $this
	 */
	public function zoomCropDown() {
		return $this->mode(self::MODE_ZOOM_CROP_DOWN);
	}

	/**
	 * return an image that is exactly $this->width x $this->height with the source image centered vertically
	 * or horizontally (depending on which side is longer). The background is filled with the value passed to
	 * $this->backgroundFill(), or white if no background value is specified.
	 *
	 * @return $this
	 */
	public function fixedAspectRatio() {
		return $this->mode(self::MODE_FIXED_ASPECT_RATIO);
	}

	/**
	 * return an image that is exactly $this->width x $this->height with the source image centered in the image window.
	 * This mode will not allow the image to enlarge.
	 * @return $this
	 */
	public function fixedAspectRatioDown() {
		return $this->mode(self::MODE_FIXED_ASPECT_RATIO_DOWN);
	}

	/**
	 * top crop, enlargement allowed
	 * @return $this
	 */
	public function topCrop() {
		return $this->mode(self::MODE_TOP_CROP);
	}

	/**
	 * top crop, not allowed to enlarge
	 * @return $this
	 */
	public function topCropDown() {
		return $this->mode(self::MODE_TOP_CROP_DOWN);
	}

	/**
	 * dictate width, let height auto scale
	 * @param null $width
	 * @return $this
	 */
	public function scaleToWidth($width = null) {
		$this->mode(self::MODE_SCALE_TO_WIDTH);

		if ($width != null) {
			$this->width($width);
		}

		return $this;
	}

	/**
	 * crop a window into the image, scale the result to $this->width with auto height
	 * @return $this
	 */
	public function windowCrop() {
		return $this->mode(self::MODE_WINDOW_CROP);
	}

	/**
	 * crop a window into the image, scale the result to $this->width x $this->height
	 * @return $this
	 */
	public function windowCropFixed() {
		return $this->mode(self::MODE_WINDOW_CROP_FIXED);
	}

	/**
	 * Force the thumbnail request to replace the cached thumbnail.
	 *
	 * @return $this
	 */
	public function replaceThumbnail() {
		$this->query['replace'] = "true";
		return $this;
	}

	/**
	 * request an image in webp format
	 * @return $this
	 */
	public function webp() {
		return $this->format(self::FORMAT_WEBP);
	}

	public function jpg() {
		return $this->format(self::FORMAT_JPG);
	}

	public function fromStash() {
		return $this->zone(self::ZONE_TEMP);
	}

	public function avatar() {
		return $this->imageType(self::IMAGE_TYPE_AVATAR);
	}

	/**
	 * get url for thumbnail/image that's been built up so far
	 * @return string
	 * @throws \Exception
	 */
	public function url() {
		$imagePath = "{$this->config->bucket()}/{$this->imageType}/{$this->config->relativePath()}/revision/{$this->getRevision()}";

		if ( !isset( $this->query['path-prefix'] ) ) {
			$this->pathPrefix($this->config->pathPrefix());
		}

		if ( !isset( $this->query['replace'] ) && $this->config->replaceThumbnail() ) {
			$this->replaceThumbnail();
		}

		$imagePath .= $this->modePath();

		if ( !empty( $this->query ) ) {
			// ensure that the keys we use will be ordered deterministically
			ksort( $this->query );
			$queryString = http_build_query( $this->query );

			// Don't add a floating '?' if queryString ends up empty (e.g. if a valueless param is given)
			$imagePath .= empty( $queryString ) ? '' : '?'.$queryString;
		}

		return $this->domainShard( $imagePath );
	}

	public function config() {
		return $this->config;
	}

	/**
	 * @return string
	 */
	private function modePath() {
		$modePath = '';

		if ($this->mode != self::MODE_ORIGINAL) {
			$modePath .= "/{$this->mode}";

			if ($this->mode == self::MODE_SCALE_TO_WIDTH) {
				$modePath .= "/{$this->width}";
			} elseif ($this->mode == self::MODE_WINDOW_CROP || $this->mode == self::MODE_WINDOW_CROP_FIXED) {
				$modePath .= "/width/{$this->width}";

				if ($this->mode == self::MODE_WINDOW_CROP_FIXED) {
					$modePath .= "/height/{$this->height}";
				}

				$modePath .= "/x-offset/{$this->xOffset}/y-offset/{$this->yOffset}";
				$modePath .= "/window-width/{$this->windowWidth}/window-height/{$this->windowHeight}";
			} else {
				$modePath .= "/width/{$this->width}/height/{$this->height}";
			}
		}

		return $modePath;
	}


	private function getRevision() {
		$revision = self::REVISION_LATEST;

		if ($this->config->isArchive()) {
			$revision = $this->config->timestamp();
		} else {
			$this->query['cb'] = $this->config->timestamp();
		}

		return $revision;
	}

	public function getMode() {
		return $this->mode;
	}

	public function __toString() {
		return $this->url();
	}

	/**
	 * use the thumbnailer in a specific mode
	 *
	 * @param string $mode one of the MODE_ constants defined above
	 * @return $this
	 */
	public function mode($mode) {
		$this->mode = $mode;
		return $this;
	}

	public function format($format) {
		$this->query['format'] = $format;
		return $this;
	}

	public function zone($zone) {
		$this->query['zone'] = $zone;
		return $this;
	}

	private function imageType($type) {
		$this->imageType = $type;
		return $this;
	}

	private function domainShard($imagePath) {
		// shard based on original image, so frontends can build thumb urls from originals that might be cached in the
		// user's browser (VE, for instance)
		$hash = ord(sha1($this->config->relativePath()));
		$shard = 1 + ($hash % ($this->config->domainShardCount() - 1));

		return str_replace('<SHARD>', $shard, $this->config->baseUrl()) . "/{$imagePath}";
	}
}

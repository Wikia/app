<?php
/**
 * Class to render LaTeX equations as PNG
 * @author Bryan Tong Minh
 *
 */
class TrustedMath {
	/**
	 * Create a math object from a raw equation text
	 * @param string $text LaTeX equation
	 */
	public static function newFromText( $text ) {
		return new self( $text );
	}
	/**
	 * Create a math object from article text
	 * @param Title $title Title of the article
	 */
	public static function newFromTitle( $title ) {
		$article = new Article( $title, 0 );
		return new self( $article->getRawText() );
	}

	protected $text = null;
	protected $hash = null;
	protected $latex;
	protected $dvipng;
	protected $dir;
	protected $environ = array();

	/**
	 * Constructor for the math object
	 * @see TrustedMath::newFromText
	 * @param string $text LaTeX equation
	 */
	public function __construct( $text ) {
		$this->text = $text;
	}

	/**
	 * Get the base16 md5 hash of the equation
	 * @return string Base 16 hash of the equation
	 */
	public function getHash() {
		if ( is_null( $this->hash ) ) {
			$this->hash = md5( $this->getText() );
		}
		return $this->hash;
	}
	/**
	 * Get the two level relative hash path of the equation
	 * @return string
	 */
	protected function getHashPath() {
		$hash = $this->getHash();
		return $hash{0} . '/' . $hash{0} . $hash{1};
	}

	/**
	 * Get the LaTeX equation text
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 * Set the path to the latex and dvipng renders
	 * @param string $latex
	 * @param string $dvipng
	 */
	public function setRenderers( $latex, $dvipng ) {
		$this->latex = $latex;
		$this->dvipng = $dvipng;
	}
	/**
	 * Set the base path of the output directory
	 * @param string $path
	 */
	public function setBasePath( $path ) {
		$this->dir = $path;
	}
	/**
	 * Set the environment variables for the renders
	 * @param array $environ Hashmap of the environment
	 */
	public function setEnvironment( $environ ) {
		$this->environ = $environ;
	}

	/**
	 * Render the LaTeX equation as PNG and store it into
	 * $wgTrustedMathDirectory under a two level hash path. Will not re-render
	 * if the file already exists
	 *
	 * @param bool $force Force re-rendering the file
	 * @return Status Status object with $value set to the relative path of
	 * the rendered equation on success.
	 */
	public function render( $force = false ) {
		// Determine output path
		$hash = $this->getHash();
		$hashPath = $this->getHashPath();
		$filePath = "{$this->dir}/$hashPath/$hash.png";

		// Check equation existence
		if ( !$force && file_exists( $filePath ) &&
				filesize( $filePath ) > 0 ) {
			return Status::newGood( "$hashPath/$hash.png" );
		}

		// Create the hash path
		wfSuppressWarnings();
		if ( !wfMkDirParents( "{$this->dir}/$hashPath", null, __METHOD__ ) ) {
			wfRestoreWarnings();
			return Status::newFatal( 'trustedmath-path-error', $hashPath );
		}
		wfRestoreWarnings();

		// Create a random file, wrap the equation in LaTeX and store it
		$file = "{$this->dir}/$hash" . wfBaseConvert( mt_rand(), 10, 36 );
		file_put_contents( "$file.tex", self::wrapEquation( $this->getText() ) );

		$retval = null;

		// Render the LaTeX file as DVI
		$output = wfShellExec( wfEscapeShellArg( $this->latex,
			 '-halt-on-error', '-output-directory',
			$this->dir, "$file.tex" ) . ' 2>&1', $retval, $this->environ );
		if ( !file_exists( "$file.dvi" ) ) {
			// Something went wrong, return the output of the latex command
			$this->cleanup( $file );
			return Status::newFatal( 'trustedmath-convert-error',
				$this->latex, $output );
		}

		// Render the DVI file as PNG
		$output = wfShellExec( wfEscapeShellArg( $this->dvipng ) .
			' -D 150 -T tight -v -o ' .
			wfEscapeShellArg( $filePath, "$file.dvi" ), $retval, $this->environ );
		if ( !file_exists( $filePath ) ) {
			// Something went wrong, return the output of the dvipng command
			$this->cleanup( $file );
			return Status::newFatal( 'trustedmath-convert-error',
				$this->dvipng, $output );
		}

		// Everything ok, return the path
		$this->cleanup( $file );
		return Status::newGood( "$hashPath/$hash.png" );
	}

	/**
	 * Wrap a LaTeX equation in the minimum amount required to render it
	 * @param string $equation
	 * @return string
	 */
	protected static function wrapEquation( $equation ) {
		return implode( "\n", array(
			'\documentclass{article}',
			'\pagestyle{empty}',
			'\usepackage{amsmath}',
			'\begin{document}',
			'\begin{equation*}',
			trim( $equation ),
			'\end{equation*}',
			'\end{document}',
		) );
	}

	/**
	 * Clean-up the mess left behind by the rendering process. Deletes all
	 * files whose name without extension is equation to $file
	 * @param string $file The file name including path to it
	 */
	protected static function cleanup( $file ) {
		$dir = dirname( $file );
		$iter = new RegexIterator( new DirectoryIterator( $dir ),
			'#^' . preg_quote( basename( $file ) ) . '\..*$#' );

		wfSuppressWarnings();
		foreach ( $iter as $file ) {
			unlink( "$dir/$file" );
		}
		wfRestoreWarnings();
	}

}

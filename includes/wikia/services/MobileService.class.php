<?PHP

/**
 * Mobile service
 *
 * @author Federico "Lox" Lucignano
 */
class MobileService extends Service {
	private $mUserAgent;
	private $mAgents;
	private $mIsMobile;
	private $mCurrentAgent;
	
	private static $mInstance;
	
	public static function getInstance(){
		if( empty( self::$mInstance ) ) {
			self::$mInstance = new MobileService;
		}
		
		return self::$mInstance;
	}
	
	function __construct(){
		$this->mUserAgent = ( !empty( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) ? $_SERVER[ 'HTTP_USER_AGENT' ] : 'unknown';
		$this->mAgents = array(
			'winmo' => 'Windows CE',
			'kindle' => 'Kindle',
			'opera_mini' => 'Opera Mini',
			'ie_mobile' => 'IEMobile',
			'android' => 'Android',
			'symbian' => 'Symbian',
			'danger' => 'Danger',
			'blackberry' => 'BlackBerry',
			'ipod' => 'iPod',
			'iphone' => 'iPhone',
			'ipad' => 'iPad',
			'googlebot_mobile' => 'Googlebot-Mobile'
		);
	}
	
	public function isMobile(){
		if ( empty( $this->mIsMobile ) ) {
			$this->mIsMobile = preg_match( "/" . implode( '|' , $this->mAgents ) . "/i", $this->mUserAgent );
		}
		
		return $this->mIsMobile;
	}
	
	public function isIPhone(){
		$this->identify();
		return ( $this->mCurrentAgent == 'iphone' );
	}
	
	public function isIPad(){
		$this->identify();
		return ( $this->mCurrentAgent == 'ipad' );
	}
	
	public function isIPod(){
		$this->identify();
		return ( $this->mCurrentAgent == 'ipod' );
	}
	
	public function isIOS(){
		$this->identify();
		return ( $this->isIPod() || $this->isIPad() || $this->isIPhone() );
	}
	
	public function isAndroid(){
		$this->identify();
		return ( $this->mCurrentAgent == 'android' );
	}
	
	public function isWindowsMobile(){
		$this->identify();
		return ( $this->mCurrentAgent == 'winmo' );
	}
	
	public function isBlackBerry(){
		$this->identify();
		return ( $this->mCurrentAgent == 'blackberry' );
	}
	
	public function isSymbian(){
		$this->identify();
		return ( $this->mCurrentAgent == 'symbian' );
	}
	
	public function isKindle(){
		$this->identify();
		return ( $this->mCurrentAgent == 'kindle' );
	}
	
	private function identify(){
		if ( empty( $this->mCurrentAgent ) && $this->isMobile() ) {
			foreach( $this->mAgents as $id => $regEx ) {
				if ( preg_match( "/{$regEx}/i", $this->mUserAgent ) ) {
					$this->mCurrentAgent = $id;
					break;
				}
			}
		}
	}
}
<?php

class AdProviderLiftDNA implements iAdProvider {
	protected static $instance = false;

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderLiftDNA();
		}
		return self::$instance;
	}

	public function getSetupHtml() {
		wfProfileIn(__METHOD__);

		static $called = false;
		if ($called) {
			wfProfileOut(__METHOD__);
			return false;
		}
		$called = true;

		$out = '';

		$out .= '<script type="text/javascript" src="http://rt.liftdna.com/rtb_dart.js"></script>
				<script type="text/javascript" src="http://rt.liftdna.com/Site.js"></script>';
		$out .= '<script type="text/javascript">
				LD_SetSite("wka.gaming/_fallout/article");
				LD_SetTargeting("s0=gaming;s1=_fallout;s2=home;age=13-17;age=18-34;eth=cauc;kids=0-2;kids=13-17;hhi=0-30;hhi=60-100;edu=nocollege;age=teen;age=yadult;esrb=mature;gnre=adventure;gnre=fps;gnre=rpg;pform=pc;pform=xbox360;sex=m;volum=l;dev=obsidianentertainment;pub=bethesda;pform=ps3;sub=apocalypse;artid=1;dmn=wikiacom;hostpre=fallout;wpage=Fallout_Wiki;lang=en;dis=large;hasp=yes;cat=the_vault;cat=main_page;cat=portals;loc=top;src=driver;");';

		foreach($this->slotsToCall as $slotname) {
			$out .= 'LD_SetTag("' . $slotname . '", "pos=TOP_RIGHT_BOXAD;", "dcopt=ist;sz=728x90;mtfInline=true;tile=true;");';
		}

		$out .= 'LD_GetBids();
				</script>';

		wfProfileOut(__METHOD__);

		return $out;
	}

	public function getAd($slotname, $slot, $params = null) {
		return null;
	}

	private $slotsToCall = array();
	public function addSlotToCall($slotname){
		$this->slotsToCall[]=$slotname;
	}
	public function batchCallAllowed(){ return false; }
	public function getBatchCallHtml(){ return false; }
}
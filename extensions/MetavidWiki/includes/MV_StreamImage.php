<?php
/*
 * MV_OggImage.php Created on Nov 29, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 * 
 * set up all the default settings (can be overwritten) 
 */

//two modes -stand alone- and -mediaWiki-
 
if ( !defined( 'MEDIAWIKI' ) ){
	die('not an entry point');
	//*stand alone mode*
	//need to setup db connection, etc grab the LocalSettings.php  
	//include_once('../')
	
	//get config values etc	
	//start object and serv image: 	
	//$MV_OggImage = new MV_OggImage(array('mode'=>'stand_alone'));
	//$MV_OggImage->doManuallRequest();	
}

//serves up images and does necessary transforms if the file does not exist
//@@TODO in the future it would be ideal if it was integrated similar to oggHandler
//http://www.mediawiki.org/wiki/Extension:OggHandler
// (ie streams images use normal mediaWiki file handlers and 
// are placed in the image directory) 
//* this is not easy to enforce while *Stream* is not tied to a given uploaded file*
//all static functions: 
class MV_StreamImage{
	/*
	 * getStreamImageURL
	 * 
	 * @parm:
	 * 	$stream_name: the unique stream name
	 *  $req_time: the requested time in seconds or ntp format: hh:mm:ss
	 *  $req_size: the requested size in WidthxHeight .. (or small, keyword see getSizeType)
	 *  $directLink: if we should return a direct pointer to the file or give a url with &t=time in it
	 * 		(to support javascript applications that adjust the time parameter for retrieving thumbnails)
	 */
	function getStreamImageURL($stream_id, $req_time=null, $req_size=null, $directLink=false){
		global $wgScript,  $mvWebImgLoc, $mvLocalImgLoc,$mvExternalImages;
		//check global external image prefrence: 
		$req_size_out = ($req_size!=null)?'&size='.$req_size :'';
		if($mvExternalImages){
			global $mvExternalImgServerPath;
			//try to get the stream_name for external requests: 
			$sn = MV_Stream::getStreamNameFromId($stream_id);			
			return $mvExternalImgServerPath . '?action=ajax&rs=mv_frame_server&stream_name='.$sn.'&t='.$req_time.$req_size_out;
		}
		
		//by default return a non-direct link so that javascript can modify the url to get new images
		if(!$directLink){
			return $wgScript.'?action=ajax&rs=mv_frame_server&stream_id='.$stream_id.'&t='.$req_time.$req_size_out;
		}
		$req_time = MV_StreamImage::procRequestTime($stream_id, $req_time);
		if($req_time==false){			
			return MV_StreamImage::getMissingImageURL($req_size);
		}		
		//print "got req time: $req_time<br />";
		//first check if the file exist
		if(is_file(MV_StreamImage::getLocalImagePath($stream_id, $req_time, $req_size))){			
			if($req_size==null){
				$s='';
				$ext='jpg'; //default type is jpg
			}else{				
				list($im_width, $im_height, $ext) = MV_StreamImage::getSizeType($req_size);
				$s='_'.$im_width.'x'.$im_height;				
			}			
			return $mvWebImgLoc .'/'. MV_StreamImage::getRelativeImagePath($stream_id) .
				'/'.$req_time.$s.'.'.$ext;
		}else{	
			//throw 'error finding image';	
			return MV_StreamImage::getMissingImageURL($req_size);
		}	
	}
	function getMissingImageURL($req_size=null){
		global $mvWebImgLoc,$mvDefaultVideoPlaybackRes;
		if($req_size==null)$req_size=$mvDefaultVideoPlaybackRes;
		list($im_width, $im_height, $ext) = MV_StreamImage::getSizeType($req_size);
		$s='';
		if($req_size)$s='_'.$im_width.'x'.$im_height;	
		
		if(MV_StreamImage::getMissingImagePath($req_size, $s, $ext) ){
			return $mvWebImgLoc .'/images_not_available'.$s.'.'.$ext;
		}
	}
	function getMissingImagePath($req_size){		
		global $mvLocalImgLoc, $mvLocalImgLoc;
		list($im_width, $im_height, $ext) = MV_StreamImage::getSizeType($req_size);
		$s='';
		if($req_size)$s='_'.$im_width.'x'.$im_height;	
		
		if(is_file($mvLocalImgLoc.'/images_not_available'.$s.'.'.$ext)){
			return $mvLocalImgLoc.'/images_not_available'.$s.'.'.$ext;
		}else{
			//try and generate it;			
			if(!MV_StreamImage::doTransformImage($mvLocalImgLoc.'/images_not_available.jpg', 
					$mvLocalImgLoc.'/images_not_available'.$s.'.'.$ext, 
					$im_width, $im_height, $ext)){		
				return $mvLocalImgLoc.'/images_not_available.jpg';
			}else{
				return $mvLocalImgLoc.'/images_not_available'.$s.'.'.$ext;
			}
		}
	}
	function getStreamImageRaw($stream_id, $req_time=null, $req_size=null){	
		//print "get raw img\n";
		$req_time = MV_StreamImage::procRequestTime($stream_id, $req_time);
		list($im_width, $im_height, $ext) = MV_StreamImage::getSizeType($req_size);
		
		if(!$req_time){
			$img_path = $s='_'.$im_width.'x'.$im_height;
		}	
		$img_path = MV_StreamImage::getLocalImagePath($stream_id, $req_time, $req_size);
		list($im_width, $im_height, $ext) = MV_StreamImage::getSizeType($req_size);		
		if($ext=='jpg')header("Content-type: image/jpeg");
		if($ext=='png')header("Content-type: image/png");
		//print "img path: $img_path";
		if(is_file($img_path)){						
			//print "file present: $img_path";
			@readfile($img_path);
		}else{
			@readfile(MV_StreamImage::getMissingImagePath($req_size));
		}
	}
	function procRequestTime($stream_id, $req_time){
		global $mvStreamImageTable, $mvShellOggFrameGrab, $mvImageGranularityRate;
		if(!$req_time)$req_time='0';
		if(count(explode(":",$req_time))==3){
			$req_time = ntp2seconds($req_time);
		}else{
			if(!is_numeric($req_time) && $req_time >= 0 ){
				throw "error in req time format";
			}
		}		
		//query the image db to find the closest to req time (while still being in front)
		$dbr = & wfGetDB(DB_READ);		
		//if($req_time<$mvImageGranularityRate)$req_time = $mvImageGranularityRate;
		$select = " `id`, `time`, `time`-'$req_time' as distance ";
		$cond = " `stream_id`=$stream_id 
				AND (`time`-'$req_time')>=0 
				AND (`time`-'$req_time')<= $mvImageGranularityRate";
		$opt['ORDER BY']=' `distance` ASC ';
		$opt['LIMIT']=1;
		$res = $dbr->select($mvStreamImageTable, $select, $cond, 'MV_StreamImage::procRequestTime', $opt);
		//print $dbr->lastQuery();
		//die;
		if($dbr->numRows($res)==0){
			//could do a request to generate image for video here:
			if(MV_StreamImage::genLocalStreamImage($stream_id, $req_time, '320x240')){
				//we just generated the current request time return it as valid: 
				return $req_time;
			}else{
				return false;
			}			
		}else{
			$img_row = $dbr->fetchObject($res);
			$req_time = $img_row->time;
		}		
		return $req_time;		 
	}
	/*generate the requested image if possible /necessary */
	function getLocalImagePath($stream_id, $req_time, $req_size=null){
		$img_dir = MV_StreamImage::getLocalImageDir($stream_id);		
		list($im_width, $im_height, $ext) = MV_StreamImage::getSizeType($req_size);
		$base_img = $img_dir.'/'.$req_time.'.jpg';
		//print "base img: $base_img \n";
		if($req_size==null){			
			if(is_file($base_img)){
				return $base_img;
			}else{
				//Based on settings we may do an ffmpeg call here:
				//@@FFMPEG call goes here:
				//make the call to generate the image for that time: 
				return MV_StreamImage::genLocalStreamImage($stream_id, $req_time, $req_size);
			}			
		}else{			
			$img_file = $img_dir.'/'.$req_time .'_'.$im_width.'x'.$im_height.'.'.$ext;
			//print "img with size: $img_file \n";
			if(is_file($img_file)){
				//print "FOUND FILE: $img_file";
				return $img_file;
			}else{

				if(!is_file($base_img)){		
					//print "missing base img $base_img \n";			
					$img_file = MV_StreamImage::genLocalStreamImage($stream_id, $req_time, $req_size);
					if(is_file($base_img)){
						//got file succesfull: 
						//continue:
					} else {
						return false;
					}
				} 
				//would be great to use mediaWIki's bitmap transform but not super easy to integrate...
				//@@todo eventually we should integrate with oggHanlder... 
				//$thumb = Bitmap::doTransform($image)
				if(!MV_StreamImage::doTransformImage($base_img, $img_file, $im_width, $im_height, $ext)){
					//print 'failed image transform\n';
					return false;
				}			
				return $img_file;										
			}
		}
	}
	function doTransformImage($base_img, $img_file, $im_width, $im_height, $ext='jpg'){
		list($base_width, $base_height, $type, $attr) = getimagesize($base_img);		
		$gd_img_base = imagecreatefromjpeg($base_img);		
		$gd_img_dest = imagecreatetruecolor($im_width, $im_height);
		imagecopyresampled($gd_img_dest, $gd_img_base, 0,0, 0,0, $im_width,$im_height, $base_width, $base_height);			
		
		if($ext=='jpg'){			
			//write out the image:
			if(!imagejpeg($gd_img_dest, $img_file, 90)){				
				return false;
			}			
		}else{
			if($im_width==80){
				$dcolors=128;
			}else{
				$dcolors=256;
			}		
			ImageTrueColorToPalette2($gd_img_dest,false,$dcolors);			
			if(!imagepng($gd_img_dest, $img_file)){
				return false;
			}			
		}		
		imagedestroy($gd_img_base);
		imagedestroy($gd_img_dest);
		//success:	
		return true;
	}
	function getLocalImageDir($stream_id){
		global $mvLocalImgLoc;
		$img_dir = $mvLocalImgLoc.'/'. MV_StreamImage::getRelativeImagePath($stream_id);
		if(!is_dir($img_dir)){
			if(!mkdir($img_dir, 0777, true)){
				echo "error in making dir: $img_dir";
			}
		}
		return $img_dir;
	}
	function getRelativeImagePath($stream_id){
		return substr($stream_id, -1).'/'.$stream_id;
	}	
	function getSizeType($req_size){
		$type='jpg';
		if(isset($req_size)){
			if($req_size!=''){
				switch($req_size){
					case 'icon':case '80x60':
						$width=80;$height=60;
						$type='png';
					break;
					case 'small':case '160x120':
						$width=160;$height=120;
						$type='png';
					break;
					case 'medium':case '320x240':
						$width=320;$height=240;
					break;	
					case 'large':case '512x384':
						$width=480;$height=360;
					break;
					case 'full':case '720x540':
						//this is somewhat legacy as our capture card is now set to 512x384 but in a HQ setup could be useful. 
						$width=720;$height=540;
					break;				
					default: 
						//defaults to 320x240 if size does not match above: 
						$width=320;$height=240;
					break;
				}
			}else{
				//default size is 320x240
				$width=320;$height=240;
			}
		}else{
			$width=320;$height=240;
		}
		return array($width, $height, $type);
	}

	function genLocalStreamImage ($stream_id, $req_time, $req_size) {
		global $mvLocalVideoPath, $mvStreamImageTable;

		if (!$stream_id) return false;
		if (!$req_time) $req_time=0;
		if (!$req_size) $req_size='320x240';

        list($im_width, $im_height, $ext) = MV_StreamImage::getSizeType($req_size);
        if($req_size==null){
        	$s='';
        }else{
        	$s='_'.$im_width.'x'.$im_height;
        }

		$img_dir = MV_StreamImage::getLocalImageDir($stream_id);
		$img_file = $img_dir . "/" . $req_time . $s . "." . $ext;

		$streampath = $mvLocalVideoPath .
		  MV_StreamImage::getLocalStreamPath($stream_id);

		if (is_file($streampath)){
			//check if the ffmpeg extension is installed: 			
			$extension = "ffmpeg";
			$extension_soname = $extension . "." . PHP_SHLIB_SUFFIX;
			$extension_fullname = PHP_EXTENSION_DIR . "/" . $extension_soname;	
			// load extension
			if(!extension_loaded($extension)) {
			    if(!dl($extension_soname)){
			    	return false;
			    }  
			}	
			$mov = new ffmpeg_movie($streampath);
			$fps = $mov->getFrameRate();
			if ($req_time == 0){ 
				$ff_frame = $mov->getFrame(1); 
			} else { 
				$ff_frame = $mov->getFrame($req_time * $fps);
			}	
			if ($ff_frame) {
			    $ff_frame->resize($im_width, $im_height);
			    $gd_image = $ff_frame->toGDImage();
			    if ($gd_image) {
					if ($ext == 'png') {
					    imagepng($gd_image, $img_file);
					    imagedestroy($gd_image);
					} else {
				            imagejpeg($gd_image, $img_file);
				            imagedestroy($gd_image);
					}
			    }
			}
			if (is_file($img_file) && ($req_size == '320x240' || $req_size == '')) {	
	            $insAry = array ();
			    $insAry[stream_id]=$stream_id;
			    $insAry[time]=$req_time;
	
              	$db = & wfGetDB(DB_WRITE);
                if ($db->insert($mvStreamImageTable, $insAry)) {
                	return $img_file;
                } else {
	                //probably error out before we get here
	                return false;
                }	
			}
		}
		return $img_file;
	}

	function getLocalStreamPath ($stream_id, $quality='') {
		global $mvStreamTable, $mvLocalVideoLoc;
		//grab streamFile		
		$stream =& mvGetMVStream(array('id'=>$stream_id));
		$stream->db_load_stream();
		$streamFile = new MV_StreamFile($stream);		
		return $streamFile->getLocalPath();
	}
}


function ImageTrueColorToPalette2($image, $dither, $ncolors) {	
   $width = imagesx( $image );
   $height = imagesy( $image );
   $colors_handle = ImageCreateTrueColor( $width, $height );
   @imagecopymerge( $colors_handle, $image, 0, 0, 0, 0, $width, $height, 100 );
   @imagetruecolortopalette( $image, $dither, $ncolors );
   if(function_exists('imagecolormatch') ){
		@imagecolormatch( $colors_handle, $image );
   }
   //@imagedestroy($colors_handle);
   return $image;
}
?>
<?php
/*
This file is part of the Kaltura Collaborative Media Suite which allows users 
to do with audio, video, and animation what Wiki platfroms allow them to do with 
text.

Copyright (C) 2006-2008  Kaltura Inc.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/



// this will be used as a global parameter
$ks = null; 
class kalturaService
{
	const KALTURA_API_VERSION = "0.7";
	
	const KALTURA_SERIVCE_FORMAT_JSON  = 1;
	const KALTURA_SERIVCE_FORMAT_XML  = 2;
	const KALTURA_SERIVCE_FORMAT_PHP  = 3;
	
	private $partner_id ;
	private $subp_id;
	private $format;
	private $ks;

	private static function signature ( $params )
	{
		ksort($params);
		$str = "";
		foreach ($params as $k => $v)
		{
			$str .= $k.$v;
		}
		return  md5($str);
	}

	public static function getInstance ( $kaltura_user )
	{
		global $partner_id;
		$kaltura_services = new kalturaService( $partner_id );
		$result = $kaltura_services->start( $kaltura_user );
		
		return $kaltura_services;
	}
	
	public function kalturaService ( $partner_id , $format = self::KALTURA_SERIVCE_FORMAT_PHP /*self::KALTURA_SERIVCE_FORMAT_XML */)
	{
		global $subp_id;
		$this->partner_id = $partner_id;
		$this->subp_id = $subp_id;
		$this->format = $format;
	}
	
	
	public function getKs()
	{
		return $this->ks;
	}
	
	public function hit ($method, $kaltura_user , $params)
	{
		$start_time = microtime (true );
		global $SERVICE_URL;
		global $log_kaltura_services;

if ( $log_kaltura_services ) kalturaLog ( "\n\n[$SERVICE_URL]" );
		
		// append the basic params
		$params["kaltura_api_version"] = self::KALTURA_API_VERSION;
		$params['partner_id'] = $this->partner_id;
		$params['subp_id'] = $this->subp_id;
		$params['format'] = $this->format;
		$params['uid'] = $kaltura_user->puser_id;
		$params['user_name'] = $kaltura_user->puser_name ;
		
		if ( $this->ks ) $params['ks'] = $this->ks;  
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $SERVICE_URL . $method);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, '');
		curl_setopt($ch, CURLOPT_TIMEOUT, 10 );

		$signature = self::signature ( $params );
		$params['kalsig'] = $signature ;
		
	if ( $log_kaltura_services ) kalturaLog ( "\n\n--> $method|{$kaltura_user->puser_id}|" . print_r ( $params , true ) );		
		$result = curl_exec($ch);
	if ( $log_kaltura_services ) kalturaLog ( "<-- " . print_r ( $result , true ) );
 
	
		curl_close($ch);
		
		if ( $this->format == self::KALTURA_SERIVCE_FORMAT_PHP )
		{
			if ( $log_kaltura_services ) kalturaLog ( "-PHP-> strlen " .strlen ( $result ) );
			$final_result = @unserialize($result);
			if ( is_array ( $final_result ))
			{
				if ( $log_kaltura_services ) kalturaLog ( "<-PHP- count" . print_r ( $final_result , true )  );	
			}
			else
			{
				if ( $log_kaltura_services ) kalturaLog ( "<-PHP- ??" );
			}
		}
		else
		{
			$final_result = $result;
		}
		
		$end_time = microtime (true );
		
		if ( $log_kaltura_services ) kalturaLog ( "<--> $method|{$kaltura_user->puser_id}| time [" . ( $end_time - $start_time ) . "]" );
		return $final_result;
	}

	public function start ( $kaltura_user )
	{
		global $secret;
		global $ks;
		
		if ( ! $kaltura_user instanceof kalturaUser )
		{
			throw new Exception ( __CLASS__ . ":" . "kaltura user must be of type 'kaltura_user'" );
		}
		// the puser_id is mandatory (therfore part of the funciton)
		// the puser_name is optional and will help create the proper name in the puser_kuser table
		$params = array( "secret" => $secret );

		$generic_result = $this->hit ( "startsession" , $kaltura_user , $params );
		$error = 	@$generic_result["error"];
		$result = 	@$generic_result["result"];
		$debug =  	@$generic_result["debug"];

		$this->ks = @$result["ks"];
		$ks = $this->ks ;
		
		// TODO - fixme !!
		return $generic_result;
		
		if ( $this->ks ) return true;
		
		throw new Exception ( $error[0] );	
	}

	
	public function getuser ( $kaltura_user , $params = null)
	{
		if ( $params == null )			$params = array();
		
		$generic_result = $this->hit ( "getuser" , $kaltura_user, $params );
		return $generic_result;
	}

	public function getkshow ( $kaltura_user , $params = null)
	{
		if ( $params == null )			$params = array();
		
		$generic_result = $this->hit ( "getkshow" , $kaltura_user, $params );
		return $generic_result;
	}
	
	// expect kshow_id
	public function addkshow ( $kaltura_user , $params = null)
	{
		if ( $params == null )			$params = array();
		
		$generic_result = $this->hit ( "addkshow" , $kaltura_user, $params );
		return $generic_result;
	}

	public function rollbackkshow ( $kaltura_user , $params = null)
	{
		if ( $params == null )			$params = array();
		
		$generic_result = $this->hit ( "updatekshow" , $kaltura_user, $params );
		return $generic_result;
	}
	
	
	public function updatekshow ( $kaltura_user , $params = null)
	{
		if ( $params == null )			$params = array();
		
		$generic_result = $this->hit ( "updatekshow" , $kaltura_user, $params );
		return $generic_result;
	}	
	
	public function addentry ( $kaltura_user , $params = null)
	{
		if ( $params == null )			$params = array();
		
		$generic_result = $this->hit ( "addentry" , $kaltura_user, $params );
		return $generic_result;
	}		
}

class kalturaUser
{
	var $puser_name;
	var $puser_id;
	var $kuser_name;
	var $kuser_id;
}
?>

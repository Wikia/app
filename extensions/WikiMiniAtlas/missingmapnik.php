<?
$url = $_SERVER["REQUEST_URI"];
$base = "/~dschwen/wikiminiatlas/tiles/mapnik";
$tilegen = "/home/dschwen/wikiminiatlas/mapnik/mapniktile";

//
// is the requested URL pointing to a tile set dir?
//
if( substr($url,0,strlen($base)) == $base )
{
  //
  // is the tile filename format correct?
  //
  if( preg_match('{^([0-9]+)\/tile_([0-9]+)_([0-9]+)\.png$}',substr($url,strlen($base)), $matches) )
  {
   $z = intval($matches[1]);
   $y = intval($matches[2]);
   $x = intval($matches[3]);

   $mx = 3 * ( 1 << $z );
   $my = $mx/2;

   //
   // was a legal tile number requested?
   //
   if( $z>=8 && $y>=0 && $x>=0 && $x<$mx && $y<$my ) 
   {
    $tfile = "mapnik$z/tile_" . $y . "_" . $x . ".png";
    umask( 0033 );
    exec( $tilegen . " " . ($z-1) . " " . $y . " " . $x . " " . $tfile );
   
    if( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 )
    {
     header( 'Content-type: image/png' );
     readfile( $tfile );
    }
    else
    {
     header( "Location: $url" );
     header( 'Status: 302' );
    }
   }
   else echo "outside range";
  }
  else echo "filename format error";
}
?>

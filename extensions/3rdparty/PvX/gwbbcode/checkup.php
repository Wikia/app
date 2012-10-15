<pre><?
$dir = isset($_GET['dir']) ? $_GET['dir'] : '';
$dir = str_replace('\\', '/', $dir);
$dir = './' . str_replace('..', '', $dir);   //Make sure dir can't be above gwbbcode's dir
$dir = preg_replace('@/+$@', '', $dir) . '/'; //Make sure dir ends with a slash
check_dir($dir);

function check_dir($dir) {
   if (!is_dir($dir)) {
      echo "Unknown dir $dir\n";
      return;
   }
   //Harvest data on the dir content
   $count = 0;
   $files = Array();
   $dirs = Array();
   if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {
         if (strpos($file, '.') !== 0 && is_file($dir.$file)) {
            $count++;
            $files[md5($file)] = md5(file_get_contents($dir.$file));
         }
         else if (strpos($file, '.') !== 0 && is_dir($dir.$file)) {
            $dirs[md5($file)] = 'dir';
         }
      }
      closedir($dh);
   }
   
   //Output harvested data
   ksort($files);
   ksort($dirs);
   echo "<table border=\"1\"><tbody><tr><td colspan=\"2\">$dir ($count file" . ($count>1?'s':'') . ")</td></tr>\n";
   foreach ($dirs as $name => $content) {
      echo "<tr><td>".substr($name, 0, 5)."</td><td>$content</td></tr>\n";
   }
   foreach ($files as $name => $content) {
      echo "<tr><td>".substr($name, 0, 5)."</td><td>$content</td></tr>\n";
   }
   echo "</tbody></table>\n";
}
?></pre>
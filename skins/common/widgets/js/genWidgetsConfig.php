<?php
/* simple script to generate the widgetsConfig. I'm guessing there is another one somewhere,
 * but I couldn't find it
 */
$filename = dirname(__FILE__) . "/widgetsConfig.js";

$filedata = file_get_contents($filename);

$data = str_replace('var widgetsConfig = ', '', $filedata);
$data = preg_replace('/;$/', '', $data);

$array = (json_decode($data, true));
// Add your new stuff here

$array['WidgetAnswers'] = 
array (
  'title' => 
  array (
    'en' => 'Wikia Answers',
  ),
  'desc' => 
  array (
    'en' => 'A list of recent unanswered questions'
  ),
  'groups' => 
  array (
  )
);

echo 'var widgetsConfig = ' . json_encode($array) . ';';

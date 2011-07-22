<?php
define(MAIN_PATH, realpath('.'));

include_once MAIN_PATH.'/FacebookConnect/init.php';

$one_line_stories_templates = $short_story_templates = $full_stories = array();

$one_line_stories_templates[] = '{*actor*} asks "<a href="{*url*}">{*question*}</a>" at Wikianswers.';
$short_story_templates[] = array("template_title" => '{*actor*} wants to know "<a href="{*url*}">{*question*}</a>" at Wikianswers', "template_body" => 'There can be a lot more text here.  Possibly a blurb about Wikianswers.  Or whatever.');
$action_links[] = array("text"=>"Answer this question", "href" =>"{*editurl*}");

$form_id = facebook_client()->api_client->feed_registerTemplateBundle($one_line_stories_templates,$short_story_templates,null,$action_links);
echo "templateId is " . $form_id;
  
?>

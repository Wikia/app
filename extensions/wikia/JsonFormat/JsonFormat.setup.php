<?php

$dir = dirname(__FILE__);
$app = F::app();

$wgAutoloadClasses['HtmlToJsonFormatParser'] =                $dir . "/HtmlToJsonFormatParser.php";
$wgAutoloadClasses['WikitextToHtmlParser'] =                  $dir . "/WikitextToHtmlParser.php";
$wgAutoloadClasses['WikitextToJsonFormatParserFactory'] =     $dir . "/WikitextToJsonFormatParserFactory.php";
$wgAutoloadClasses['WikitextToJsonFormatParser'] =            $dir . "/WikitextToJsonFormatParser.php";
$wgAutoloadClasses['JsonFormatService'] =                     $dir . "/JsonFormatService.php";
$wgAutoloadClasses['JsonFormatBuilder'] =                     $dir . "/JsonFormatBuilder.php";

$wgAutoloadClasses['JsonFormatContainerNode'] =               $dir . "/nodes/JsonFormatContainerNode.php";
$wgAutoloadClasses['JsonFormatParagraphNode'] =               $dir . "/nodes/JsonFormatParagraphNode.php";
$wgAutoloadClasses['JsonFormatLinkNode'] =                    $dir . "/nodes/JsonFormatLinkNode.php";
$wgAutoloadClasses['JsonFormatNode'] =                        $dir . "/nodes/JsonFormatNode.php";
$wgAutoloadClasses['JsonFormatRootNode'] =                    $dir . "/nodes/JsonFormatRootNode.php";
$wgAutoloadClasses['JsonFormatSectionNode'] =                 $dir . "/nodes/JsonFormatSectionNode.php";
$wgAutoloadClasses['JsonFormatTextNode'] =                    $dir . "/nodes/JsonFormatTextNode.php";
$wgAutoloadClasses['JsonFormatListNode'] =                    $dir . "/nodes/JsonFormatListNode.php";
$wgAutoloadClasses['JsonFormatListItemNode'] =                $dir . "/nodes/JsonFormatListItemNode.php";
$wgAutoloadClasses['JsonFormatTableNode'] =                   $dir . "/nodes/JsonFormatTableNode.php";
$wgAutoloadClasses['JsonFormatTableCellNode'] =               $dir . "/nodes/JsonFormatTableCellNode.php";
$wgAutoloadClasses['JsonFormatTableRowNode'] =                $dir . "/nodes/JsonFormatTableRowNode.php";

$wgAutoloadClasses['AVisitor'] =                              $dir . "/visitors/AVisitor.php";
$wgAutoloadClasses['TableVisitor'] =                          $dir . "/visitors/TableVisitor.php";
$wgAutoloadClasses['TableOfContentsVisitor'] =                $dir . "/visitors/TableOfContentsVisitor.php";
$wgAutoloadClasses['PVisitor'] =                              $dir . "/visitors/PVisitor.php";
$wgAutoloadClasses['BVisitor'] =                              $dir . "/visitors/BVisitor.php";
$wgAutoloadClasses['IVisitor'] =                              $dir . "/visitors/IVisitor.php";
$wgAutoloadClasses['InlineVisitor'] =                         $dir . "/visitors/InlineVisitor.php";
$wgAutoloadClasses['ListVisitor'] =                           $dir . "/visitors/ListVisitor.php";
$wgAutoloadClasses['BodyVisitor'] =                           $dir . "/visitors/BodyVisitor.php";
$wgAutoloadClasses['CompositeVisitor'] =                      $dir . "/visitors/CompositeVisitor.php";
$wgAutoloadClasses['DOMNodeVisitorBase'] =                    $dir . "/visitors/DOMNodeVisitorBase.php";
$wgAutoloadClasses['HeaderVisitor'] =                         $dir . "/visitors/HeaderVisitor.php";
$wgAutoloadClasses['IDOMNodeVisitor'] =                       $dir . "/visitors/IDOMNodeVisitor.php";
$wgAutoloadClasses['TextNodeVisitor'] =                       $dir . "/visitors/TextNodeVisitor.php";

$wgAutoloadClasses['DomHelper'] =                             $dir . "/util/DomHelper.php";

$app->registerApiController( 'JsonFormatApiController', "{$dir}/JsonFormatApiController.php" );

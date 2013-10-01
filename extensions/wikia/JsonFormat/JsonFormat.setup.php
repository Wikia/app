<?php

$dir = dirname(__FILE__);
$app = F::app();

$app->registerClass( 'Wikia\JsonFormat\HtmlParser',           $dir . "/HtmlParser.php");
$app->registerClass( 'JsonFormatService',                     $dir . "/JsonFormatService.php");
$app->registerClass( 'JsonFormatBuilder',                     $dir . "/JsonFormatBuilder.php");
$app->registerClass( 'JsonFormatException',                   $dir . "/JsonFormatException.php");
$app->registerClass( 'Wikia\JsonFormat\JsonFormatSimplifier', $dir . "/JsonFormatSimplifier.php");

$app->registerClass( 'JsonFormatContainerNode',               $dir . "/nodes/JsonFormatContainerNode.php");
$app->registerClass( 'JsonFormatParagraphNode',               $dir . "/nodes/JsonFormatParagraphNode.php");
$app->registerClass( 'JsonFormatLinkNode',                    $dir . "/nodes/JsonFormatLinkNode.php");
$app->registerClass( 'JsonFormatNode',                        $dir . "/nodes/JsonFormatNode.php");
$app->registerClass( 'JsonFormatRootNode',                    $dir . "/nodes/JsonFormatRootNode.php");
$app->registerClass( 'JsonFormatSectionNode',                 $dir . "/nodes/JsonFormatSectionNode.php");
$app->registerClass( 'JsonFormatTextNode',                    $dir . "/nodes/JsonFormatTextNode.php");
$app->registerClass( 'JsonFormatListNode',                    $dir . "/nodes/JsonFormatListNode.php");
$app->registerClass( 'JsonFormatListItemNode',                $dir . "/nodes/JsonFormatListItemNode.php");
$app->registerClass( 'JsonFormatTableNode',                   $dir . "/nodes/JsonFormatTableNode.php");
$app->registerClass( 'JsonFormatTableCellNode',               $dir . "/nodes/JsonFormatTableCellNode.php");
$app->registerClass( 'JsonFormatTableRowNode',                $dir . "/nodes/JsonFormatTableRowNode.php");
$app->registerClass( 'JsonFormatImageFigureNode',             $dir . "/nodes/JsonFormatImageFigureNode.php");
$app->registerClass( 'JsonFormatQuoteNode',                   $dir . "/nodes/JsonFormatQuoteNode.php");
$app->registerClass( 'JsonFormatImageNode',                   $dir . "/nodes/JsonFormatImageNode.php");
$app->registerClass( 'JsonFormatInfoboxNode',                 $dir . "/nodes/JsonFormatInfoboxNode.php");
$app->registerClass( 'JsonFormatInfoboxKeyValueNode',         $dir . "/nodes/JsonFormatInfoboxKeyValueNode.php");
$app->registerClass( 'JsonFormatInfoboxValueNode',            $dir . "/nodes/JsonFormatInfoboxValueNode.php");

$app->registerClass( 'DivContainingHeadersVisitor',           $dir . "/visitors/DivContainingHeadersVisitor.php");
$app->registerClass( 'VideoVisitor',                          $dir . "/visitors/VideoVisitor.php");
$app->registerClass( 'AVisitor',                              $dir . "/visitors/AVisitor.php");
$app->registerClass( 'BrVisitor',                             $dir . "/visitors/BrVisitor.php");
$app->registerClass( 'TableVisitor',                          $dir . "/visitors/TableVisitor.php");
$app->registerClass( 'TableOfContentsVisitor',                $dir . "/visitors/TableOfContentsVisitor.php");
$app->registerClass( 'PVisitor',                              $dir . "/visitors/PVisitor.php");
$app->registerClass( 'BVisitor',                              $dir . "/visitors/BVisitor.php");
$app->registerClass( 'IVisitor',                              $dir . "/visitors/IVisitor.php");
$app->registerClass( 'InlineVisitor',                         $dir . "/visitors/InlineVisitor.php");
$app->registerClass( 'ListVisitor',                           $dir . "/visitors/ListVisitor.php");
$app->registerClass( 'BodyVisitor',                           $dir . "/visitors/BodyVisitor.php");
$app->registerClass( 'CompositeVisitor',                      $dir . "/visitors/CompositeVisitor.php");
$app->registerClass( 'DOMNodeVisitorBase',                    $dir . "/visitors/DOMNodeVisitorBase.php");
$app->registerClass( 'HeaderVisitor',                         $dir . "/visitors/HeaderVisitor.php");
$app->registerClass( 'IDOMNodeVisitor',                       $dir . "/visitors/IDOMNodeVisitor.php");
$app->registerClass( 'TextNodeVisitor',                       $dir . "/visitors/TextNodeVisitor.php");
$app->registerClass( 'ImageFigureNoScriptVisitor',            $dir . "/visitors/ImageFigureNoScriptVisitor.php");
$app->registerClass( 'ImageFigureVisitor',                    $dir . "/visitors/ImageFigureVisitor.php");
$app->registerClass( 'QuoteVisitor',                          $dir . "/visitors/QuoteVisitor.php");
$app->registerClass( 'ImageNoScriptVisitor',                  $dir . "/visitors/ImageNoScriptVisitor.php");
$app->registerClass( 'ImageVisitor',                          $dir . "/visitors/ImageVisitor.php");
$app->registerClass( 'InfoboxTableVisitor',                   $dir . "/visitors/InfoboxTableVisitor.php");

$app->registerClass( 'DomHelper',                             $dir . "/util/DomHelper.php");

$app->registerApiController( 'JsonFormatApiController', "{$dir}/JsonFormatApiController.php" );

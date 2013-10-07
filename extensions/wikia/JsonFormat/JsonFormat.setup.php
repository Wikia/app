<?php

$dir = dirname(__FILE__);
$app = F::app();

$wgAutoloadClasses[ 'Wikia\JsonFormat\HtmlParser' ] =           $dir . "/HtmlParser.php";
$wgAutoloadClasses[ 'JsonFormatService' ] =                     $dir . "/JsonFormatService.php";
$wgAutoloadClasses[ 'JsonFormatBuilder' ] =                     $dir . "/JsonFormatBuilder.php";
$wgAutoloadClasses[ 'JsonFormatException' ] =                   $dir . "/JsonFormatException.php";
$wgAutoloadClasses[ 'Wikia\JsonFormat\JsonFormatSimplifier' ] = $dir . "/JsonFormatSimplifier.php";

$wgAutoloadClasses[ 'JsonFormatContainerNode' ] =               $dir . "/nodes/JsonFormatContainerNode.php";
$wgAutoloadClasses[ 'JsonFormatParagraphNode' ] =               $dir . "/nodes/JsonFormatParagraphNode.php";
$wgAutoloadClasses[ 'JsonFormatLinkNode' ] =                    $dir . "/nodes/JsonFormatLinkNode.php";
$wgAutoloadClasses[ 'JsonFormatNode' ] =                        $dir . "/nodes/JsonFormatNode.php";
$wgAutoloadClasses[ 'JsonFormatRootNode' ] =                    $dir . "/nodes/JsonFormatRootNode.php";
$wgAutoloadClasses[ 'JsonFormatSectionNode' ] =                 $dir . "/nodes/JsonFormatSectionNode.php";
$wgAutoloadClasses[ 'JsonFormatTextNode' ] =                    $dir . "/nodes/JsonFormatTextNode.php";
$wgAutoloadClasses[ 'JsonFormatListNode' ] =                    $dir . "/nodes/JsonFormatListNode.php";
$wgAutoloadClasses[ 'JsonFormatListItemNode' ] =                $dir . "/nodes/JsonFormatListItemNode.php";
$wgAutoloadClasses[ 'JsonFormatTableNode' ] =                   $dir . "/nodes/JsonFormatTableNode.php";
$wgAutoloadClasses[ 'JsonFormatTableCellNode' ] =               $dir . "/nodes/JsonFormatTableCellNode.php";
$wgAutoloadClasses[ 'JsonFormatTableRowNode' ] =                $dir . "/nodes/JsonFormatTableRowNode.php";
$wgAutoloadClasses[ 'JsonFormatImageFigureNode' ] =             $dir . "/nodes/JsonFormatImageFigureNode.php";
$wgAutoloadClasses[ 'JsonFormatQuoteNode' ] =                   $dir . "/nodes/JsonFormatQuoteNode.php";
$wgAutoloadClasses[ 'JsonFormatImageNode' ] =                   $dir . "/nodes/JsonFormatImageNode.php";
$wgAutoloadClasses[ 'JsonFormatInfoboxNode' ] =                 $dir . "/nodes/JsonFormatInfoboxNode.php";
$wgAutoloadClasses[ 'JsonFormatInfoboxKeyValueNode' ] =         $dir . "/nodes/JsonFormatInfoboxKeyValueNode.php";
$wgAutoloadClasses[ 'JsonFormatInfoboxValueNode' ] =            $dir . "/nodes/JsonFormatInfoboxValueNode.php";

$wgAutoloadClasses[ 'DivContainingHeadersVisitor' ] =           $dir . "/visitors/DivContainingHeadersVisitor.php";
$wgAutoloadClasses[ 'VideoVisitor' ] =                          $dir . "/visitors/VideoVisitor.php";
$wgAutoloadClasses[ 'AVisitor' ] =                              $dir . "/visitors/AVisitor.php";
$wgAutoloadClasses[ 'BrVisitor' ] =                             $dir . "/visitors/BrVisitor.php";
$wgAutoloadClasses[ 'TableVisitor' ] =                          $dir . "/visitors/TableVisitor.php";
$wgAutoloadClasses[ 'TableOfContentsVisitor' ] =                $dir . "/visitors/TableOfContentsVisitor.php";
$wgAutoloadClasses[ 'PVisitor' ] =                              $dir . "/visitors/PVisitor.php";
$wgAutoloadClasses[ 'BVisitor' ] =                              $dir . "/visitors/BVisitor.php";
$wgAutoloadClasses[ 'IVisitor' ] =                              $dir . "/visitors/IVisitor.php";
$wgAutoloadClasses[ 'InlineVisitor' ] =                         $dir . "/visitors/InlineVisitor.php";
$wgAutoloadClasses[ 'ListVisitor' ] =                           $dir . "/visitors/ListVisitor.php";
$wgAutoloadClasses[ 'BodyVisitor' ] =                           $dir . "/visitors/BodyVisitor.php";
$wgAutoloadClasses[ 'CompositeVisitor' ] =                      $dir . "/visitors/CompositeVisitor.php";
$wgAutoloadClasses[ 'DOMNodeVisitorBase' ] =                    $dir . "/visitors/DOMNodeVisitorBase.php";
$wgAutoloadClasses[ 'HeaderVisitor' ] =                         $dir . "/visitors/HeaderVisitor.php";
$wgAutoloadClasses[ 'IDOMNodeVisitor' ] =                       $dir . "/visitors/IDOMNodeVisitor.php";
$wgAutoloadClasses[ 'TextNodeVisitor' ] =                       $dir . "/visitors/TextNodeVisitor.php";
$wgAutoloadClasses[ 'ImageFigureNoScriptVisitor' ] =            $dir . "/visitors/ImageFigureNoScriptVisitor.php";
$wgAutoloadClasses[ 'ImageFigureVisitor' ] =                    $dir . "/visitors/ImageFigureVisitor.php";
$wgAutoloadClasses[ 'QuoteVisitor' ] =                          $dir . "/visitors/QuoteVisitor.php";
$wgAutoloadClasses[ 'ImageNoScriptVisitor' ] =                  $dir . "/visitors/ImageNoScriptVisitor.php";
$wgAutoloadClasses[ 'ImageVisitor' ] =                          $dir . "/visitors/ImageVisitor.php";
$wgAutoloadClasses[ 'InfoboxTableVisitor' ] =                   $dir . "/visitors/InfoboxTableVisitor.php";
$wgAutoloadClasses[ 'TruebloodScrollWrapperVisitor' ] =         $dir . "/visitors/TruebloodScrollWrapperVisitor.php";

$wgAutoloadClasses[ 'DomHelper' ] =                             $dir . "/util/DomHelper.php";

$wgAutoloadClasses[ 'JsonFormatApiController' ] =               $dir . "/JsonFormatApiController.php";
$wgWikiaApiControllers[ 'JsonFormatApiController' ] =           $dir . "/JsonFormatApiController.php";

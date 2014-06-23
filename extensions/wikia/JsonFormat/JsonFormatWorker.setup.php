<?php

$dir = dirname(__FILE__);

require_once($dir . "/HtmlParser.php");
require_once($dir . "/JsonFormatBuilder.php");
require_once($dir . "/JsonFormatException.php");
require_once($dir . "/JsonFormatSimplifier.php");

require_once($dir . "/nodes/JsonFormatNode.php");
require_once($dir . "/nodes/JsonFormatContainerNode.php");
require_once($dir . "/nodes/JsonFormatParagraphNode.php");
require_once($dir . "/nodes/JsonFormatLinkNode.php");
require_once($dir . "/nodes/JsonFormatRootNode.php");
require_once($dir . "/nodes/JsonFormatSectionNode.php");
require_once($dir . "/nodes/JsonFormatTextNode.php");
require_once($dir . "/nodes/JsonFormatListNode.php");
require_once($dir . "/nodes/JsonFormatListItemNode.php");
require_once($dir . "/nodes/JsonFormatTableNode.php");
require_once($dir . "/nodes/JsonFormatTableCellNode.php");
require_once($dir . "/nodes/JsonFormatTableRowNode.php");
require_once($dir . "/nodes/JsonFormatImageFigureNode.php");
require_once($dir . "/nodes/JsonFormatQuoteNode.php");
require_once($dir . "/nodes/JsonFormatImageNode.php");
require_once($dir . "/nodes/JsonFormatInfoboxNode.php");
require_once($dir . "/nodes/JsonFormatInfoboxKeyValueNode.php");
require_once($dir . "/nodes/JsonFormatInfoboxValueNode.php");

require_once($dir . "/visitors/IDOMNodeVisitor.php");
require_once($dir . "/visitors/DOMNodeVisitorBase.php");
require_once($dir . "/visitors/DivContainingHeadersVisitor.php");
require_once($dir . "/visitors/VideoVisitor.php");
require_once($dir . "/visitors/AVisitor.php");
require_once($dir . "/visitors/BrVisitor.php");
require_once($dir . "/visitors/TableVisitor.php");
require_once($dir . "/visitors/TableOfContentsVisitor.php");
require_once($dir . "/visitors/PVisitor.php");
require_once($dir . "/visitors/BVisitor.php");
require_once($dir . "/visitors/IVisitor.php");
require_once($dir . "/visitors/InlineVisitor.php");
require_once($dir . "/visitors/ListVisitor.php");
require_once($dir . "/visitors/BodyVisitor.php");
require_once($dir . "/visitors/CompositeVisitor.php");
require_once($dir . "/visitors/HeaderVisitor.php");
require_once($dir . "/visitors/TextNodeVisitor.php");
require_once($dir . "/visitors/ImageFigureNoScriptVisitor.php");
require_once($dir . "/visitors/ImageFigureVisitor.php");
require_once($dir . "/visitors/QuoteVisitor.php");
require_once($dir . "/visitors/ImageNoScriptVisitor.php");
require_once($dir . "/visitors/ImageVisitor.php");
require_once($dir . "/visitors/DivImageVisitor.php");
require_once($dir . "/visitors/SliderVisitor.php");
require_once($dir . "/visitors/InfoboxTableVisitor.php");
require_once($dir . "/visitors/TruebloodScrollWrapperVisitor.php");
require_once($dir . "/visitors/AmericandadWrapperVisitor.php");

require_once($dir . "/util/DomHelper.php");

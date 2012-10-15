<!DOCTYPE html>

<html>
	<head>
		<title>HybridSurface Demo</title>
		<link rel="stylesheet" href="styles/es.SurfaceView.css">
		<link rel="stylesheet" href="../modules/es/styles/es.ContextView.css">
		<link rel="stylesheet" href="../modules/es/styles/es.ContentView.css">
		<link rel="stylesheet" href="styles/es.DocumentView.css">
		<link rel="stylesheet" href="../modules/es/styles/es.Inspector.css">
		<link rel="stylesheet" href="../modules/es/styles/es.ToolbarView.css">
		<link rel="stylesheet" href="../modules/es/styles/es.MenuView.css">
		<link rel="stylesheet" href="../modules/sandbox/sandbox.css">
		<style>
			::-moz-selection {
			       background-color: #b3d6f6;
			}
			::selection {
			       background-color: #b3d6f6;
			}
			body {
				font-family: "Arial";
				font-size: 1em;
				width: 100%;
				margin: 1em 0;
				padding: 0;
				overflow-y: scroll;
				background-color: white;
			}
			#es-base {
				margin: 2em;
				margin-top: 0em;
				-webkit-box-shadow: 0 0.25em 1.5em 0 #dddddd;
				-moz-box-shadow: 0 0.25em 1.5em 0 #dddddd;
				box-shadow: 0 0.25em 1.5em 0 #dddddd;
				-webkit-border-radius: 0.5em;
				-moz-border-radius: 0.5em;
				-o-border-radius: 0.5em;
				border-radius: 0.5em;
			}
			#es-panes {
				border: solid 1px #cccccc;
				border-top: none;
			}
			#es-visual {
				padding-left: 1em;
				padding-right: 1em;
			}
			#es-toolbar {
				-webkit-border-radius: 0;
				-moz-border-radius: 0;
				-o-border-radius: 0;
				border-radius: 0;
				-webkit-border-top-right-radius: 0.25em;
				-moz-border-top-right-radius: 0.25em;
				-o-border-top-right-radius: 0.25em;
				border-top-right-radius: 0.25em;
				-webkit-border-top-left-radius: 0.25em;
				-moz-border-top-left-radius: 0.25em;
				-o-border-top-left-radius: 0.25em;
				border-top-left-radius: 0.25em;
			}
			#es-toolbar.float {
				left: 2em;
				right: 2em;
				top: 0;
			}
			#es-docs {
				margin-left: 2.5em;
			}
		</style>
	</head>
	<body>
<?php
$modeWikitext = "Toggle wikitext view";
$modeJson = "Toggle JSON view";
$modeHtml = "Toggle HTML view";
$modeRender = "Toggle preview";
$modeHistory = "Toggle transaction history view";
$modeHelp = "Toggle help view";

include( '../modules/sandbox/base.php' );

?>

		<script src="diff_match_patch.js"></script>
		
		<!-- Rangy -->
		<script src="rangy/rangy-core.js"></script>
		<script src="rangy/rangy-position.js"></script>
		
		<!--
		<script src="rangy/rangy-cssclassapplier.js"></script>
		<script src="rangy/rangy-selectionsaverestore.js"></script>
		<script src="rangy/rangy-serializer.js"></script>
		-->
		
		<!-- EditSurface -->
		<script src="../modules/jquery/jquery.js"></script>
		<script src="../modules/es/es.js"></script>
		<script src="../modules/es/es.Html.js"></script>
		<script src="../modules/es/es.Position.js"></script>
		<script src="../modules/es/es.Range.js"></script>
		<script src="../modules/es/es.TransactionProcessor.js"></script>

		<!-- Serializers -->
		<script src="../modules/es/serializers/es.AnnotationSerializer.js"></script>
		<script src="../modules/es/serializers/es.HtmlSerializer.js"></script>
		<script src="../modules/es/serializers/es.JsonSerializer.js"></script>
		<script src="../modules/es/serializers/es.WikitextSerializer.js"></script>

		<!-- Bases -->
		<script src="../modules/es/bases/es.EventEmitter.js"></script>
		<script src="../modules/es/bases/es.DocumentNode.js"></script>
		<script src="../modules/es/bases/es.DocumentModelNode.js"></script>
		<script src="../modules/es/bases/es.DocumentBranchNode.js"></script>
		<script src="../modules/es/bases/es.DocumentLeafNode.js"></script>
		<script src="../modules/es/bases/es.DocumentModelBranchNode.js"></script>
		<script src="../modules/es/bases/es.DocumentModelLeafNode.js"></script>
		<script src="../modules/es/bases/es.DocumentViewNode.js"></script>
		<script src="../modules/es/bases/es.DocumentViewBranchNode.js"></script>
		<script src="views/es.DocumentViewLeafNode.js"></script>
		<script src="../modules/es/bases/es.Inspector.js"></script>
		<script src="../modules/es/bases/es.Tool.js"></script>

		<!-- Models -->
		<script src="../modules/es/models/es.SurfaceModel.js"></script>
		<script src="../modules/es/models/es.DocumentModel.js"></script>
		<script src="../modules/es/models/es.ParagraphModel.js"></script>
		<script src="../modules/es/models/es.PreModel.js"></script>
		<script src="../modules/es/models/es.ListModel.js"></script>
		<script src="../modules/es/models/es.ListItemModel.js"></script>
		<script src="../modules/es/models/es.TableModel.js"></script>
		<script src="../modules/es/models/es.TableRowModel.js"></script>
		<script src="../modules/es/models/es.TableCellModel.js"></script>
		<script src="../modules/es/models/es.HeadingModel.js"></script>
		<script src="../modules/es/models/es.TransactionModel.js"></script>

		<!-- Inspectors -->
		<script src="../modules/es/inspectors/es.LinkInspector.js"></script>

		<!-- Tools -->
		<script src="../modules/es/tools/es.ButtonTool.js"></script>
		<script src="../modules/es/tools/es.AnnotationButtonTool.js"></script>
		<script src="../modules/es/tools/es.ClearButtonTool.js"></script>
		<script src="../modules/es/tools/es.HistoryButtonTool.js"></script>
		<script src="../modules/es/tools/es.ListButtonTool.js"></script>
		<script src="../modules/es/tools/es.IndentationButtonTool.js"></script>
		<script src="../modules/es/tools/es.DropdownTool.js"></script>
		<script src="../modules/es/tools/es.FormatDropdownTool.js"></script>

		<!-- Views -->
		<!--
		<script src="../modules/es/views/es.SurfaceView.js"></script>
		<script src="../modules/es/views/es.ToolbarView.js"></script>
		<script src="../modules/es/views/es.ContentView.js"></script>
		<script src="../modules/es/views/es.ContextView.js"></script>
		<script src="../modules/es/views/es.ParagraphView.js"></script>
		<script src="../modules/es/views/es.PreView.js"></script>
		<script src="../modules/es/views/es.ListView.js"></script>
		<script src="../modules/es/views/es.MenuView.js"></script>
		<script src="../modules/es/views/es.ListItemView.js"></script>
		<script src="../modules/es/views/es.HeadingView.js"></script>
		-->
		<script src="views/es.DocumentView.js"></script>
		<script src="views/es.TableView.js"></script>
		<script src="views/es.TableRowView.js"></script>
		<script src="views/es.TableCellView.js"></script>
		<script src="views/es.SurfaceView.js"></script>
		<script src="views/es.ContentView.js"></script>
		<script src="views/es.DocumentView.js"></script>
		<script src="views/es.ParagraphView.js"></script>
		<script src="views/es.ToolbarView.js"></script>
		

		<!-- Demo -->
		<script src="main.js"></script>
	</body>
</html>

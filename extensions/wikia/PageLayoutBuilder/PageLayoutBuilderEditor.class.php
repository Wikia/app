<?php

	class PageLayoutBuilderEditor {

		static protected $extraMessages = array(
			'plb-editor-edit',
			'plb-editor-overlay-edit',
			'plb-parser-image-size-not-int',
			'plb-parser-image-size-too-big',
			'plb-property-editor-value-required',
		);

		/**
		 * Returns javascript representing the widgets library
		 *
		 * @return string
		 */
		static public function getData() {
			global $wgPLBwidgets;
			$widgetNames = array_keys($wgPLBwidgets);

			$template = new EasyTemplate( dirname( __FILE__ ) . '/widget/templates/' );
			$widgets = array();
			$messages = array();
			foreach ($widgetNames as $widgetName) {
				$template->set_vars(array(
					'widgetName' => $widgetName,
				));
				$widgetForm = Wikia::json_encode($template->render("pe-form-wrapper"));

				$widgetLogic = "";
				if ($template->template_exists("pe-form-$widgetName-js")) {
					$widgetLogic = $template->render("pe-form-$widgetName-js");
					if (empty($widgetLogic)) {
						$widgetLogic = "";
					}
				}

				$widgetInstance = new $wgPLBwidgets[$widgetName];
				$widgets[$widgetName] = array(
					'form' => $widgetForm,
					'editor_menu_item_html' => Wikia::json_encode($widgetInstance->renderEditorMenuItem()),
					'editor_list_item_html' => Wikia::json_encode($widgetInstance->renderEditorListItem()),
					'html' => Wikia::json_encode($widgetInstance->RTEElementDecoratorAndRender(true)),
					'attributes' => Wikia::json_encode($widgetInstance->getAllAttrs()),
					'required_attributes' => Wikia::json_encode($widgetInstance->getRequiredAttrs()),
					'attribute_captions' => Wikia::json_encode($widgetInstance->getAttrCaptions()),
					'logic' => $widgetLogic,
				);

				// Add translations
				$messages["plb-widget-name-$widgetName"] = wfMsg("plb-widget-name-$widgetName");
			}

			$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );

			$data = array(
				'toolboxHtml' => $template->render('toolbox'),
				'editorCss' => array(
					wfGetSassUrl('extensions/wikia/PageLayoutBuilder/css/rte.scss'),
				)
			);

			foreach (self::$extraMessages as $message) {
				$messages[$message] = wfMsg($message);
			}

			$template->set_vars(array(
				'widgets' => $widgets,
				'data' => Wikia::json_encode($data),
				'messages' => Wikia::json_encode($messages),
			));

			return $template->render("plb-editor-data-js");
		}

		static public function getPLBEditorData() {
			wfLoadExtensionMessages('PageLayoutBuilder');

			$response = new AjaxResponse();
			$response->addText( PageLayoutBuilderEditor::getData() );

//			header("X-Pass-Cache-Control: s-maxage=315360000, max-age=315360000");
//			$response->setCacheDuration( 3600 * 24 * 365);
			return $response;
		}

	}
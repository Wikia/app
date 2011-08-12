<?php

	class PageLayoutBuilderEditor {

		static protected $extraMessages = array(
			'plb-editor-edit',
			'plb-editor-rte-caption',
			'plb-editor-overlay-edit',
			'plb-editor-read-only-selection-info',
			'plb-parser-image-size-not-int',
			'plb-parser-image-size-too-big',
			'plb-editor-toolbar-caption',
			'plb-editor-toolbar-formatting',
			'plb-editor-toolbar-static',
			'plb-editor-preview-desc',
			'plb-property-editor-value-required',
		);

		/**
		 * Returns javascript representing the widgets library
		 *
		 * @return string
		 */
		static public function getData() {
			global $wgPLBwidgets, $wgExtensionsPath, $wgUser;
			$widgetNames = array_keys($wgPLBwidgets);

			$template = new EasyTemplate( dirname( __FILE__ ) . '/widget/templates/' );
			$widgets = array();
			$messages = array();
			foreach ($widgetNames as $widgetName) {
				$widgetInstance = new $wgPLBwidgets[$widgetName];

				$template->set_vars(array(
					'widgetName' => $widgetName,
					'preview' => $widgetInstance->renderForFormCaption().$widgetInstance->renderForForm()
				));
				$widgetForm = Wikia::json_encode($template->render("pe-form-wrapper"));

				$widgetLogic = "";
				if ($template->template_exists("pe-form-$widgetName-js")) {
					$widgetLogic = $template->render("pe-form-$widgetName-js");
					if (empty($widgetLogic)) {
						$widgetLogic = "";
					}
				}

				$widgets[$widgetName] = array(
					'form' => $widgetForm,
					'caption' => Wikia::json_encode($widgetInstance->getNameCaption()),
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
					AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/EditPageReskin/PageLayoutBuilder/css/rte.scss'),
				)
			);

			foreach (self::$extraMessages as $message) {
				$messages[$message] = wfMsg($message);
			}

			$helpbox = array('db' => $wgUser->getOption("plbhidehelpbox"), 'show' => 0);

			if( !$wgUser->getOption("plbhidehelpbox") ) {
				$helpboxTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
				$helpboxTmpl->set_vars(array(
					's1' => $wgExtensionsPath. "/wikia/EditPageReskin/PageLayoutBuilder/images/help/s1.png",
					's2' => $wgExtensionsPath. "/wikia/EditPageReskin/PageLayoutBuilder/images/help/s2.png",
					's3' => $wgExtensionsPath. "/wikia/EditPageReskin/PageLayoutBuilder/images/help/s3.png",
					'helplink' => Title::newFromText( wfMsg('plb-helpbox-help-link-title'), NS_HELP )->getFullUrl(),
					'arrow' => $wgExtensionsPath. "/wikia/EditPageReskin/PageLayoutBuilder/images/help/arrow.png"
				));

				$helpbox['html'] = $helpboxTmpl->render("helpbox");
				$helpbox['show'] = 1;
			}

			$template->set_vars(array(
				'widgets' => $widgets,
				'helpbox' => Wikia::json_encode($helpbox),
				'data' => Wikia::json_encode($data),
				'messages' => Wikia::json_encode($messages),
				'cssfile' => AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/EditPageReskin/PageLayoutBuilder/css/editor.scss')
			));
			return $template->render("plb-editor-data-js");
		}

		static public function closeHelpbox() {
			global $wgUser, $wgRequest;
			$response = new AjaxResponse();
			if($wgUser->getID() > 0) {
				$wgUser->setOption("plbhidehelpbox", ($wgRequest->getVal("val") == "true") );
				$wgUser->saveSettings();
				$response->addText( Wikia::json_encode(array("status" => "ok")));
			} else {
				$response->addText(Wikia::json_encode(array("status" => "error")));
			}
			return $response;
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
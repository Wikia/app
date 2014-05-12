class VisualEditorPage
  include PageObject

  include URL
  page_url URL.url("User:#{ENV['MEDIAWIKI_USER']}/#{ENV['BROWSER']}?vehidebetadialog=true")

  div(:container_disabled, class: "oo-ui-widget oo-ui-widget-disabled oo-ui-flaggableElement-constructive oo-ui-.oo-ui-buttonedElement-framed")
  div(:content, class: "ve-ce-documentNode ve-ce-branchNode")
  span(:decrease_indentation, class: "oo-ui-iconedElement-icon oo-ui-icon-outdent-list")
  a(:decrease_indentation_on, title: /Decrease indentation/)
  span(:downarrow, class: "oo-ui-indicatedElement-indicator oo-ui-indicator-down")
  a(:edit_ve, title: /Edit this page with VisualEditor/)
  a(:edit_wikitext, title: /You can edit this page\./)
  a(:heading, text: /Heading/)
  span(:increase_indentation, class: "oo-ui-iconedElement-icon oo-ui-icon-indent-list")
  a(:increase_indentation_on, title: /Increase indentation/)
  span(:insert_menu, text: "Insert")
  div(:insert_references, class: "oo-ui-window-title")
  span(:internal_linksuggestion, text: "Main Page")
  div(:ip_warning, class: "ve-ui-mwNoticesPopupTool-item")
  span(:linksuggestion, text: "http://www.example.com")
  span(:looks_good, class: "oo-ui-labeledElement-label", text: "Looks good to me")
  span(:newpage_linksuggestion, text: "DoesNotExist")
  div(:page_text, id: "mw-content-text")
  a(:page_title, text: /Page title/)
  a(:paragraph, text: /Paragraph/)
  a(:preformatted, text: /Preformatted/)
  span(:refs_link, text: "Reference")
  div(:save_disabled, class: "oo-ui-widget oo-ui-widget-disabled oo-ui-flaggableElement-constructive oo-ui-.oo-ui-buttonedElement-framed")
  span(:save_page, class: "oo-ui-labeledElement-label", text: "Save page")
  a(:subheading1, text: /Sub-heading 1/)
  a(:subheading2, text: /Sub-heading 2/)
  a(:subheading3, text: /Sub-heading 3/)
  a(:subheading4, text: /Sub-heading 4/)
  span(:switch_to_source_editing, class: "oo-ui-iconedElement-icon oo-ui-icon-source")

  if ENV["BROWSER"] == "chrome"
    div(:tools_menu, class: "oo-ui-widget oo-ui-widget-enabled oo-ui-toolGroup oo-ui-iconedElement oo-ui-popupToolGroup oo-ui-listToolGroup")
  else
    span(:tools_menu, class: "oo-ui-iconedElement-icon oo-ui-icon-menu")
  end

  span(:ve_bold_text, class: "oo-ui-iconedElement-icon oo-ui-icon-bold-b")
  span(:ve_bullets, class: "oo-ui-iconedElement-icon oo-ui-icon-bullet-list")
  span(:ve_computer_code, class: "oo-ui-iconedElement-icon oo-ui-icon-code")
  div(:ve_heading_menu, class: "oo-ui-iconedElement-icon oo-ui-icon-down")
  span(:ve_link_icon, class: "oo-ui-iconedElement-icon oo-ui-icon-link")
  span(:ve_italics, class: "oo-ui-iconedElement-icon oo-ui-icon-italic-i")
  span(:ve_media_menu, class: "oo-ui-iconedElement-icon oo-ui-icon-picture")
  span(:ve_references, class: "oo-ui-iconedElement-icon oo-ui-icon-reference")
  span(:ve_numbering, class: "oo-ui-iconedElement-icon oo-ui-icon-number-list")
  span(:ve_strikethrough, class: "oo-ui-iconedElement-icon oo-ui-icon-strikethrough-s")
  span(:ve_subscript, class: "oo-ui-iconedElement-icon oo-ui-icon-subscript")
  span(:ve_superscript, class: "oo-ui-iconedElement-icon oo-ui-icon-superscript")
  span(:ve_text_style, class: "oo-ui-iconedElement-icon oo-ui-icon-text-style")
  span(:ve_underline, class: "oo-ui-iconedElement-icon oo-ui-icon-underline-u")
  div(:visual_editor_toolbar, class: "oo-ui-toolbar-tools")
  span(:transclusion, class: "oo-ui-iconedElement-icon oo-ui-icon-template")
  text_area(:wikitext_editor, id: "wpTextbox1")

  in_iframe(index: 0) do |frame|
    a(:beta_warning, title: "Close", frame: frame)
    div(:content_box, class: "ve-ce-documentNode ve-ce-branchNode", frame: frame)
    span(:leftarrowclose, class: "oo-ui-iconedElement-icon oo-ui-icon-previous", frame: frame)
    text_field(:link_textfield, index: 0, frame: frame)
    span(:another_save_page, class: "oo-ui-labeledElement-label", text: "Save page", frame: frame)
    div(:ve_link_ui, class: "oo-ui-window-title", frame: frame)
  end

  # not having beta warning makes iframes off by one
  in_iframe(index: 0) do |frame|
    span(:add_parameter, text: "Add parameter", frame: frame)
    span(:add_template, text: "Add template", frame: frame)
    span(:insert_template, text: "Insert template", frame: frame)
    div(:content_box, class: "ve-ce-documentNode ve-ce-branchNode", frame: frame)
    text_area(:describe_change, index: 0, frame: frame)
    div(:diff_view, class: "ve-ui-mwSaveDialog-viewer", frame: frame)
    a(:ex, title: "Close", frame: frame)
    span(:insert_reference, text: "Insert reference", frame: frame)
    text_field(:media_search, placeholder: "Search for media", frame: frame)
    div(:media_select, class: "ve-ui-mwMediaResultWidget-overlay", frame: frame)
    checkbox(:minor_edit, id: "wpMinoredit", frame: frame)
    text_field(:parameter_box, index: 0, frame: frame)
    div(:parameter_icon, text: "q", frame: frame)
    a(:remove_parameter, title: "Remove parameter", frame: frame)
    a(:remove_template, title: "Remove template", frame: frame)
    span(:return_to_save, class: "oo-ui-labeledElement-label", text: "Return to save form", frame: frame)
    span(:review_changes, class: "oo-ui-labeledElement-label", text: "Review your changes", frame: frame)
    span(:second_save_page, class: "oo-ui-labeledElement-label", text: "Save page", frame: frame)
    unordered_list(:suggestion_list, class: "ve-ui-mwTitleInputWidget-menu", frame: frame)
    div(:template_header, class: "ve-ui-mwTransclusionDialog-single", frame: frame)
    li(:template_list_item, text: "S", frame: frame)
    div(:title, class: "oo-ui-window-title", frame: frame)
    text_area(:transclusion_textarea, index: 0, frame: frame)
    text_field(:transclusion_textfield, index: 0, frame: frame)
  end

  # not having beta warning makes iframes off by one
  in_iframe(index: 1) do |frame|
    div(:links_diff_view, class: "ve-ui-mwSaveDialog-viewer", frame: frame)
    span(:links_review_changes, class: "oo-ui-labeledElement-label", text: "Review your changes", frame: frame)
    div(:media_diff_view, class: "ve-ui-mwSaveDialog-viewer", frame: frame)
    a(:media_exit, title: "Close", frame: frame)
  end
end

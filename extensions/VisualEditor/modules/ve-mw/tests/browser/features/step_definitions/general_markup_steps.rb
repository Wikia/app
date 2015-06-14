When(/^I click the Bold menu option$/) do
  on(VisualEditorPage).ve_bold_text_element.when_present(15).click
end

When(/^I click the Computer Code menu option$/) do
  on(VisualEditorPage).ve_computer_code_element.when_present(15).click
end

When(/^I click the Italics menu option$/) do
  on(VisualEditorPage).ve_italics_element.when_present(15).click
end

When(/^I click the More option$/) do
  on(VisualEditorPage).ve_more_markup_options_element.when_present(15).click
end

When(/^I click the Strikethrough menu option$/) do
  on(VisualEditorPage).ve_strikethrough_element.when_present(15).click
end

When(/^I click the Subscript menu option$/) do
  on(VisualEditorPage).ve_subscript_element.when_present(15).click
end

When(/^I click the Superscript menu option$/) do
  on(VisualEditorPage).ve_superscript_element.when_present(15).click
end

When(/^I click the text style menu$/) do
  on(VisualEditorPage).ve_text_style_element.when_present(15).click
end

When(/^I click the Underline menu option$/) do
  on(VisualEditorPage).ve_underline_element.when_present(15).click
end

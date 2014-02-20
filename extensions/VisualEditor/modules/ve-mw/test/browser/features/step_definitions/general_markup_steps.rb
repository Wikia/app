And(/^I click the Computer Code menu option$/) do
  on(VisualEditorPage) do |page|
    page.more_menu_element.when_present.click
    page.ve_computer_code_element.when_present.click
  end
end

And(/^I click the Strikethrough menu option$/) do
  on(VisualEditorPage) do |page|
    page.more_menu_element.when_present.click
    page.ve_strikethrough_element.when_present.click
  end
end

And(/^I click the Subscript menu option$/) do
  on(VisualEditorPage) do |page|
    page.more_menu_element.when_present.click
    page.ve_subscript_element.when_present.click
  end
end

And(/^I click the Superscript menu option$/) do
  on(VisualEditorPage) do |page|
    page.more_menu_element.when_present.click
    page.ve_superscript_element.when_present.click
  end
end

And(/^I click the Underline menu option$/) do
  on(VisualEditorPage) do |page|
    page.more_menu_element.when_present.click
    page.ve_underline_element.when_present.click
  end
end

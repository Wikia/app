
When(/^I click the hamburger menu$/) do
  on(VisualEditorPage).hamburger_menu_element.when_present.click
end

When(/^I click Options$/) do
  on(VisualEditorPage).options_in_hamburger_element.when_present.click
end

Then(/^I should see the options overlay$/) do
  on(VisualEditorPage).options_page_title_element.when_present.should be_visible
end

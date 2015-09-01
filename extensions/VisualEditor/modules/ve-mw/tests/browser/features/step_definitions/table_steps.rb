Given(/^I am editing an empty page$/) do
  visit(VisualEditorPage)
end

When(/^I click the insert table toolbar element$/) do
  on(VisualEditorPage) do |page|
    page.insert_menu_element.when_present.click
    page.insert_table_element.click
  end
end

Then(/^the table should appear$/) do
  expect(on(VisualEditorPage).table_element).to be_visible
end

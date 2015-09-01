Given(/^I go to a page that has references$/) do
  wikitext = "VisualEditor is a MediaWiki extension.<ref>[http://www.mediawiki.org/wiki/Extension:VisualEditor Extension:VisualEditor]</ref>

==References==
<references />"

  api.create_page 'Reference VisualEditor Test', wikitext
  step 'I am on the Reference VisualEditor Test page'
end

Given(/^I can see the References User Interface$/) do
  on(VisualEditorPage).references_title_element.when_present
end

When(/^I click Insert references list$/) do
  on(VisualEditorPage).insert_element.when_present.click
end

When(/^I click Reference$/) do
  on(VisualEditorPage) do |page|
    page.insert_indicator_down_element.when_present.click
    page.ve_more_references_options_element.when_present.click
    page.ve_references_element.when_present.click
  end
end

When(/^I click use an existing reference button in References User Interface$/) do
  on(VisualEditorPage).cite_reuse_existing_reference_element.when_present.click
end

When(/^I click on Extension:VisualEditor reference$/) do
  on(VisualEditorPage).extension_reference_element.when_present.click
end

When(/^I create a reference using existing reference$/) do
  step('I open the Cite menu')
  step('I click use an existing reference button in References User Interface')
  step('I click on Extension:VisualEditor reference')
end

Then(/^first link to reference should be visible$/) do
  expect(on(VisualEditorPage).first_reference_element.when_present).to be_visible
end

Then(/^second link to reference should be visible$/) do
  expect(on(VisualEditorPage).second_reference_element.when_present).to be_visible
end

Then(/^I should see Insert reference button enabled$/) do
  expect(on(VisualEditorPage).insert_reference_element).to be_visible
end

Then(/^link to Insert menu should be visible$/) do
  expect(on(VisualEditorPage).insert_indicator_element).to be_visible
end

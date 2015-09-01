Given(/^I can see the Transclusion User Interface$/) do
  on(VisualEditorPage).add_a_template_title_element.when_present
end

Given(/^I click the Add template button$/) do
  on(VisualEditorPage).add_template_element.when_present.click
end

Given(/^I click the parameter representation containing q$/) do
  on(VisualEditorPage).parameter_icon_element.when_present.click
end

Given(/^I click Transclusion$/) do
  on(VisualEditorPage) do |page|
    page.insert_indicator_down_element.when_present.click
    page.transclusion_element.when_present.click
  end
end

Given(/^I see a list of template suggestions$/) do
  on(VisualEditorPage).suggestion_list_element.when_present
end

Given(/^I see an input text area$/) do
  on(VisualEditorPage).transclusion_description_element.when_present
end

When(/^I click Remove parameter$/) do
  on(VisualEditorPage).remove_parameter_element.when_present.click
end

When(/^I enter (.+) in the parameter box$/) do |param_value|
  on(VisualEditorPage) do |page|
    page.no_unused_fields_element.when_present
    page.transclusion_description_element.when_present.send_keys(param_value)
  end
end

When(/^I enter (.+) into transclusion Content box$/) do |content|
  on(VisualEditorPage).transclusion_description_element.when_present.send_keys(content)
end

Then(/^I should see a list of template suggestions$/) do
  expect(on(VisualEditorPage).suggestion_list_element.when_present).to be_visible
end

Then(/^I should see the Insert template button$/) do
  expect(on(VisualEditorPage).insert_element.when_present).to be_visible
end

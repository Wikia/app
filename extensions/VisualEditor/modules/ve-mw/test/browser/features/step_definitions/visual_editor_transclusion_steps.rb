Given(/^I can see the Transclusion User Interface$/) do
  on(VisualEditorPage).title.should match 'Transclusion'
end

When(/^I add the parameter$/) do
  on(VisualEditorPage).add_parameter_element.when_present.click
end

When(/^I click Remove parameter$/) do
  on(VisualEditorPage).remove_parameter_element.when_present.click
end

When(/^I click Remove template$/) do
  on(VisualEditorPage).remove_template_element.when_present.click
end

When(/^I click Transclusion$/) do
  on(VisualEditorPage).transclusion_element.when_present.click
end

When(/^I enter (.+) in the parameter box$/) do |param_value|
  on(VisualEditorPage) do |page|
      page.parameter_box_element.when_present
      page.parameter_box=param_value
  end
end

Then(/^I should see a list of template suggestions$/) do
  on(VisualEditorPage).suggestion_list_element.when_present.should be_visible
end

Then(/^I should be able to click the Add template button$/) do
  on(VisualEditorPage).add_template_element.click
end
Then(/^I should not be able to see parameter named (.+)$/) do |param_name|
  on(VisualEditorPage).template_list_item_element.should_not be_visible
end

Then(/^I should see an input text area$/) do
  on(VisualEditorPage).transclusion_textarea_element.when_present.should be_visible
end

Then(/^I should see the Apply changes button$/) do
  on(VisualEditorPage).apply_changes_element.when_present.should be_visible
end

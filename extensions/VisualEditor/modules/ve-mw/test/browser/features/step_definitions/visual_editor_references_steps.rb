Given(/^I can see the References User Interface$/) do
  on(VisualEditorPage).ref_body.should match Regexp.escape('Reference')
end

When(/^I click Insert reference$/) do
	sleep 2 #fix for Chrome see https://code.google.com/p/selenium/issues/detail?id=2766
  on(VisualEditorPage).create_new_element.when_present.click
end

When(/^I click Edit for VisualEditor$/) do
  on(VisualEditorPage).edit_ve
end

When(/^I click Reference$/) do
  on(VisualEditorPage).ve_references_element.when_present.click
end

When(/^I enter (.+) into Content box$/) do |content|
  on(VisualEditorPage).content_box_element.when_present
  on(VisualEditorPage).content_box=content
end

Then(/^I should see Insert reference button enabled$/) do
  on(VisualEditorPage).insert_reference_element.should be_visible
end

Then(/^link to references dialog should be visible$/) do
  on(VisualEditorPage).refs_link_element.should be_visible
end

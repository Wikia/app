Given(/^I can see the References User Interface$/) do
  on(VisualEditorPage).title.should match "Reference"
end

When(/^I click Insert reference$/) do
  on(VisualEditorPage).insert_reference_element.when_present.click
end

When(/^I click Edit for VisualEditor$/) do
  on(VisualEditorPage) do |page|
    page.edit_ve_element.when_present.click
    # no longer need to dismiss beta warning here https://gerrit.wikimedia.org/r/#/c/119217/
    page.content_element.when_present(10).fire_event("onfocus")
  end
end

When(/^I click Reference$/) do
  on(VisualEditorPage) do |page|
    page.insert_menu_element.when_present.click
    page.ve_references_element.when_present.click
  end
end

When(/^I enter (.+) into Content box$/) do |content|
  on(VisualEditorPage) do |page|
    page.content_box_element.when_present
    page.content_box_element.send_keys(content)
  end
end

Then(/^I should see Insert reference button enabled$/) do
  on(VisualEditorPage).insert_reference_element.should be_visible
end

Then(/^link to Insert menu should be visible$/) do
  on(VisualEditorPage).insert_menu_element.should be_visible
end
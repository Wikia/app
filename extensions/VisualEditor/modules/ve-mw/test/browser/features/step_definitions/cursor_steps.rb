Given(/^I am at the cursor test page$/) do
  visit(CursorTestPage)
end

When(/^I send right arrow times (\d+)$/) do |number|
  on(VisualEditorPage) do |page|
    page.content_element.when_present(10).fire_event("onfocus")
    number.to_i.times do
      page.content_element.send_keys :arrow_right
      page.content_element.fire_event("onblur") #gerrit 86800/86801
    end
  end
end

When(/^I do not see the References hover icon$/) do
  on(CursorTestPage).references_hover_element.should_not be_visible
end

Then(/^I should see the References hover icon$/) do
  on(CursorTestPage).references_hover_element.when_present.should be_visible
end

Then(/^I should see the Transclusion hover icon$/) do
  on(CursorTestPage).transclusion_hover_element.when_present.should be_visible
end

Then(/^I do not see the Transclusion hover icon$/) do
  on(CursorTestPage).transclusion_hover_element.should_not be_visible
end

Then(/^I do not see the Link hover icon$/) do
  on(CursorTestPage).link_hover_element.should_not be_visible
end

Then(/^I should see the Link hover icon$/) do
  on(CursorTestPage).link_hover_element.should be_visible
end


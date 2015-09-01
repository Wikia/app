When(/^I click Bullets$/) do
  on(VisualEditorPage) do |page|
    page.bullet_number_selector_element.when_present.click
    page.ve_bullets_element.when_present.click
  end
end

When(/^I click Decrease indentation$/) do
  on(VisualEditorPage) do |page|
    step 'I click in the editable part'
    page.bullet_number_selector_element.when_present.click
    page.decrease_indentation_element.when_present.click
  end
end

When(/^I click Increase indentation$/) do
  on(VisualEditorPage) do |page|
    page.bullet_number_selector_element.when_present.click
    page.increase_indentation_element.when_present.click
  end
end

When(/^I click Numbering$/) do
  on(VisualEditorPage) do |page|
    page.bullet_number_selector_element.when_present.click
    page.ve_numbering_element.when_present.click
  end
end

When(/^I undo Bullets$/) do
  on(VisualEditorPage) do |page|
    page.bullet_number_selector_element.when_present.click
    page.ve_bullets_element.when_present.click
  end
end

When(/^I undo Numbering$/) do
  on(VisualEditorPage) do |page|
    page.bullet_number_selector_element.when_present.click
    page.ve_numbering_element.when_present.click
  end
end

Then(/^a \# is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "# #{@wikitext}"
    end
    expect(page.diff_view).to match(/^\# #{@wikitext}/)
  end
end

Then(/^a \* is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "* #{@wikitext}"
    end
    expect(page.diff_view).to match(/^\* #{@wikitext}/)
  end
end

Then(/^a \#\# is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "## #{@wikitext}"
    end
    expect(page.diff_view).to match(/^\#\# #{@wikitext}/)
  end
end

Then(/^a \*\* is added in front of input string in the diff view$/) do
  on(VisualEditorPage) do |page|
    page.wait_until(10) do
      page.diff_view.include? "** #{@wikitext}"
    end
    expect(page.diff_view).to match(/^\*\* #{@wikitext}/)
  end
end

Then(/^Decrease indentation should be enabled$/) do
  expect(on(VisualEditorPage).decrease_indentation_element.class_name).not_to match(/disabled/)
end

Then(/^Decrease indentation should be disabled$/) do
  expect(on(VisualEditorPage).decrease_indentation_element).not_to be_visible
end

Then(/^Increase indentation should be enabled$/) do
  expect(on(VisualEditorPage).increase_indentation_element.class_name).not_to match(/disabled/)
end

Then(/^Increase indentation should be disabled$/) do
  expect(on(VisualEditorPage).increase_indentation_element).to_not be_visible
end

Then(/^nothing is added in front of input string in the diff view$/) do
  expect(on(VisualEditorPage).review_failed_element.when_present).to be_visible
end

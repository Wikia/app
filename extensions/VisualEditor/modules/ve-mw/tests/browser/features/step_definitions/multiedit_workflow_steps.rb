When(/^I enter and save the first edit$/) do
  @first_edit_text = 'Editing with ' + Random.rand.to_s
  step "I insert the text #{@first_edit_text}"
  step 'I click Save page'
  step 'I click This is a minor edit'
  step 'I click Review your changes'
  step 'I click Return to save form'
  step 'I click Save page the second time'
end

When(/^I enter and save a (.+) edit$/) do |count|
  on(VisualEditorPage).medium_dialog_element.when_not_visible(10)
  edit_text = 'Editing with ' + Random.rand.to_s
  instance_variable_set("@#{count}_edit_text", edit_text)
  step 'I click Edit for VisualEditor'
  step "I insert the text #{edit_text}"
  step 'I click Save page'
  step 'I click Save page the second time'
end

When(/^I insert the text (.*?)$/) do |input_string|
  on(VisualEditorPage).content_element.when_present(10).send_keys(input_string)
end

Then(/^the saved page should contain all three edits\.$/) do
  expect(on(VisualEditorPage).page_text_element.when_present(10).text).to match "#{@third_edit_text}#{@second_edit_text}Editing with #{@random_string} #{@first_edit_text}"
end

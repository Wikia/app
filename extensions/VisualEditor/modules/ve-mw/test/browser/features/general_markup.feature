@ie6-bug  @ie7-bug  @ie8-bug @ie9-bug @ie10-bug @en.wikipedia.beta.wmflabs.org @test2.wikipedia.org @login
Feature: VisualEditor general text markup features

  @make_selectable_line
  Scenario Outline: VisualEditor general markup
    And I click the <type_of_markup> menu option
    And I click Save page
    And I click Review your changes
    Then <expected_markup_text> should appear in the diff view
    And I can click the X on the save box
  Examples:
    | type_of_markup | expected_markup_text            |
    | Computer Code  | <code>This is a new line</code> |
    | Strikethrough  | <s>This is a new line</s>       |
    | Subscript      | <sub>This is a new line</sub>   |
    | Superscript    | <sup>This is a new line</sup>   |
    | Underline      | <u>This is a new line</u>       |

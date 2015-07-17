@chrome @en.wikipedia.beta.wmflabs.org @firefox @internet_explorer_10 @login @safari @test2.wikipedia.org
Feature: VisualEditor general text markup features

  Background:
    Given I go to the "General Markup VisualEditor Test" page with content "General Markup VisualEditor Test"
      And I make the text "General Markup VisualEditor Test" be selected

  Scenario Outline: VisualEditor general markup
    When I click the text style menu
    And I click the <type_of_markup> menu option
    And I click Save page
    And I click Review your changes
    Then <expected_markup_text> should appear in the diff view
    And I can click the X on the save box
  Examples:
    | type_of_markup | expected_markup_text                          |
    | Bold           | '''General Markup VisualEditor Test'''        |
    | Italics        | ''General Markup VisualEditor Test''          |


  Scenario Outline: VisualEditor more general markup
    When I click the text style menu
      And I click the More option
    And I click the <type_of_markup> menu option
    And I click Save page
    And I click Review your changes
    Then <expected_markup_text> should appear in the diff view
    And I can click the X on the save box
  Examples:
    | type_of_markup | expected_markup_text                          |
    | Computer Code  | <code>General Markup VisualEditor Test</code> |
    | Strikethrough  | <s>General Markup VisualEditor Test</s>       |
    | Subscript      | <sub>General Markup VisualEditor Test</sub>   |
    | Superscript    | <sup>General Markup VisualEditor Test</sup>   |
    | Underline      | <u>General Markup VisualEditor Test</u>       |
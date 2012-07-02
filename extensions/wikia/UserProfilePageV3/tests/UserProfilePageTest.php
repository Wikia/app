<?php
require_once dirname(__FILE__) . '/../UserProfilePage.setup.php';
require_once dirname(__FILE__) . '/../InterviewQuestion.class.php';

class UserProfilePageTest extends WikiaBaseTest {
	const TEST_WIKI_ID = 111;
	const TEST_CAPTION = 'Test caption';


	/**
	 * @param User $user
	 * @return UserProfilePage
	 */
	protected function getObjectMock( User $user ) {
		$object = $this->getMock( 'UserProfilePage', array( 'parseInterviewAnswers', 'getInterviewArticle', 'invalidateCache' ), array( F::app(), $user ) );
		return $object;
	}

	public function gettingInterviewQuestionsDataProvider() {
		return array(
			array( true, false ),
			array( true, true ),
			array( false, false ),
			array( false, true )
		);
	}

	/**
	 * @dataProvider gettingInterviewQuestionsDataProvider
	 */
	public function testGettingInterviewQuestions( $answeredOnly, $asArray ) {
		$answers = array(
			10 => 'Test Answer 10',
			20 => 'Test Answer 20',
			30 => null
		);

		$question10Mock = $this->getMock( 'InterviewQuestion', array( 'getId' ), array(), '', false );
		$question10Mock->expects( $this->any() )
		  ->method( 'getId' )
		  ->will( $this->returnValue( 10 ));
		  
		$question20Mock = $this->getMock( 'InterviewQuestion', array( 'getId' ), array(), '', false );
		$question20Mock->expects( $this->any() )
		  ->method( 'getId' )
		  ->will( $this->returnValue( 20 ));

		$question30Mock = $this->getMock( 'InterviewQuestion', array( 'getId' ), array(), '', false );
		$question30Mock->expects( $this->any() )
		  ->method( 'getId' )
		  ->will( $this->returnValue( 30 ));

		$questions = array(
			$question10Mock,
			$question20Mock,
			$question30Mock
		);

		$this->mockGlobalFunction( 'msg', self::TEST_CAPTION, count( $questions ) );
		$this->mockApp();

		$object = $this->getObjectMock( $this->getMock( 'User' ) );
		$object->expects( $this->once() )
		  ->method( 'parseInterviewAnswers' )
		  ->will( $this->returnValue( $answers ) );

		$interviewMock = $this->getMock( 'Interview', array( 'getQuestions' ), array(), '', false );
		$interviewMock->expects( $this->once() )
		  ->method( 'getQuestions' )
		  ->will( $this->returnValue( $questions ) );

		$this->mockClass( 'Interview', $interviewMock );

		$result = $object->getInterviewQuestions( self::TEST_WIKI_ID, $answeredOnly, $asArray );

		$this->assertEquals( ( $answeredOnly ? 2 : 3 ), count( $result ) );
		foreach( $result as $question ) {
			if( $asArray ) {
				$this->assertEquals( self::TEST_CAPTION, $question['caption'] );
				$this->assertEquals( $answers[$question['id']], $question['answerBody'] );
			}
			else {
				$this->assertEquals( self::TEST_CAPTION, $question->getCaption() );
				$this->assertEquals( $answers[$question->getId()], $question->getAnswerBody() );
			}
		}
	}
}
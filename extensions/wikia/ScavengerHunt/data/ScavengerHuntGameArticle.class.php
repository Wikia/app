<?php

	class ScavengerHuntGameArticle {

		protected $title = '';
		protected $articleId = 0;
		protected $hiddenImage = '';
		protected $successImage = '';
		protected $clueText = '';

		public function setTitle( $title ) {
			$this->title = $title;
			$titleObj = WF::build('Title',array($this->title),'newFromText');
			$this->articleId = $titleObj ? $titleObj->getArticleId() : 0;
		}

		public function getTitle() {
			return $this->title;
		}

		public function getArticleId() {
			return $this->articleId;
		}

		public function setHiddenImage( $hiddenImage ) {
			$this->hiddenImage = $hiddenImage;
		}

		public function getHiddenImage() {
			return $this->hiddenImage;
		}

		public function setSuccessImage( $successImage ) {
			$this->successImage = $successImage;
		}

		public function getSuccessImage() {
			return $this->successImage;
		}

		public function setClueText( $clueText ) {
			$this->clueText = $clueText;
		}

		public function getClueText() {
			return $this->clueText;
		}

	}

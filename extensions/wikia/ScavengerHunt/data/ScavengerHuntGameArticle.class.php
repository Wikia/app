<?php

	class ScavengerHuntGameArticle {

		protected $title = '';
		protected $articleId = 0;
		protected $hiddenImage = '';
		protected $clueImage = '';
		protected $clueText = '';
		protected $link = '';

		public function setTitle( $title ) {
			$this->title = $title;
			$titleObj = WF::build('Title',array($this->title),'newFromText');
			$this->articleId = $titleObj ? $titleObj->getArticleId() : 0;
		}

		public function getTitle() {
			return $this->title;
		}

		public function setTitleAndId( $title, $articleId ) {
			$this->title = $title;
			$this->aritcleId = $articleId;
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

		public function setClueImage( $clueImage ) {
			$this->clueImage = $clueImage;
		}

		public function getClueImage() {
			return $this->clueImage;
		}

		public function setClueText( $clueText ) {
			$this->clueText = $clueText;
		}

		public function getClueText() {
			return $this->clueText;
		}

		public function setLink( $link ) {
			$this->link = $link;
		}

		public function getLink() {
			return $this->link;
		}

	}

<?php
class UserWikisFilterRestrictedDecorator extends UserWikisFilterDecorator {
	public function getFiltered() {
		return $this->filter->getFiltered();
	}

}

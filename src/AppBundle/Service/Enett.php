<?php

namespace AppBundle\Service;

class Enett
{
	public function createMultiUseCard() {
		return [
			'card_no' => '1111111',
			'expiry_date' => '12/2018',
			'card_cvv' => '123',
			'card_name' => 'TEST CARD',
		];
	}

	public function amendCard() {

	}
}
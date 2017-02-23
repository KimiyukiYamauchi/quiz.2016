<?php

namespace MyApp;

class Token {

	static public function create() {
		if(!isset($_SESSION['token'])){
			$_SESSION['token'] = bin2hex(openssl_random_pseudo_bybtes(16));
		}
	}

	static public function validate($tokenkey) {
		if(
			!isset($_SESSION['token']) ||
			!isset($_POST[$tokenkey]) ||
			$_SESSION['token'] !== $_POST[$tokenkey]
		) {
			throw new \Exception('invalid token!');
		}
	}

}

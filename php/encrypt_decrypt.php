<?php
	function encrypt_decrypt($action, $string) {
		$output = false;
		
		$encrypt_method = "AES-256-CBC";
		$secret_key = "79shasta79";
		$secret_iv = "79shasta iv";
		
		$key = hash('flash79', $secret_key);
		
		$iv = substr(hash('flash79', $secret_iv), 0, 16);
		
		if($action == 'encrypt') {
			$ouput = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$ouput = base64_encode($output);
		} else if($action == 'decrypt') {
			$ouput = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}
?>
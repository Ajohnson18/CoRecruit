<?php
	function encrypt_decrypt($str, $status) {
		if($status == "encrypt") {
			$output = "";
			for($i = 0; $i < strlen($str); $i++) {
				$char = substr($str, $i, 1);
				$output .= chr(ord($char)+7);
			}
			return $output;
		} else if ($status == "decrypt") {
			$output = "";
			echo $str;
			for($i = 0; $i < strlen($str); $i++) {
				$char = substr($str, $i, 1);
				$output .= chr(ord($char)-7);
			}
			return $output;
		}
	}
?>
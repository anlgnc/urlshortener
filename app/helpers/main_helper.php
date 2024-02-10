<?php

function printr($code)
{
	echo '<pre>';
	print_r($code);
	echo '<pre>';
}

function rndAl($charLimit = 5)
{
	$char = "abcdefghjklmnoprstuwvyzqxABCDEFGHJKLMNOPRSTUWVYZQX";

	$s = '';

	for ($k = 1; $k <= $charLimit; $k++) {
		$h = substr($char, mt_rand(0, strlen($char) - 1), 1);
		$s .= $h;
	}

	return $s;
}

function isAdmin()
{
	$ci =& get_instance();

	if ($ci->session->userdata('profile_user')["user_group"] == 1) {
		return true;
	} else {
		return false;
	}
}

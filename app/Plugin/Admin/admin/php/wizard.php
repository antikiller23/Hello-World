<?php

/*
 * MoonCake v1.3.1 - Form Wizard Demo JS
 *
 * This file is part of MoonCake, an Admin template build for sale at ThemeForest.
 * For questions, suggestions or support request, please mail me at maimairel@yahoo.com
 *
 * Development Started:
 * July 28, 2012
 * Last Update:
 * December 07, 2012
 *
 * DO NOT USE THIS FILE, THIS IS JUST AN UNUSABLE DEMO TO GENERATE SERVER RESPONSE
 *
 */

function getUserAgent() {
	return isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:null;
}

function getUserHostAddress() {
	return isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'127.0.0.1';
}

 $data = $_POST['wizard'];

 echo print_r( $data, true ) . "\nIP Address:\n\t" . getUserHostAddress() . "\n\nBrowser:\n\t" . getUserAgent();

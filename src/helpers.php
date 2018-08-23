<?php


if (! function_exists("fe")) {
	function fe(string $string)
	{
		return html_entity_decode($string, ENT_QUOTES, "UTF-8");
	}	
}

<?php
function array_multi_filter_download_empty($var) {
	if( is_array($var) ) {
		$var = @array_filter($var);
		return ($var && !empty($var));
	} else {
		return $var;
	}
}
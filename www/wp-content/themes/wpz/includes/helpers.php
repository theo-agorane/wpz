<?php

/**
 * @function pre
 */
function pre($str, $exit = false) {
	echo '<pre>';
	var_dump($str);
	echo '</pre>';

	if ($exit) {
		exit;
	}
}

/**
 * @function hoscar_format_price
 */
function hoscar_format_price($price, $after = '') {
	return '<span class="price">' . 
		number_format(floatval($price), 2, ",", " ")
		//. '&nbsp;'
		. '€'//. get_woocommerce_currency_symbol()
		. ($after ? ' <span class="price-after">'.$after.'</span>' : '')
		. '</span>';
}

/**
 * @function simplify_string
 */
function simplify_string($str, $lower = true) {
	$search  = ['À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ'];
	$replace = ['A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y'];

	return $lower
		? strtolower(str_replace($search, $replace, $str))
		: str_replace($search, $replace, $str);
}

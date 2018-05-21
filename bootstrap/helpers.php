<?php

function current_route($request = null )
{
	$request = $request ?? \request() ;
	
	
	return $request->input('lang');
}

function make_excerpt($value,$length = 200)
{
	$excerpt = trim(preg_replace('/\r\n|\r|rn/',' ',strip_tags($value)));
	return str_limit($excerpt, $length);
}

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function arrayToString( $array, $string )
{
	$str = '';
	foreach ( $array as $item ) {
		if ( is_array($item) ) {
			$str .= arrayToString($item, $string);
		}else{
			if ( ! empty($item) && ! is_numeric($item)  ) {
				$str .= $item.$string;
			}
		}
	}
	return $str;
}

function str_split_utf8($str,$delimiter = '。') {
	// place each character of the string into and array
	$split = 1;
	$array = array(); $len = strlen($str);
	for ( $i = 0; $i < $len; ){
		$value = ord($str[$i]);
		if($value > 0x7F){
			if($value >= 0xC0 && $value <= 0xDF)
				$split = 2;
			elseif($value >= 0xE0 && $value <= 0xEF)
				$split = 3;
			elseif($value >= 0xF0 && $value <= 0xF7)
				$split = 4;
			elseif($value >= 0xF8 && $value <= 0xFB)
				$split = 5;
			elseif($value >= 0xFC)
				$split = 6;
			
		} else {
			$split = 1;
		}
		$key = '';
		for ( $j = 0; $j < $split; ++$j, ++$i ) {
			$key .= $str[$i];
		}
		$array[] = $key;
	}
	$arr = [];
	$tmp = '';
	foreach ( $array as $item ) {
		if ( $item === $delimiter ) {
			$arr[] = $tmp;
			$tmp = '';
		}else{
			$tmp .= $item;
		}
	}
	if ( ! empty($tmp) ) {
		$arr[] = $tmp;
	}
	$array = $arr;
	
	return $array;
}


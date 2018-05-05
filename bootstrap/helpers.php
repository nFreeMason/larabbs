<?php

function make_excerpt($value,$length = 200)
{
	$excerpt = trim(preg_replace('/\r\n|\r|rn/',' ',strip_tags($value)));
	return str_limit($excerpt, $length);
}

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

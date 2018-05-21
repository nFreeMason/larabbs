<?php

namespace App\MyProvidersClass;

use App\MyProvidersClass\LangConfigInterface;

class LangConfig
{
	protected $items = [];
	
	private $path = '';
	
	private $lang = '';
	
	public function __construct($lang)
	{
		$this->lang = $lang;
		$this->setLangPath();
		if ( !$this->isPath() ) {
			return null;
		}
		$this->set();
	}
	
	public function isPath()
	{
		return file_exists($this->path);
	}
	
	public function setLangPath()
	{
		$this->path = resource_path()."/lang/{$this->lang}/test.php";
	}
	
	public function set()
	{
		$this->items = include $this->path;
	}
	
	public function get($key,$default = null)
	{
		return $this->items [$key] ?? $default ?? null;
	}
}
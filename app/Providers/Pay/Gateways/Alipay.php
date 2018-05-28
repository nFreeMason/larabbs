<?php

namespace App\Providers\Pay\Gateways;

class Alipay
{
	public static $config;
	
	public static $gatewayUrl = 'https://openapi.alipaydev.com/gateway.do';
	
	public static function alipay( $config )
	{
		$config['gatewayUrl'] = self::$gatewayUrl;
		self::$config = $config;
		return new self;
	}
	
	protected function pay( $payStyle, $params = [] )
	{
		$payStyle = studly_case(camel_case($payStyle));
		$class = get_class($this).$payStyle.'Pay\\'.$payStyle.'PayGateways';
		
		return app($class)->pay(self::$config, $params);
	}
	
	public function __call( $method, $arguments )
	{
		// TODO: Implement __call() method.
		
		$this->pay($method, ...$arguments);
	}
	
}
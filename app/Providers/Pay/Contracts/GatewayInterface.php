<?php

namespace App\Providers\Pay\Contracts;

interface GatewayInterface
{
	public function pay(array $config, array $params);
}
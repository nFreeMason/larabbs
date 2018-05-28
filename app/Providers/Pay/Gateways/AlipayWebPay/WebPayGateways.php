<?php

namespace App\Providers\Pay\Gateways\AlipayWebPay;

use App\Providers\Pay\Contracts\GatewayInterface;

class WebPayGateways implements GatewayInterface
{
	public function pay(array $config, array $params)
	{
		header( "Content-type: text/html; charset=utf-8" );

		require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'pagepay/service/AlipayTradeService.php';
		require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';
		
		if ( empty( $params['WIDout_trade_no'] ) || trim( $params['WIDout_trade_no'] ) == ""  ) {
			$errors[] = '';
		}
		
		if ( empty( $params['WIDsubject' ]) || trim( $params['WIDsubject' ] ) == ""  ) {
			$errors[] = '';
		}
		
		if  ( empty( $params['WIDtotal_amount' ] ) || trim( $params['WIDtotal_amount' ] ) == ""   ) {
			$errors[] = '';
		}
		
		if  ( empty( $params['WIDbody'] ) || trim( $params['WIDbody' ] ) == ""   ) {
			$errors[] = '';
		}
		
		if ( empty($errors) ) {
			//商户订单号，商户网站订单系统中唯一订单号，必填
			$out_trade_no = $params['WIDout_trade_no'];
			
			//订单名称，必填
			$subject = $params['WIDsubject'];
			
			//付款金额，必填
			$total_amount = $params['WIDtotal_amount'];
			
			//商品描述，可空
			$body = $params['WIDbody' ];
			
			//超时时间
			$timeout_express = "1m";
			
			$payRequestBuilder = new \AlipayTradePagePayContentBuilder();
			$payRequestBuilder->setBody( $body );
			$payRequestBuilder->setSubject( $subject );
			$payRequestBuilder->setOutTradeNo( $out_trade_no );
			$payRequestBuilder->setTotalAmount( $total_amount );
			$payRequestBuilder->setTimeExpress( $timeout_express );
			
			$payResponse = new \AlipayTradeService( $config );
			return $payResponse->pagePay( $payRequestBuilder, $config[ 'return_url' ], $config[ 'notify_url' ] );
		}else{
			return $errors;
		}
	}
}
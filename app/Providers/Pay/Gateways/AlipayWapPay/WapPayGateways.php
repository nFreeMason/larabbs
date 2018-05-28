<?php

namespace App\Providers\Pay\Gateways\AlipayWapPay;

class WapPayGateways
{
	public function pay()
	{
		header( "Content-type: text/html; charset=utf-8" );

		require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'wappay/service/AlipayTradeService.php';
		require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
		require dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'config.php';
		if ( !empty( request()->input( 'WIDout_trade_no' ) ) && trim( request()->input( 'WIDout_trade_no' ) ) != "" ) {
			//商户订单号，商户网站订单系统中唯一订单号，必填
			$out_trade_no = request()->input( 'WIDout_trade_no' )??123131;
			
			//订单名称，必填
			$subject = request()->input( 'WIDsubject' )??'test';
			
			//付款金额，必填
			$total_amount = request()->input( 'WIDtotal_amount' )??0.01;
			
			//商品描述，可空
			$body = request()->input( 'WIDbody' );
			
			//超时时间
			$timeout_express = "1m";
			
			$payRequestBuilder = new \AlipayTradePagePayContentBuilder();
			$payRequestBuilder->setBody( $body );
			$payRequestBuilder->setSubject( $subject );
			$payRequestBuilder->setOutTradeNo( $out_trade_no );
			$payRequestBuilder->setTotalAmount( $total_amount );
			$payRequestBuilder->setTimeExpress( $timeout_express );
			$config = self::$config;
			
			$payResponse = new \AlipayTradeService( $config );
			return $payResponse->pagePay( $payRequestBuilder, $config[ 'return_url' ], $config[ 'notify_url' ] );
		}
	}
}
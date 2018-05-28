<?php

namespace App\Providers\Pay;

use App\Providers\Pay\Gateways\Alipay;
use Illuminate\Support\ServiceProvider;

class PayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
	    $this->mergeConfigFrom(config_path('payment.php'),'payment');
	    $this->app->singleton('pay.alipayment',function(){
	    	return Alipay::alipay(config('payment.alipay'));
	    });
	    $this->app->alias('pay.alipayment','alipay');
	    
	    $this->app->singleton('pay.wechatpay',function(){
	    	return Wechat::wechatpay(config('payment.wechatpay'));
	    });
	    $this->app->alias('pay.wechatpay','wechatpay');
	    $this->app->alias('pay.wechatpay','wechat');
	    
    }
}

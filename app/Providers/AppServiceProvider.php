<?php

namespace App\Providers;

use App\MyProvidersClass\LangConfig;
use App\Services\TestService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		\App\Models\User::observe(\App\Observers\UserObserver::class);
		\App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
		\App\Models\Topic::observe(\App\Observers\TopicObserver::class);

        //
        \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
//	    app()->singleton('langConfig',function (){
//	    	return new LangConfig('en');
//	    });
	   // app()->alias('langConfig','lanCon');
//	    $this->app->singleton('test',function (){
//		    return new TestService();
//	    });
//	    $this->app->alias('test','test');
    }
}

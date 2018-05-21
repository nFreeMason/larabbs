<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestCron extends Command
{
	protected $name = 'test:cron';
	
	public function handle()
	{
		User::all();
		//这里做任务的具体处理，可以用模型
		Log::info('任务调度'.time());
	}
}
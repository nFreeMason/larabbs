<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
	public function deleted(Topic $topic)
	{
		\DB::table('replies')->where('topic_id',$topic->id)->delete();
	}
	
	public function saving(Topic $topic)
	{
		// XSS 过滤
		$topic->body = clean($topic->body,'user_topic_body');
		
		// 生成话题摘录
		$topic->excerpt = make_excerpt($topic->body);
		
	}
	
	public function saved(Topic $topic)
	{
		// 如 slug 字段无内容，即使翻译器有对 title 进程翻译
		if ( ! $topic->slug ) {
			// 推送任务到队列
			dispatch(new TranslateSlug($topic));
//			$topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
		}
	}
	
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }
}
<?php

/*
 * This file is part of ibrand/laravel-sms.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'route' => [
        'prefix' => 'sms',
        'middleware' => ['web'],
    ],

    'easy_sms' => [
        'timeout' => 5.0,

        // 默认发送配置
        'default' => [
            // 网关调用策略，默认：顺序调用
            'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

            // 默认可用的发送网关
            'gateways' => [
                'aliyun'
            ],
        ],

        // 可用的网关配置
        'gateways' => [
            'errorlog' => [
                'file' => storage_path('logs/laravel-sms.log'),
            ],

            'yunpian' => [
                'api_key' => '824f0ff2f71cab52936axxxxxxxxxx',
            ],

            'aliyun' => [
                'access_key_id' => 'LTAIdnPnNVfO9ZDZ',
                'access_key_secret' => 'PuwaMbt1N1QprVe5D2gt9S2Zij4K5z',
                'sign_name' => '博腾技术有限公司',
                'code_template_id' => 'SMS_60710004',
            ],

            'alidayu' => [
	            'access_key_id' => 'LTAIdnPnNVfO9ZDZ',
	            'access_key_secret' => 'PuwaMbt1N1QprVe5D2gt9S2Zij4K5z',
	            'sign_name' => '博腾技术有限公司',
	            'code_template_id' => 'SMS_60710004',
            ],
        ],
    ],

    'code' => [
        'length' => 5,
        'validMinutes' => 5,
        'maxAttempts' => 0,
    ],

    'data' => [
        'product' => '',
    ],

    'dblog' => false,

    'content' => '【your app signature】亲爱的用户，您的验证码是%s。有效期为%s分钟，请尽快验证。',

    'storage' => \iBrand\Sms\Storage\CacheStorage::class,
];

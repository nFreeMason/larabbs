<?php

return [
    'alipay' => [
        // 支付宝分配的 APPID
        'app_id' => '2016091400509028',

        // 支付宝异步通知地址
        'notify_url' => 'http://local.saiyagroup.com/test/payment/notify_url',

        // 支付成功后同步通知地址
        'return_url' => 'http://local.saiyagroup.com/test/payment/return_url',

        // 阿里公共密钥，验证签名时使用
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4mM5+qnnOFyGKh03v0o6xknyviRP7pdljR4HVvSBvXbiGmX0eBuKxKcLTzjzJxu1kbkGX1XKsYY2TPqMzoNdkadluVBvwyEbct1lMuXE9oT8LnilhBi/Qw38jp+Kcg3kiGHWrwCDiwc3Dvyu0O71fRtYibpuyVSCE7thX8gIfIfGm91aub6vrSKmEEx3CAzV4Ag/axMTrjqA9rlBV+9YdnYH4ec9EQab3ivjoulXFOFsIgblZycYrjoO5qfgLxs+MmOGQXwHvy6fYcIdrAV2oNC2yShAKJYmCauXNngs1F8zIlpned5QqrbOMmpyQFAg03M7lCJZNPcIg++A+ws/8QIDAQAB',

        // 自己的私钥，签名时使用
        'private_key' => 'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDiYzn6qec4XIYqHTe/SjrGSfK+JE/ul2WNHgdW9IG9duIaZfR4G4rEpwtPOPMnG7WRuQZfVcqxhjZM+ozOg12Rp2W5UG/DIRty3WUy5cT2hPwueKWEGL9DDfyOn4pyDeSIYdavAIOLBzcO/K7Q7vV9G1iJum7JVIITu2FfyAh8h8ab3Vq5vq+tIqYQTHcIDNXgCD9rExOuOoD2uUFX71h2dgfh5z0RBpveK+Oi6VcU4WwiBuVnJxiuOg7mp+AvGz4yY4ZBfAe/Lp9hwh2sBXag0LbJKEAoliYJq5c2eCzUXzMiWmd53lCqts4yanJAUCDTczuUIlk09wiD74D7Cz/xAgMBAAECggEAb6M67i9mxFZsGsx5ty0luq6ws684c5HZFDPgrrK4X/QGH7pzSd9bGQq++vw8e+agLRIu4EhwQgbLND7BvPzu4WrJMQ9HbdQfsw8WXnkMHf0KVuhLxs5lUu3Mw5BNN10+ezq0IWyBccfHEO7uTj3odR9NE+4Jv+KampxmslL0TGPCdXLSlnQQ3Se8WtONLqj8tuXn9nbanG43QrvP9w8cFHNC/EuiOnLNZAISI0n+ICgnPLc1SMi0YTh7eoSMiCQPn646mBddy90RqIw6oW8Rq5wcJDCAnbup2mJ2pvdGLQHzof8OTdkJijTo2MlArS08/v6AU6ZiZwUS5/6GDGa0IQKBgQD+QvXmkMO4tnCRRXTzuSmOANrWxvbtoqy7LVYyDaHlHeiUwCo5UIjYGsKEbVCt+J7I9o5Nxpexrn+yNz2Cr4A34l62tEIRjVf+ncDzI7epg4YG9WvURiYuKE5aqPBgHqnaryIW7/H01P1XF4vQ29BldMOSzrd6ZFT/BmTT2nNkfQKBgQDj73pAK6cNUtzoVWrhYS9EQrYXceoLwIxtrbuxfs/nsnrrHG0Zwa/oXnufE2gz6/hPEhJoYn00swsK7f5PhRUX7novpm6nq0/0Qk1oNdBmCY28ChInri+20IVjpBdCyD5Aew585Ap/AudmfQ+iwGsOVeXEWhQVmnCPszyWgz0nhQKBgBpP156akIaG6rM92tJ18OTvFbZwNJF26iUclfTsEDrjk3QBRt1ThjXG3yZRIa4/Mj9dtHA8AuqyQiixKr5hZwVheaeyk7u5Qsfoj1UZ9yGlqLMDprr632ybYzBily17PtyQjxiMkB9kAyuGFkPw22oEYVDJ75bM1zbk9H4v9w0JAoGAaHCZdn/J+ovmVrqUz5JlQwTCRLnYgOwILFU3tFujzcl1EveicfPSs0lfoYMV8vyDeU+RiazfK9+CBs8IAM283YtTBzRebYtMhmI+76oAxFBKVkfTC8V/bWfcRsywL9Rq2cbI26btvEbLWqWhHXTHWPk436BapY9vVhjNgTW/NrUCgYBNKg/FhtAPal3L7sVCR592MR+xgj06E7annqEiQdO2Lz2dpaWTDbke/j//0H3Sy8UcI9PjGjaeKCGRTp1o17UKWnEA0ZTc/zRnjry7XQHhpTcSJldxm9p5sT8jPowRHiq/1MfDKuFwjBqvbBrgYgAhdzB/zG7qcxepUT9b22oMqg==',

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/alipay.log'),
        //     'level' => 'debug'
        ],

        // optional，设置此参数，将进入沙箱模式
//         'mode' => 'dev',
    ],

    'wechat' => [
	    // 公众号 APPID
	    'app_id' => 'wxd55bb6aa48e11eb3',
	
	    // 小程序 APPID
	    'miniapp_id' => 'wxd55bb6aa48e11eb3',
	
	    // APP 引用的 appid
	    'appid' => 'wx426b3015555a46be',
	
	    // 微信支付分配的微信商户号
	    'mch_id' => '1900009851',
	
	    // 微信支付异步通知地址
	    'notify_url' => 'larabbs.test/test/payment/notify_url',
	
	    // 微信支付签名秘钥
	    'key' => '8934e7d15453e97507ef794cf7b0519d',

        // 客户端证书路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_client' => '',

        // 客户端秘钥路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_key' => '',

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/wechat.log'),
        //     'level' => 'debug'
        ],

        // optional
        // 'dev' 时为沙箱模式
        // 'hk' 时为东南亚节点
         'mode' => 'dev',
    ],
];

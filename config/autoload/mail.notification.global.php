<?php
return [
    'mail' => [
        'notification' => [
            'sender' => [
                'from' => 'noreply@genietree.biz',
                'name' => 'UMeShare',
                'php_process' => [
                    'php_binary' => '/usr/bin/php',
                    'script' => __DIR__ . '/../../bin/email.php'
                ]
            ],
            'welcome' => [
                'template' => 'user/email/welcome.phtml',
                'subject'  => 'Welcome To UMeShare'
            ],
            'payment_reciept' => [
                'template' => 'user/email/paymentReciept.phtml',
                'subject'  => '*GenieResi* Payment Reciept for ',
                'contactUs' => 'info@genietree.biz'
            ],
            'reset_password' => [
                'template' => 'user/email/resetpassword.phtml',
                'subject'  => 'Reset Your UMeShare Password',
                'url' => 'https://:slug.rcs.xtend.net.my/#/reset-password/:key'
            ],
            'activation' => [
                'template_deactivated' => 'user/email/deactivated.phtml',
                'subject_deactivated'  => 'Your Account Has Been Disabled',
                'template_activated' => 'user/email/activated.phtml',
                'subject_activated'  => 'Your Account Has Been Enabled'
            ]
        ]
    ]
];

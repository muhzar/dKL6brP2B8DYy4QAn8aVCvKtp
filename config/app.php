<?php

return [
    'name' => 'My Project',

    /* backend config start*/
    'env' => env('APP_ENV', 'production'),
    'site_name' => env('APP_NAME', 'production'),
    'record_per_page' => env('RECORD_PER_PAGE', 10),
    'folder_upload_images' => 'uploads/images',
    'folder_upload' => 'uploads',

    /* set category id */
    'page_category_id' => env('PAGE_CATEGORY_ID', 2),
    'post_category_id' => env('POST_CATEGORY_ID', 3),
    'news_category_id' => env('NEWS_CATEGORY_ID', 4),
    'banner_category_id' => env('BANNER_CATEGORY_ID', 5),

    /* set type id */
    'page_type_id' => env('PAGE_TYPE_ID', 1),
    'post_type_id' => env('POST_TYPE_ID', 2),

    /* backend config end */

    /* frontend config start */
    'paging_limit' => env('PAGING_LIMIT', 20),

    /* Set Maximum limit showing on homepage */
    'max_slider_homepage' => 4,

    'others_news_limit' => 4,

    /* social media config */
    'facebook_link' => env('FACEBOOK_SOCMED', 'https://www.facebook.com'),
    'twitter_link' => env('TWITTER_SOCMED', 'https://twitter.com'),
    'instagram_link' => env('INSTAGRAM_SOCMED', 'https://www.instagram.com'),
    'youtube_link' => env('YOUTUBE_SOCMED', 'https://www.youtube.com'),

    /* message response */
    'contact_us_message' => env('CONTACT_US_MESSAGE', 'Terimakasih telah menghubungi kami'),

    /* date conversation */
    'month_en_id' => array ('Jan' => 'Januari',
                            'Feb' => 'Februari',
                            'Mar' => 'Maret',
                            'Apr' => 'April',
                            'May' => 'Mei',
                            'Jun' => 'Juni',
                            'Jul' => 'Juli',
                            'Aug' => 'Agustus',
                            'Sep' => 'September',
                            'Oct' => 'Oktober',
                            'Nov' => 'November',
                            'Dec' => 'Desember'),

    'admin_email_sender' => env('ADMIN_EMAIL_SENDER', 'admin@admin.com'),
    'admin_name_sender' => env('ADMIN_NAME_SENDER', 'admin'),
    'admin_contacts' => array('contact_us' => 
                                    ['email' => env('ADMIN_CONTACT_US_EMAIL', 'admin@admin.com'), 
                                    'name' => env('ADMIN_CONTACT_US_NAME', 'admin')], 
                              'career' => 
                                    ['email' => env('ADMIN_CAREER_EMAIL', 'admin'), 
                                    'name' => env('ADMIN_CAREER_NAME', 'admin')]
                        ),
    /* frontend config end */

    'debug' => env('APP_DEBUG', true),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'Asia/Jakarta',
    'locale' => 'en','fallback_locale' => 'en',
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'log' => env('APP_LOG', 'single'),
    'log_level' => env('APP_LOG_LEVEL', 'debug'),
    'providers' => [

        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Laravel\Tinker\TinkerServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

        Maatwebsite\Excel\ExcelServiceProvider::class,


    ],

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        // for excel: 'Excel' => Maatwebsite\Excel\Facades\Excel::class,

    ],

];

<?php

namespace App\Packages\Wechat;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use EasyWeChat\MiniApp\Application;

class MiniProgram
{

    protected $config;

    protected $app;

    public function __construct()
    {
        $this->initConfig();
        $this->app = new Application($this->config);
    }

    protected function initConfig(): void
    {
        $this->config = [
            'app_id' => config('wechat.program.appid'),
            'secret' => config('wechat.program.secret'),
            'http' => [
                'throw' => false,
                'timeout' => 5.0,

                'retry' => true,
            ],
        ];
    }

    /**
     * code交换session
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string     $code
     * @return Collection
     */
    public function codeToSession(string $code): Collection
    {
        $utils = $this->app->getUtils();
        try {
            $response = $utils->codeToSession($code);
        } catch (\Exception $e) {
            $response = json_decode(Str::afterLast($e->getMessage(), 'code2Session error:'), true);
        }
        return collect($response);
    }

    /**
     * 解密数据
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  string     $sessionKey
     * @param  string     $iv
     * @param  string    $encryptedData
     * @return Collection
     */
    public function decryptSession(string $sessionKey, string $iv, string $encryptedData): Collection
    {
        $utils = $this->app->getUtils();
        try {
            $response = $utils->decryptSession($sessionKey, $iv, $encryptedData);
        } catch (\Exception $e) {
            $response = json_decode(Str::afterLast($e->getMessage(), 'code2Session error:'), true);
        }
        return collect($response);
    }
}
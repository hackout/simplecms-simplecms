<?php
namespace App\Packages\Finger;

use Jenssegers\Agent\Agent;

/**
 * 设备指纹
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class Finger
{
    /**
     * 获取设备指纹
     * 请注意前端保存设备指纹
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return string
     */
    public static function getFinger(): string
    {

        if (!$finger = request()->header('X-Device-Finger')) {
            $finger = request()->header('Device-Finger', static::makeFinger());
        }
        return $finger;
    }

    /**
     * 根据浏览器创建指纹码
     * 创建的指纹码不具备唯一性
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return string
     */
    public static function makeFinger(): string
    {
        $agent = new Agent();
        $browser = $agent->browser();
        $browserVersion = $agent->version($browser);
        $platform = $agent->platform();
        $device = $agent->isMobile() ? 'Mobile' : 'Desktop';
        $ipAddress = request()->getClientIp() ?? '127.0.0.1';
        $time = time();
        $fingerprintData = "$browser:$browserVersion; $platform; $device; $ipAddress; $time;";
        $fingerprint = hash('sha256', $fingerprintData);

        return $fingerprint;
    }
}
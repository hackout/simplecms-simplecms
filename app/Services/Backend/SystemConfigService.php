<?php

namespace App\Services\Backend;

use Illuminate\Support\Collection;
use SimpleCMS\Framework\Facades\SystemInfo;
use SimpleCMS\Framework\Facades\CacheManage;
use SimpleCMS\Framework\Models\SystemConfig;
use SimpleCMS\Framework\Services\SimpleService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use SimpleCMS\Framework\Facades\SystemConfig as SystemConfigManage;

class SystemConfigService extends SimpleService
{
    public ?string $className = SystemConfig::class;

    /**
     * 系统参数类型
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return Collection
     */
    public function getTypeList(): Collection
    {
        return collect(['input', 'textarea', 'editor', 'file', 'image', 'radio', 'switch', 'checkbox', 'list', 'select']);
    }

    /**
     * 系统参数列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array $data
     * @return array
     */
    public function getList(array $data): array
    {
        $condition = [
            'keyword' => ['search', ['name', 'description', 'code']],
            'type' => 'eq'
        ];

        parent::listQuery($data, $condition);
        return parent::list();
    }

    public function getValidation(): array
    {
        $configs = $this->getSystemConfig();
        $rules = [];
        $messages = [];
        foreach ($configs as $config) {
            switch ($config['type']) {
                case 'input':
                case 'textarea':
                    $rules[$config['code']] = 'required|max:250';
                    $messages[$config['code'] . '.required'] = $config['name'] . '不能为空';
                    $messages[$config['code'] . '.max'] = $config['name'] . '最大支持250个字符';
                    break;
                case 'editor':
                    $rules[$config['code']] = 'required';
                    $messages[$config['code'] . '.required'] = $config['name'] . '不能为空';
                    break;
                case 'list':
                    $rules[$config['code']] = 'sometimes|nullable|array';
                    $messages[$config['code'] . '.array'] = $config['name'] . '不正确';
                    break;
                case 'checkbox':
                    $rules[$config['code']] = 'sometimes|nullable|array';
                    $rules[$config['code'] . '*'] = 'required|in:' . implode(',', range(0, count($config['options'])));
                    $messages[$config['code'] . '.array'] = $config['name'] . '不正确';
                    $messages[$config['code'] . '.*.required'] = $config['name'] . '不能存在空值';
                    $messages[$config['code'] . '.*.in'] = $config['name'] . '不正确';
                    break;
                case 'radio':
                case 'select':
                    $rules[$config['code']] = 'required|in:' . implode(',', range(0, count($config['options'])));
                    $messages[$config['code'] . '.required'] = $config['name'] . '不能为空';
                    $messages[$config['code'] . '.in'] = $config['name'] . '不正确';
                    break;
                case 'switch':
                    $rules[$config['code']] = 'sometimes|nullable|boolean';
                    $messages[$config['code'] . '.boolean'] = $config['name'] . '不正确';
                    break;
                case 'image':
                    $rules[$config['code']] = 'sometimes|nullable|image';
                    $messages[$config['code'] . '.image'] = $config['name'] . '仅支持图片格式';
                    break;
                case 'file':
                    $rules[$config['code']] = 'sometimes|nullable|file';
                    $messages[$config['code'] . '.file'] = $config['name'] . '仅支持上传文件';
                    break;
            }
        }
        return [$rules, $messages];
    }

    /**
     * 保存系统参数
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array $data
     * @return void
     */
    public function save(array $data): void
    {
        $sql = collect($data);
        $configs = collect($this->getSystemConfig());
        $file = $configs->filter(fn(array $n) => $n['type'] == 'file' || $n['type'] == 'image')->values()->pluck('code')->toArray();
        $array = $configs->filter(fn(array $n) => $n['type'] == 'list' || $n['type'] == 'checkbox')->values()->pluck('code')->toArray();
        $strings = $configs->filter(fn(array $n) => $n['type'] != 'list' && $n['type'] != 'checkbox' && $n['type'] != 'image' && $n['type'] != 'file')->values()->pluck('code')->toArray();
        if (count($strings)) {
            parent::quick('content', $sql->only($strings)->toArray());
        }
        if (count($array)) {
            parent::quick('content', $sql->only($strings)->map(fn($value) => json_encode($value))->toArray());
        }
        if (count($file)) {
            foreach ($file as $code) {
                $value = $sql->get($code);
                if ($value && $value instanceof UploadedFile) {
                    $item = parent::findById($code);
                    $item->media->each(fn(Media $media) => $media->delete());
                    $item->addMedia($value)->toMediaCollection(SystemConfig::MEDIA_FILE);
                }
            }
        }
    }


    /**
     * 系统环境信息
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return array
     */
    public function getSystemInfo(): array
    {
        return SystemInfo::getSystem()->toArray();
    }

    /**
     * 系统设置
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return array
     */
    public function getSystemConfig(): array
    {
        return SystemConfigManage::getConfigs()->toArray();
    }

    /**
     * 获取缓存
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return array
     */
    public function getCacheSize(): array
    {
        return CacheManage::size();
    }

    /**
     * 清空系统缓存
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @return void
     */
    public function clearSystemCache()
    {
        CacheManage::clear();
    }
}

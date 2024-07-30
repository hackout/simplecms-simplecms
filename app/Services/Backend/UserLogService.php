<?php

namespace App\Services\Backend;

use App\Models\User;
use SimpleCMS\Framework\Models\RequestLog;
use SimpleCMS\Framework\Services\SimpleService;

class UserLogService extends SimpleService
{
    public string $className = RequestLog::class;

    /**
     * 获取列表
     *
     * @author Dennis Lui <hackout@vip.qq.com>
     * @param  array $data
     * @return array
     */
    public function getList(array $data): array
    {
        $condition = [
            'keyword' => ['search', ['id', 'name', 'route_name', 'user_agent']],
            'date' => ['datetime_range', 'created_at']
        ];
        $sql = [
            ['model_type', '=', User::class],
            ['model_id', '=', $data['id']]
        ];
        parent::listQuery($data, $condition, $sql);
        $result = parent::list();
        $result['items'] = $result['items']->map(function (RequestLog $requestLog) {
            return [
                'id' => $requestLog->id,
                'created_at' => $requestLog->created_at,
                'model' => $requestLog->model,
                'name' => $requestLog->name,
                'user_agent' => $requestLog->user_agent,
                'method' => $requestLog->method,
                'url' => $requestLog->url,
                'parameters' => $requestLog->parameters,
                'route_name' => $requestLog->route_name,
                'status' => $requestLog->status,
            ];
        })->values();
        return $result;
    }

    public function cleanLog(string $id): void
    {
        RequestLog::where('model_id', $id)
            ->where('model_type', User::class)
            ->delete();
        parent::clearCache();
    }
}

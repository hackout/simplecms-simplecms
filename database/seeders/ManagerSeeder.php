<?php

namespace Database\Seeders;

use Hash;
use App\Models\Manager;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->getList();
        Manager::create($data);
    }

    public function getList()
    {
        return [
            'name' => '管理员',
            'account' => 'manager',
            'email' => 'simplecms@simplecms.com',
            'email_verified_at' => null,
            'password' => Hash::make(config('cms.default_password')),
            'is_super' => true,
            'is_valid' => true
        ];
    }
}

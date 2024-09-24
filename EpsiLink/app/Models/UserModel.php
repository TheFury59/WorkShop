<?php

namespace App\Models;

class UserModel
{
    public function getUsers()
    {
        // Simule une base de données
        return [
            ['name' => 'Alice'],
            ['name' => 'Bob'],
            ['name' => 'Charlie'],
        ];
    }
}

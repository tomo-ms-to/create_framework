<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    public int $id = 0;
    public string $name = '';
    public string $email = '';
    public ?string $created_at = null;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'users'; // テーブル名を明示的に設定
    }
}
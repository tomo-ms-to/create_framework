<?php

namespace Core;

class Model
{
    protected Database $db;
    protected string $tableName; // テーブル名

    public function __construct()
    {
        $this->db = new Database();
    }

    public static function tableName(): string
    {
        // 継承先のクラス名からテーブル名を推測する（例: User -> users）
        $className = (new \ReflectionClass(static::class))->getShortName();
        return strtolower($className) . 's'; // 複数形にする
    }

    public function findOne(array $where): ?object
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = $this->db->query("SELECT * FROM $tableName WHERE $sql", $where);
        $data = $statement->fetchObject(static::class); // static::class で継承元のクラスのインスタンスとしてフェッチ
        return $data ?: null;
    }

    public function findAll(): array
    {
        $tableName = static::tableName();
        $statement = $this->db->query("SELECT * FROM $tableName");
        return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public function save(): bool
    {
        $tableName = static::tableName();
        $attributes = get_object_vars($this); // モデルのプロパティを属性とする
        unset($attributes['db']); // dbプロパティは保存しない
        unset($attributes['tableName']);

        $params = [];
        $columns = [];
        $placeholders = [];
        foreach ($attributes as $key => $value) {
            $columns[] = $key;
            $placeholders[] = ":$key";
            $params[":$key"] = $value;
        }

        $sql = "INSERT INTO $tableName (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        return $this->db->query($sql, $params)->rowCount() > 0;
    }

    // 必要に応じてupdate, deleteなどのメソッドを追加
}
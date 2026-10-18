<?php
declare(strict_types=1);
namespace App;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Client;
use MongoDB\Collection;

final class Notes
{
    private static ?Collection $col = null;

    private static function col(): Collection
    {
        return self::$col ??= (new Client(App::env('MONGO_URI', 'mongodb://127.0.0.1:27017')))
            ->selectDatabase(App::env('MONGO_DB', 'starter'))
            ->selectCollection('notes');
    }

    public static function all(): array
    {
        $out = [];
        foreach (self::col()->find([], ['sort' => ['_id' => -1], 'limit' => 100]) as $d) {
            $out[] = [
                'id'      => (string) $d['_id'],
                'text'    => (string) $d['text'],
                'created' => $d['created']->toDateTime()->format('Y-m-d H:i'),
            ];
        }
        return $out;
    }

    public static function add(string $text): void
    {
        self::col()->insertOne(['text' => $text, 'created' => new UTCDateTime()]);
    }

    public static function delete(string $id): void
    {
        try { $oid = new ObjectId($id); } catch (\Throwable) { return; }
        self::col()->deleteOne(['_id' => $oid]);
    }
}

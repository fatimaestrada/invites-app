<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Affiliate extends Model
{
    // A Workaround that takes the records from the `affiliates.txt` file and returns them as a Collection

    public static function getAll()
    {
        $rows = new Collection();
        $contents = File::lines(storage_path('affiliates.txt'));

        foreach ($contents as $line) {
            $row = json_decode($line);
            $rows->push((object)[
                'id' => $row->affiliate_id,
                'name' => $row->name,
                'latitude' => $row->latitude,
                'longitude' => $row->longitude
            ]);
        }

        return $rows;
    }
}

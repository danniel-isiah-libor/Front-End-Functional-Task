<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /**
     * Get all suppliers
     *
     * @return array
     */
    public static function getAll()
    {
        // Path to your JSON file
        $path = storage_path('app/suppliers.json');

        // Get the file contents
        $json = file_get_contents($path);

        // Decode the JSON data
        $data = json_decode($json, true);

        return $data;
    }
}

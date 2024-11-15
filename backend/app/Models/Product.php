<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Get all products
     *
     * @return array
     */
    public static function getAll()
    {
        // Path to your JSON file
        $path = storage_path('app/products.json');

        // Get the file contents
        $json = file_get_contents($path);

        // Decode the JSON data
        $data = json_decode($json, true);

        return $data;
    }
}

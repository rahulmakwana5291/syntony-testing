<?php

namespace App\Http\Controllers;

use App\Services\DynamoDbService;

class DynamoDbController extends Controller
{
    protected $dynamoDbService;

    public function __construct(DynamoDbService $dynamoDbService)
    {
        $this->dynamoDbService = $dynamoDbService;
    }

    public function getItem()
    {
        $tableName = 'YourTableName';
        $key = [
            'PrimaryKey' => ['S' => 'Value'], // Replace with your key structure
        ];

        $item = $this->dynamoDbService->getItem($tableName, $key);
        return response()->json($item);
    }

    public function queryTable()
    {
        $tableName = 'YourTableName';
        $expression = 'PrimaryKey = :pk';
        $values = [
            ':pk' => ['S' => 'Value'], // Replace with your condition
        ];

        $items = $this->dynamoDbService->queryTable($tableName, $expression, $values);
        return response()->json($items);
    }

    public function getAllUserSettings()
    {
        $tableName = 'user_settings';
        $items = $this->dynamoDbService->scanTable($tableName);


        $plainItems = array_map(function ($item) {
            $result = [];
            foreach ($item as $key => $value) {
                $result[$key] = reset($value); // Extract the first value from the nested array
            }
            return $result;
        }, $items);

        return view('user-settings', compact('plainItems'));

//        return response()->json($plainItems);
    }


}

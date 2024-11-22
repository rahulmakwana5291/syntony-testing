<?php
namespace App\Services;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;

class DynamoDbService
{
    protected $client;

    public function __construct()
    {
        $this->client = new DynamoDbClient([
            'region'  => config('services.aws.region'),
            'version' => 'latest',
            'credentials' => [
                'key'    => config('services.aws.key'),
                'secret' => config('services.aws.secret'),
            ],
        ]);
    }

    public function getItem($tableName, $key)
    {
        try {
            $result = $this->client->getItem([
                'TableName' => $tableName,
                'Key'       => $key,
            ]);
            return $result['Item'] ?? null;
        } catch (DynamoDbException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function queryTable($tableName, $expression, $values)
    {
        try {
            $result = $this->client->query([
                'TableName'                 => $tableName,
                'KeyConditionExpression'    => $expression,
                'ExpressionAttributeValues' => $values,
            ]);
            return $result['Items'] ?? [];
        } catch (DynamoDbException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function scanTable($tableName)
    {
        try {
            $result = $this->client->scan([
                'TableName' => $tableName,
            ]);
            return $result['Items'] ?? [];
        } catch (\Aws\DynamoDb\Exception\DynamoDbException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}

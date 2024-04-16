<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class DatabaseController extends AbstractController
{
    #[Route('/databases', name: 'app_database', methods: ['GET'])]
    public function index(Connection $connection): JsonResponse
    {
        $databases = $connection->fetchAllAssociative('SHOW DATABASES');

        foreach ($databases as $key => &$database) {
            $tables = $connection->fetchAllAssociative('SHOW TABLES FROM `' . $database['Database'] . '`');
            foreach ($tables as $table) {
                $tableName = current($table);
                try {
                    $columns = $connection->fetchAllAssociative('SHOW COLUMNS FROM `' . $database['Database'] . '`.`' . $tableName . '`');
                    $database['tables'][] = [
                        'table' => $tableName,
                        'columns' => $columns,
                    ];
                } catch (\Exception $e) {
                    return $this->json([
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }
        unset($database);

        return $this->json([
            'db_list' => $databases,
        ]);
    }
}

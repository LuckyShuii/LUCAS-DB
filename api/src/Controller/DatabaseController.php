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

    #[Route('/database/{database}', name: 'app_database_show', methods: ['GET'])]
    public function show(Connection $connection, string $database): JsonResponse
    {
        try {
            $tables = $connection->fetchAllAssociative('SHOW TABLES FROM `' . $database . '`');

            foreach ($tables as $key => &$table) {
                $tableName = current($table);

                $rowCount = $connection->fetchOne('SELECT COUNT(*) FROM `' . $database . '`.`' . $tableName . '`');
                $table['rowCount'] = $rowCount;

                $tableType = $connection->fetchOne('SELECT TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = "' . $database . '" AND TABLE_NAME = "' . $tableName . '"');
                $table['tableType'] = $tableType;

                $tableCollation = $connection->fetchOne('SELECT TABLE_COLLATION FROM information_schema.TABLES WHERE TABLE_SCHEMA = "' . $database . '" AND TABLE_NAME = "' . $tableName . '"');
                $table['tableCollation'] = $tableCollation;

                $tableSize = $connection->fetchOne('SELECT ROUND((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024, 2) AS "Size (MB)" FROM information_schema.TABLES WHERE TABLE_SCHEMA = "' . $database . '" AND TABLE_NAME = "' . $tableName . '"');
                $table['tableSize'] = $tableSize;
            }
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }

        return $this->json([
            'tables' => $tables,
        ]);
    }

    #[Route('/database/{database}/table/{table}/drop', name: 'app_database_table_drop', methods: ['DELETE'])]
    public function dropTable(Connection $connection, string $database, string $table): JsonResponse
    {
        try {
            $connection->executeStatement('DROP TABLE `' . $database . '`.`' . $table . '`');
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }

        return $this->json([
            'message' => 'Table ' . $table . ' has been dropped.',
        ]);
    }

    #[Route('/database/{database}/table/{table}/empty', name: 'app_database_table_empty', methods: ['DELETE'])]
    public function emptyTable(Connection $connection, string $database, string $table): JsonResponse
    {
        try {
            $connection->executeStatement('TRUNCATE TABLE `' . $database . '`.`' . $table . '`');
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }

        return $this->json([
            'message' => 'Table ' . $table . ' has been emptied.',
        ]);
    }
}

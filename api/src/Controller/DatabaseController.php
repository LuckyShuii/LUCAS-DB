<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/database/check/{database}', name: 'app_database_check', methods: ['GET'])]
    public function checkDatabase(Connection $connection, string $database): JsonResponse
    {
        try {
            $connection->executeStatement('USE `' . $database . '`');
            if ($connection->isConnected()) {
                $exists = true;
                $connection->close();
            } else {
                $exists = false;
            }
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }

        return $this->json([
            'exists' => $exists,
        ]);
    }

    #[Route('/database/create', name: 'app_database_create', methods: ['POST'])]
    public function createDatabase(Connection $connection, Request $request): JsonResponse
    {
        $content = $request->getContent();
        $data = json_decode($content, true);

        $database = $data['dbName'];
        $collation = $data['collation'];

        try {
            $connection->executeStatement('CREATE DATABASE `' . $database . '` COLLATE ' . $collation);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }

        return $this->json([
            'message' => 'Database ' . $database . ' has been created.',
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

    #[Route('/database/drop/{database}', name: 'app_database_drop', methods: ['DELETE'])]
    public function dropDatabase(Connection $connection, string $database): JsonResponse
    {
        try {
            $connection->executeStatement('DROP DATABASE `' . $database . '`');
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }

        return $this->json([
            'message' => 'Database ' . $database . ' has been dropped.',
        ]);
    }
}

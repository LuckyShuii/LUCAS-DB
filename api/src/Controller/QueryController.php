<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api')]
class QueryController extends AbstractController
{
    #[Route('/query', name: 'app_query', methods: ['POST'])]
    public function index(Request $request, Connection $connection): JsonResponse
    {
        $content = $request->getContent();
        $data = json_decode($content, true);

        $database = $data['database'];
        $query = $data['query'];

        try {
            $connection->executeStatement('USE `' . $database . '`');
            $result = $connection->fetchAllAssociative($query);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ]);
        }

        return $this->json([
            'result' => $result,
        ]);
    }
}

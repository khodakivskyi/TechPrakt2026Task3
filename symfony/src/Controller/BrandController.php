<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class BrandController extends AbstractController
{
    public const DATA = [
        [
            'id' => "1",
            'name' => 'Apple',
            'description' => 'Technology company known for iPhone, MacBook, and ecosystem products.',
            'createdAt' => '2026-06-16T10:00:00Z',
            'updatedAt' => '2026-06-16T10:00:00Z'
        ],
        [
            'id' => "2",
            'name' => 'Nike',
            'description' => 'Global sportswear brand producing footwear, apparel, and equipment.',
            'createdAt' => '2026-06-16T10:10:00Z',
            'updatedAt' => '2026-06-16T10:15:00Z'
        ],
        [
            'id' => "3",
            'name' => 'Samsung',
            'description' => 'Electronics company offering smartphones, TVs, and appliances.',
            'createdAt' => '2026-06-16T10:20:00Z',
            'updatedAt' => '2026-06-16T10:20:00Z'
        ],
        [
            'id' => "4",
            'name' => 'Adidas',
            'description' => 'Sportwear brand focused on shoes, clothing, and accessories.',
            'createdAt' => '2026-06-16T10:30:00Z',
            'updatedAt' => '2026-06-16T10:35:00Z'
        ]
    ];

    #[Route('/brands', name: 'get_brands', methods: ['GET'])]
    public function getBrands(): Response
    {
        return new JsonResponse(self::DATA, Response::HTTP_OK);
    }

    #[Route('/brands/{id}', name: 'get_brand_by_id', methods: ['GET'])]
    public function getBrandById(string $id): Response
    {
        foreach (self::DATA as $brand) {
            if ($brand['id'] === $id) {
                return new JsonResponse($brand, Response::HTTP_OK);
            }
        }

        throw new NotFoundHttpException('Brand not found');
    }

    #[Route('/brands', name: 'create_brand', methods: ['POST'])]
    public function createBrand(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name']) || empty($data['name'])) {
            return new JsonResponse([
                'message' => 'Validation failed',
                'errors' => [
                    'name' => ['The name field is required.']
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        $id = rand(5, 100);
        $now = date('c');

        $data['id'] = (string)$id;
        $data['createdAt'] = $now;
        $data['updatedAt'] = $now;

        return new JsonResponse($data, Response::HTTP_CREATED);
    }

    #[Route('/brands/{id}', name: 'update_brand', methods: ['PATCH'])]
    public function updateBrand(string $id, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $oldBrand = null;

        foreach (self::DATA as $brand) {
            if ($brand['id'] === $id) {
                $oldBrand = $brand;
                break;
            }
        }

        if (!$oldBrand) {
            throw new NotFoundHttpException('Brand not found');
        }

        if (isset($data['name'])) {
            $oldBrand['name'] = $data['name'];
        }

        if (isset($data['description'])) {
            $oldBrand['description'] = $data['description'];
        }

        $oldBrand['updatedAt'] = date('c');

        return new JsonResponse($oldBrand, Response::HTTP_OK);
    }

    #[Route('/brands/{id}', name: 'delete_brand', methods: ['DELETE'])]
    public function deleteBrand(string $id): Response
    {
        foreach (self::DATA as $brand) {
            if ($brand['id'] === $id) {
                return new JsonResponse(null, Response::HTTP_NO_CONTENT);
            }
        }

        throw new NotFoundHttpException('Brand not found');
    }
}

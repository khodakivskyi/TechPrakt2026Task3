<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private const DATA = [
        [
            'id' => '1',
            'name' => 'Apple',
            'description' => 'Technology company known for iPhone, MacBook, and ecosystem products.',
            'createdAt' => '2026-06-16T10:00:00Z',
            'updatedAt' => '2026-06-16T10:00:00Z'
        ],
        [
            'id' => '2',
            'name' => 'Nike',
            'description' => 'Global sportswear brand producing footwear, apparel, and equipment.',
            'createdAt' => '2026-06-16T10:10:00Z',
            'updatedAt' => '2026-06-16T10:15:00Z'
        ],
        [
            'id' => '3',
            'name' => 'Samsung',
            'description' => 'Electronics company offering smartphones, TVs, and appliances.',
            'createdAt' => '2026-06-16T10:20:00Z',
            'updatedAt' => '2026-06-16T10:20:00Z'
        ],
        [
            'id' => '4',
            'name' => 'Adidas',
            'description' => 'Sportswear brand focused on shoes, clothing, and accessories.',
            'createdAt' => '2026-06-16T10:30:00Z',
            'updatedAt' => '2026-06-16T10:35:00Z'
        ]
    ];

    public function getBrands(): JsonResponse
    {
        return response()->json(self::DATA);
    }

    public function getBrand(string $id): JsonResponse
    {
        foreach (self::DATA as $brand) {
            if ($brand['id'] === $id) {
                return response()->json($brand);
            }
        }

        return response()->json([
            'message' => 'Brand not found'
        ], 404);
    }

    public function createBrand(Request $request): JsonResponse
    {
        $data = $request->all();

        if (!isset($data['name']) || empty($data['name'])) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => [
                    'name' => ['The name field is required.']
                ]
            ], 400);
        }

        $now = now()->toIso8601String();

        $data['id'] = (string) rand(5, 100);
        $data['createdAt'] = $now;
        $data['updatedAt'] = $now;

        return response()->json($data, 201);
    }

    public function updateBrand(string $id, Request $request): JsonResponse
    {
        $oldBrand = null;

        foreach (self::DATA as $brand) {
            if ($brand['id'] === $id) {
                $oldBrand = $brand;
                break;
            }
        }

        if (!$oldBrand) {
            return response()->json([
                'message' => 'Brand not found'
            ], 404);
        }

        $data = $request->all();

        if (isset($data['name'])) {
            $oldBrand['name'] = $data['name'];
        }

        if (isset($data['description'])) {
            $oldBrand['description'] = $data['description'];
        }

        $oldBrand['updatedAt'] = now()->toIso8601String();

        return response()->json($oldBrand);
    }

    public function deleteBrand(string $id): JsonResponse
    {
        foreach (self::DATA as $brand) {
            if ($brand['id'] === $id) {
                return response()->json(null, 204);
            }
        }

        return response()->json([
            'message' => 'Brand not found'
        ], 404);
    }
}

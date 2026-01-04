<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponseTraitTest extends TestCase
{
    public function test_success_response_structure()
    {
        $obj = new class {
            use ApiResponse;
            public function get() { return $this->success(['foo' => 'bar'], 'OK', 200); }
        };

        $response = $obj->get();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData(true);
        $this->assertEquals('success', $data['status']);
        $this->assertEquals('OK', $data['message']);
        $this->assertEquals(['foo' => 'bar'], $data['data']);
    }

    public function test_error_response_structure()
    {
        $obj = new class {
            use ApiResponse;
            public function get() { return $this->error('Something went wrong', 500, ['field' => 'error']); }
        };

        $response = $obj->get();
        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData(true);
        $this->assertEquals('error', $data['status']);
        $this->assertEquals('Something went wrong', $data['message']);
        $this->assertArrayHasKey('errors', $data);
    }

    public function test_paginated_response_structure()
    {
        $items = [];
        for ($i = 1; $i <= 3; $i++) {
            $items[] = ['id' => $i];
        }

        $paginator = new LengthAwarePaginator($items, 3, 10, 1, [
            'path' => '/test'
        ]);

        $obj = new class {
            use ApiResponse;
            public function get($paginator) { return $this->paginated($paginator, null, 'OK', 200); }
        };

        $response = $obj->get($paginator);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData(true);
        $this->assertEquals('success', $data['status']);
        $this->assertEquals('OK', $data['message']);
        $this->assertArrayHasKey('meta', $data);
        $this->assertIsArray($data['data']);
    }
}

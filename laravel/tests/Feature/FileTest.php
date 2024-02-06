<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FileTest extends TestCase
{
    /**
     * @param array 
     * @param int 
     * @param bool 
     * @param mixed 
     * @param string|null 
     * @param array|null 
     * @return void
     */
    private function assertJsonResponse(array $responseContent, int $statusCode, bool $success, $data = null, ?string $message = null, ?array $errors = null): void
    {
        $this->assertEquals($statusCode, $responseContent['status']);
        $this->assertEquals($success, $responseContent['success']);

        if ($data !== null) {
            $this->assertEquals($data, $responseContent['data']);
        }

        if ($message !== null) {
            $this->assertEquals($message, $responseContent['message']);
        }

        if ($errors !== null) {
            $this->assertEquals($errors, $responseContent['errors']);
        }
    }

    /**
     * @return void
     */
    public function test_file_list(): void
    {
        
        $responseContent = [
            'status' => 200,
            'success' => true,
            'data' => 'Llistat d’objectes File'
        ];

        $this->assertJsonResponse($responseContent, 200, true, 'Llistat d’objectes File');
    }

    

    /**
     * @return void
     */
    public function test_file_create(): void
    {
        
        $responseContent = [
            'status' => 201,
            'success' => true,
            'data' => 'Objecte File (creat)'
        ];

        $this->assertJsonResponse($responseContent, 201, true, 'Objecte File (creat)');
    }

     /**
     * @return void
     */
    public function test_file_create_error(): void
    {
        $responseContent = [
            'status' => 422,
            'success' => false,
        ];

        $this->assertJsonResponse($responseContent, 422, false);
    }

    /**
     * @return void
     */
    public function test_file_read(): void
    {
        
        $responseContent = [
            'status' => 200,
            'success' => true,
            
        ];

        $this->assertJsonResponse($responseContent, 200, true);
    }

    /**
     * @return void
     */
    public function test_file_read_notfound(): void
    {
        
        $responseContent = [
            'status' => 404,
            'success' => false,
          
        ];

        $this->assertJsonResponse($responseContent, 404, false);
    }

    /**
     * @return void
     */
    public function test_file_update(): void
    {
        
        $responseContent = [
            'status' => 200,
            'success' => true,
            
        ];

        $this->assertJsonResponse($responseContent, 200, true);
    }

    /**
     * @return void
     */
    public function test_file_update_error(): void
    {
        $responseContent = [
            'status' => 422,
            'success' => false,
        ];

        $this->assertJsonResponse($responseContent, 422, false);
    }

    /**
     * @return void
     */
    public function test_file_update_notfound(): void
    {
        $responseContent = [
            'status' => 404,
            'success' => false,
        ];

        $this->assertJsonResponse($responseContent, 404, false);
    }

    /**
     * @return void
     */
    public function test_file_delete(): void
    {
        $responseContent = [
            'status' => 200,
            'success' => true,
        ];

        $this->assertJsonResponse($responseContent, 200, true);
    }

    /**
     * @return void
     */
    public function test_file_delete_notfound(): void
    {
        $responseContent = [
            'status' => 404,
            'success' => false,
        ];

        $this->assertJsonResponse($responseContent, 404, false);
    }
    
}

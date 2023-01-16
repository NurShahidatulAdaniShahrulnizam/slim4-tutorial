<?php

namespace App\Action\Department;

use App\Domain\Service\Department\DepartmentCreater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddDepartment
{
    /**
     * @var DepartmentCreater
     */
    private $departmentCreatorService;

    /**
     * The constructor.
     *
     * @param DepartmentCreater $departmentCreatorService The profiling form updater service
     */
    public function __construct(DepartmentCreater $departmentCreatorService)
    {
        $this->departmentCreatorService = $departmentCreatorService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $status = null;

        // Collect input from the HTTP request
        $data = (array) $request->getParsedBody();

        
        $name = (string) ($data['name'] ?? null);

        // Validation
        if ($name == null) {
            $status = 400;
            $result = [
                'success' => false,
                'message' => 'Department name is required.'
            ];
            return $this->sendResponse($response, $result, $status);
        }

        $data = $this->departmentCreatorService->createDepartment($name);
        if ($data->success) {
            // Create success
            $status = $data->status;
            $result = [
                'success' => $data->success,
                'message' => $data->message
            ];
        } else {
            // Create fail
            $status = $data->status;
            $result = [
                'success' => $data->success,
                'message' => $data->message
            ];
        }
        
        return $this->sendResponse($response, $result, $status);
    }

    private function sendResponse($response, $result, $status)
    {
        // Build the HTTP response
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write((string) json_encode($result));

        return $response->withStatus($status);
    }
}
<?php

namespace App\Action\Department;

use App\Domain\Service\Department\DepartmentReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListDepartment
{
    /**
     * @var DepartmentReader
     */
    private $DepartmentReaderService;

    /**
     * The constructor.
     *
     * @param DepartmentReader $DepartmentReaderService The pre registered Department reader service
     */
    public function __construct(DepartmentReader $DepartmentReaderService)
    {
        $this->DepartmentReaderService = $DepartmentReaderService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
            $data = $this->DepartmentReaderService->getAllDepartments();

        // Transform the result into the JSON representation
        $result = [
            'success' => $data->success,
            'message' => $data->message,
            'data' => $data->records
        ];

        // Build the HTTP response
        $response->getBody()->write((string) json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
<?php

namespace App\Action\Department;

use App\Domain\Service\Department\DepartmentUpdater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

final class UpdateDepartment

{
    /**
     * @var DepartmentUpdater
     */
    private $departmentUpdaterService;

    /**
     * The constructor.
     *
     * @param DepartmentUpdater $departmentUpdaterService The department updater service
     */
    public function __construct(DepartmentUpdater $departmentUpdaterService)
    {
        $this->departmentUpdaterService = $departmentUpdaterService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        $id = $route->getArgument('id');
        
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

        // Update department
        $data = $this->departmentUpdaterService->updateDepartment($id, $name);
        if ($data->success) {
            // Update success
            $status = $data->status;
            $result = [
                'success' => $data->success,
                'message' => $data->message
            ];
        } else {
            // Update fails
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

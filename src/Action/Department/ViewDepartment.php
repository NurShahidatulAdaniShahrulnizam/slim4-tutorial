<?php

namespace App\Action\Department;

use App\Domain\Service\Department\DepartmentReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

final class ViewDepartment
{
    /**
     * @var DepartmentReader
     */
    private $customerReaderService;

    /**
     * The constructor.
     *
     * @param DepartmentReader $customerReaderService The customer reader service
     */
    public function __construct(DepartmentReader $customerReaderService)
    {
        $this->customerReaderService = $customerReaderService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        $id = $route->getArgument('id');

        $data = $this->customerReaderService->getDepartmentById($id);

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
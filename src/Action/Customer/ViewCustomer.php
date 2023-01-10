<?php

namespace App\Action\Customer;

use App\Domain\Service\Customer\CustomerReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

final class ViewCustomer
{
    /**
     * @var CustomerReader
     */
    private $customerReaderService;

    /**
     * The constructor.
     *
     * @param CustomerReader $customerReaderService The customer reader service
     */
    public function __construct(CustomerReader $customerReaderService)
    {
        $this->customerReaderService = $customerReaderService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        $id = $route->getArgument('id');

        $data = $this->customerReaderService->getCustomerById($id);

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
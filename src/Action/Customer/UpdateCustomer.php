<?php

namespace App\Action\Customer;

use App\Domain\Service\Customer\CustomerUpdater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

final class UpdateCustomer

{
    /**
     * @var CustomerUpdater
     */
    private $customerUpdaterService;

    /**
     * The constructor.
     *
     * @param CustomerUpdater $customerUpdaterService The customer updater service
     */
    public function __construct(CustomerUpdater $customerUpdaterService)
    {
        $this->customerUpdaterService = $customerUpdaterService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        $id = $route->getArgument('id');
        
        // Collect input from the HTTP request
        $data = (array) $request->getParsedBody();
        $name = (string) ($data['name'] ?? null);
        $email = (string) ($data['email'] ?? null);
        $phone = (string) ($data['phone'] ?? null);

        // Validation
        if ($name == null) {
            $status = 400;
            $result = [
                'success' => false,
                'message' => 'Customer name is required.'
            ];
            return $this->sendResponse($response, $result, $status);
        }
        if ($email == null) {
            $status = 400;
            $result = [
                'success' => false,
                'message' => 'Customer email is required.'
            ];
            return $this->sendResponse($response, $result, $status);
        }
        if ($phone == null) {
            $status = 400;
            $result = [
                'success' => false,
                'message' => 'Customer phone is required.'
            ];
            return $this->sendResponse($response, $result, $status);
        }

        // Update customer
        $data = $this->customerUpdaterService->updateCustomer($id, $name, $email, $phone);
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

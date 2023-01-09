<?php

namespace App\Action\Customer;

use App\Domain\Service\Customer\CustomerCreater;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AddCustomer
{
    /**
     * @var CustomerCreater
     */
    private $customerCreatorService;

    /**
     * The constructor.
     *
     * @param CustomerCreater $customerCreatorService The profiling form updater service
     */
    public function __construct(CustomerCreater $customerCreatorService)
    {
        $this->customerCreatorService = $customerCreatorService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $status = null;

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

        $data = $this->customerCreatorService->createCustomer($name, $email, $phone);
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
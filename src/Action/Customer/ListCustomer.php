<?php

namespace App\Action\Customer;

use App\Domain\Service\Customer\CustomerReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListCustomer
{
    /**
     * @var CustomerReader
     */
    private $CustomerReaderService;

    /**
     * The constructor.
     *
     * @param CustomerReader $CustomerReaderService The pre registered Customer reader service
     */
    public function __construct(CustomerReader $CustomerReaderService)
    {
        $this->CustomerReaderService = $CustomerReaderService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
            $data = $this->CustomerReaderService->getAllCustomers();

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
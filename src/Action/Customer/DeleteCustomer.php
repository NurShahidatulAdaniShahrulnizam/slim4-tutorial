<?php

namespace App\Action\Customer;

use App\Domain\Service\Customer\CustomerDeleter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

final class DeleteCustomer
{
  private $customerDeleterService;

  public function __construct(CustomerDeleter $customerDeleterService)
  {
    $this->customerDeleterService = $customerDeleterService;
  }

  public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
  {
    $routeContext = RouteContext::fromRequest($request);
    $route = $routeContext->getRoute();

    $id = $route->getArgument('id');

    $data = $this->customerDeleterService->deleteRecord($id);
    if ($data->success) {
        // Delete success
        $status = $data->status;
        $result = [
            'success' => $data->success,
            'message' => $data->message
        ];
    } else {
        // Delete fails
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
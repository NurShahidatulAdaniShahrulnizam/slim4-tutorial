<?php

namespace App\Domain\Service\Customer;

use App\Domain\Repository\CustomerRepository;

/**
 * Service.
 */
final class CustomerDeleter
{
    /**
     * @var CustomerRepository
     */
    private $customerRepo;

    /**
     * The constructor.
     *
     * @param CustomerRepository $customerRepo The customer repository
     */
    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function deleteRecord(
        int $id
    ) {
        try {
            if ($this->customerRepo->deleteCustomer($id)) {
                $response = (object) [
                    'status' => 200,
                    'success' => true,
                    'message' => 'The customer was deleted successfully.'
                ];
            }
            else {
                $response = (object) [
                    'status' => 200,
                    'success' => false,
                    'message' => 'Failed to delete the customer.'
                ];
            }
            
            return $response;
        } catch (\Exception $e) {
            $response = (object) [
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }
    }
}
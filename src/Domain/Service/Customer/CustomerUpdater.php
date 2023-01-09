<?php

namespace App\Domain\Service\Customer;

use App\Domain\Repository\CustomerRepository;

/**
 * Service.
 */
final class CustomerUpdater
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

    public function updateCustomer(
        int $id,
        string $name,
        string $email,
        string $phone
    ) {
        try {
            if ($this->customerRepo->updateCustomer($id, $name, $email, $phone)) {
                $response = (object) [
                    'status' => 200,
                    'success' => true,
                    'message' => 'The customer was updated successfully.'
                ];
            } else {
                $response = (object) [
                    'status' => 200,
                    'success' => false,
                    'message' => 'Failed to update the customer.'
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
<?php

namespace App\Domain\Service\Customer;

use App\Domain\Repository\CustomerRepository;

/**
 * Service.
 */
final class CustomerReader
{
    /**
     * @var CustomerRepository
     */
    private $customerRepo;

    /**
     * The constructor.
     *
     * @param CustomerRepository $customerRepo The customer project repository
     */
    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function getAllCustomers()
    {
        $customers = $this->customerRepo->getAllCustomers();
        $response = (object) [
            'success' => true,
            'message' => null,
            'records' => (object) [
                'customers' => $customers
            ]
        ];

        return $response;
    }

    public function getCustomerById(int $id)
    {
        $customer = $this->customerRepo->getCustomerById($id);
        $response = (object) [
            'success' => true,
            'message' => null,
            'records' => (object) [
                'customer' => $customer
            ]
        ];

        return $response;
    }
}
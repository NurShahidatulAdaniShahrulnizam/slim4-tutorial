<?php

namespace App\Domain\Service\Customer;


use App\Domain\Repository\CustomerRepository;

/**
 * Service.
 */
final class CustomerCreater
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

    public function createCustomer(
        string $name,
        string $email,
        string $phone
    ) {
        try {
            $id = $this->customerRepo->createCustomer($name, $email, $phone);
            
            if ($id > 0) {

                $response = (object) [
                    'status' => 200,
                    'success' => true,
                    'message' => 'The customer was saved successfully.'
                ];
            }
            else {
                $response = (object) [
                    'status' => 200,
                    'success' => false,
                    'message' => 'Failed to save the appeal.'
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
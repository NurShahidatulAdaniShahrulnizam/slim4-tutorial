<?php

namespace App\Domain\Service\Department;
use App\Domain\Repository\DepartmentRepository;

/**
 * Service.
 */
final class DepartmentCreater
{
    /**
     * @var DepartmentRepository
     */
    private $departmentRepo;

    /**
     * The constructor.
     *
     * @param DepartmentRepository $departmentRepo The department repository
     */
    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepo = $departmentRepo;
    }

    public function createDepartment(
        string $name
    ) {
        try {
            $id = $this->departmentRepo->createDepartment($name);
            
            if ($id > 0) {

                $response = (object) [
                    'status' => 200,
                    'success' => true,
                    'message' => 'The department was saved successfully.'
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
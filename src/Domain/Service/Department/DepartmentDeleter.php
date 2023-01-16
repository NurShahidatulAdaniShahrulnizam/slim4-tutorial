<?php

namespace App\Domain\Service\Department;

use App\Domain\Repository\DepartmentRepository;

/**
 * Service.
 */
final class DepartmentDeleter
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

    public function deleteRecord(
        int $id
    ) {
        try {
            if ($this->departmentRepo->deleteDepartment($id)) {
                $response = (object) [
                    'status' => 200,
                    'success' => true,
                    'message' => 'The department was deleted successfully.'
                ];
            }
            else {
                $response = (object) [
                    'status' => 200,
                    'success' => false,
                    'message' => 'Failed to delete the department.'
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
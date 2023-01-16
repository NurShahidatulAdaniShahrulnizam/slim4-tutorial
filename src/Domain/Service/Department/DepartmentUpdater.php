<?php

namespace App\Domain\Service\Department;

use App\Domain\Repository\DepartmentRepository;

/**
 * Service.
 */
final class DepartmentUpdater
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

    public function updateDepartment(
        int $id,
        string $name
    ) {
        try {
            if ($this->departmentRepo->updateDepartment($id, $name)) {
                $response = (object) [
                    'status' => 200,
                    'success' => true,
                    'message' => 'The department was updated successfully.'
                ];
            } else {
                $response = (object) [
                    'status' => 200,
                    'success' => false,
                    'message' => 'Failed to update the department.'
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
<?php

namespace App\Domain\Service\Department;

use App\Domain\Repository\DepartmentRepository;

/**
 * Service.
 */
final class DepartmentReader
{
    /**
     * @var DepartmentRepository
     */
    private $departmentRepo;

    /**
     * The constructor.
     *
     * @param DepartmentRepository $departmentRepo The department project repository
     */
    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepo = $departmentRepo;
    }

    public function getAllDepartments()
    {
        $departments = $this->departmentRepo->getAllDepartments();
        $response = (object) [
            'success' => true,
            'message' => null,
            'records' => (object) [
                'departments' => $departments
            ]
        ];

        return $response;
    }

    public function getDepartmentById(int $id)
    {
        $department = $this->departmentRepo->getDepartmentById($id);
        $response = (object) [
            'success' => true,
            'message' => null,
            'records' => (object) [
                'department' => $department
            ]
        ];

        return $response;
    }
}
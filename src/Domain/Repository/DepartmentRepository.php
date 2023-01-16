<?php

namespace App\Domain\Repository;

use Doctrine\DBAL\Connection;

class DepartmentRepository
{
    /**
     * @var Connection The database connection
     */
    private $connection;

    /**
     * The constructor.
     *
     * @param Connection $connection The database connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function createDepartment(
        string $name
    ) {
        $query = $this->connection->createQueryBuilder();

        $query
            ->insert('departments')
            ->values(
                array(
                    'name' => '?'
                )
            )
            ->setParameter(0, $name);

        $rows = $query->executeStatement();

        return $this->connection->lastInsertId();
    }

    public function getAllDepartments()
    {
        $query = $this->connection->createQueryBuilder();

        $rows = $query
            ->select(
                'd.id',
                'd.name'
            )
            ->from('departments', 'd');

        return $rows->fetchAllAssociative();
    }

    public function getDepartmentById(int $id)
    {
        $query = $this->connection->createQueryBuilder();

        $rows = $query
            ->select(
                'd.id',
                'd.name'
            )
            ->from('departments', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id);

        return $rows->fetchAssociative();
    }

    public function updateDepartment(
        int $id,
        string $name
    ) {
        $query = $this->connection->createQueryBuilder();

        $query
            ->update('departments')
            ->where('id = :id')
            ->setParameter('id', $id);

        $query->set('name', ':name')->setParameter('name', $name);

        // $date = date("Y-m-d H:i:s");
        // $query->set('DateUpdated', ':date')->setParameter('date', $date);

        $rows = $query->executeStatement();

        return $rows > 0;
    }

    public function deleteDepartment(
        int $id
    ) {
        $query = $this->connection->createQueryBuilder();

        $query
            ->delete('departments')
            ->where('id = :id')
            ->setParameter('id', $id);

        $rows = $query->executeStatement();

        return $rows > 0;
    }
}
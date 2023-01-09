<?php

namespace App\Domain\Repository;

use Doctrine\DBAL\Connection;

class CustomerRepository
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

    public function createCustomer(
        string $name,
        string $email,
        string $phone
    ) {
        $query = $this->connection->createQueryBuilder();

        $query
            ->insert('customers')
            ->values(
                array(
                    'name' => '?',
                    'email' => '?',
                    'phone' => '?'
                )
            )
            ->setParameter(0, $name)
            ->setParameter(1, $email)
            ->setParameter(2, $phone);

        $rows = $query->executeStatement();

        return $this->connection->lastInsertId();
    }

    public function getAllCustomers()
    {
        $query = $this->connection->createQueryBuilder();

        $rows = $query
            ->select(
                'c.id',
                'c.name',
                'c.email',
                'c.phone'
            )
            ->from('customers', 'c');

        // return $rows->fetchAllAssociative();
        return [];
    }

    public function getCustomerById(int $id)
    {
        $query = $this->connection->createQueryBuilder();

        $rows = $query
            ->select(
                'c.id',
                'c.name',
                'c.email',
                'c.phone'
            )
            ->from('customers', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id);

        return $rows->fetchAssociative();
    }

    public function updateCustomer(
        int $id,
        string $name,
        string $email,
        string $phone
    ) {
        $query = $this->connection->createQueryBuilder();

        $query
            ->update('customers')
            ->where('id = :id')
            ->setParameter('id', $id);

        $query->set('name', ':name')->setParameter('name', $name);
        $query->set('email', ':email')->setParameter('email', $email);
        $query->set('phone', ':phone')->setParameter('phone', $phone);

        // $date = date("Y-m-d H:i:s");
        // $query->set('DateUpdated', ':date')->setParameter('date', $date);

        $rows = $query->executeStatement();

        return $rows > 0;
    }

    public function deleteCustomer(
        int $id
    ) {
        $query = $this->connection->createQueryBuilder();

        $query
            ->delete('customers')
            ->where('id = :id')
            ->setParameter('id', $id);

        $rows = $query->executeStatement();

        return $rows > 0;
    }
}
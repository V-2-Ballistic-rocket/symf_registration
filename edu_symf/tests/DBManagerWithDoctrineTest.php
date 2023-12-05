<?php

namespace App\Tests;

use App\InfrastructureLayer\PostgresWithDoctrine\DBManagerWithDoctrine;
use App\InfrastructureLayer\UserDTO\DeleteUserDTO;
use App\InfrastructureLayer\UserDTO\GetUserDTO;
use App\InfrastructureLayer\UserDTO\SaveUserDTO;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DBManagerWithDoctrineTest extends KernelTestCase
{
    /**
     *@dataProvider getUserProvider
     */
    public function testGetUser($firstName, $lastName): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $dbManager = $container->get(DBManagerWithDoctrine::class);

        $savedUserDTO = $dbManager->saveUser(new SaveUserDTO($firstName, $lastName));

        $gotUserDTO = $dbManager->getUser(new GetUserDTO($savedUserDTO->id));

        $this->assertEquals(array($gotUserDTO->firstName, $gotUserDTO->lastName), array($firstName, $lastName));

        $dbManager->deleteUser(new DeleteUserDTO($savedUserDTO->id));
    }

    public function getUserProvider() : array
    {
        return [
            'when valid data' =>
            [
                'firstName' => 'Igor',
                'lastName' => 'Marchenko'
            ]
        ];
    }

    /**
     *@dataProvider saveUserProvider
     */
    public function testSaveUser($firstName, $lastName): void
    {
        $dbManager = new DBManagerWithDoctrine();
        $savedUserDTO = $dbManager->saveUser(new SaveUserDTO($firstName, $lastName));

        $gotUserDTO = $dbManager->getUser(new GetUserDTO($savedUserDTO->id));

        $this->assertEquals(array($gotUserDTO->firstName, $gotUserDTO->lastName), array($firstName, $lastName));

        $dbManager->deleteUser(new DeleteUserDTO($savedUserDTO->id));
    }

    public function saveUserProvider() : array
    {
        return [
            'when valid data' =>
            [[
                'firstName' => 'Vasiliy',
                'lastName' => 'Mahonenko'
            ]]
        ];
    }
}

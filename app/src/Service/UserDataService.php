<?php
/**
 * UserData service.
 */

namespace App\Service;

use App\Entity\UserData;
use App\Repository\UserDataRepository;

/**
 * Class UserDataService.
 */
class UserDataService
{
    /**
     * UserData repository.
     *
     * @var UserDataRepository
     */
    private $userDataRepository;

    /**
     * UserDataService constructor.
     *
     * @param UserDataRepository $userDataRepository UserData repository
     */
    public function __construct(UserDataRepository $userDataRepository)
    {
        $this->userDataRepository = $userDataRepository;
    }

    /**
     * Save user data.
     *
     * @param UserData $userData User data entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(UserData $userData): void
    {
        $this->userDataRepository->save($userData);
    }
}

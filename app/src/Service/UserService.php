<?php
/**
 * User service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class UserService.
 */
class UserService
{
    /**
     * User repository.
     *
     * @var \App\Repository\UserRepository
     */
    private $userRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param PaginatorInterface $paginator
     *
     */
    public function __construct(UserRepository $userRepository, PaginatorInterface $paginator)
    {
        $this->userRepository = $userRepository;
        $this->paginator = $paginator;
    }

    /**
     * Save user.
     *
     * @param \App\Entity\User $user User entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveUser(User $user): void
    {
        $this->userRepository->saveUser($user);
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->userRepository->queryAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Find one by.
     *
     * @param array $array User array
     *
     * @return User|null Result
     */
    public function findOneBy(array $array)
    {
        return $this->userRepository->findOneBy($array);
    }
}

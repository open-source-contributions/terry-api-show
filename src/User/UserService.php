<?php

declare(strict_types=1);

namespace App\User;

use App\User\Command\CreateProfile;
use App\User\Command\EditUser;
use App\User\Entity\User;
use App\User\Exception\UserAlreadyExists;
use App\User\Exception\UserNotExists;
use App\User\PasswordEncoder;
use App\User\Repository\UserRepository;
use App\User\Repository\UserViewRepository;
use App\User\Value\Email;
use App\User\Value\UserId;
use App\User\View\ProfileView;
use App\User\View\UserView;

class UserService
{
    private UserRepository $userRepository;

    private UserViewRepository $userViewRepository;

    private PasswordEncoder $passwordEncoder;

    public function __construct(UserRepository $userRepository, UserViewRepository $userViewRepository, PasswordEncoder $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->userViewRepository = $userViewRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createProfile(CreateProfile $createProfile): void
    {
        if ($this->userRepository->userExists(Email::fromString($createProfile->email))) {
            throw UserAlreadyExists::email($createProfile->email);
        }

        $userId = $this->userRepository->nextId();

        $this->userRepository->saveUser(User::fromCreateProfile($userId, $createProfile, $this->passwordEncoder));
    }

    public function profile(UserId $userId): ProfileView
    {
        return $this->userViewRepository->findProfileView($userId);
    }

    public function editUser(EditUser $editUser): void
    {
        $user = $this->userRepository->findUser(UserId::fromInt($editUser->id));

        if (null === $user) {
            throw UserNotExists::id($editUser->id);
        }

        if ($editUser->isResetKey) {
            $user->resetKey();
        }

        $user->changeEmail(Email::fromString($editUser->email));
        $user->changeRoles($editUser->roles);

        $this->userRepository->saveUser($user);
    }

    /**
     * @return UserView[]
     */
    public function users(): array
    {
        return $this->userViewRepository->findUserViews();
    }
}

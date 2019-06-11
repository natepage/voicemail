<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Intents;

use App\Factories\Interfaces\UserFactoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

final class SignInConfirmIntent extends AbstractSignedInIntent
{
    /** @var \App\Factories\Interfaces\UserFactoryInterface */
    private $userFactory;

    /** @var \App\Repositories\Interfaces\UserRepositoryInterface */
    private $userRepository;

    /**
     * SignInConfirmIntent constructor.
     *
     * @param \App\Factories\Interfaces\UserFactoryInterface $userFactory
     * @param \App\Repositories\Interfaces\UserRepositoryInterface $userRepository
     */
    public function __construct(UserFactoryInterface $userFactory, UserRepositoryInterface $userRepository)
    {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * Get intent name.
     *
     * @return string
     */
    public function getIntentName(): string
    {
        return 'sign_in_confirm';
    }

    /**
     * Handle for children intent once user is signed in.
     *
     * @return void
     */
    protected function doHandle(): void
    {
        $googleUser = $this->getUser();
        $user = $this->userRepository->findOneByEmail($googleUser->getEmail());

        // User already exists in db
        if ($user !== null) {
            $this->reply(\sprintf('Welcome back %s', $user->getGivenName()));

            return;
        }

        // Create new user in db
        try {
            $user = $this->userFactory->create($googleUser->toArray());
            $this->userRepository->save($user);
        } catch (\Exception $exception) {
            $this->logger->error(\sprintf('Unable to create User: %s', $exception->getMessage()));

            $this->reply('Sorry an error occurred while saving your information, please retry later');

            return;
        }

        $this->reply(\sprintf(
            'Hey %s! Thank you, I\'m glad to count you as one of my members',
            $user->getGivenName()
        ));
    }
}

<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Actions;

use Dialogflow\Action\User as BaseUser;

final class User extends BaseUser
{
    /** @var null|string */
    private $idToken;

    /**
     * User constructor.
     *
     * @param mixed[] $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->idToken = $data['idToken'] ?? null;
    }

    /**
     * Get idToken.
     *
     * @return null|string
     */
    public function getIdToken(): ?string
    {
        return $this->idToken;
    }
}

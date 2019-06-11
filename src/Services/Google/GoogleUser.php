<?php
declare(strict_types=1);

namespace App\Services\Google;

final class GoogleUser
{
    /** @var mixed[] */
    private $data;

    /**
     * GoogleUser constructor.
     *
     * @param mixed[] $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get account id.
     *
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->data['sub'];
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->data['email'];
    }

    /**
     * Get family name.
     *
     * @return string
     */
    public function getFamilyName(): string
    {
        return $this->data['family_name'];
    }

    /**
     * Get given name.
     *
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->data['given_name'];
    }

    /**
     * Get locale.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->data['locale'];
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->data['name'];
    }
}

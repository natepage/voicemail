<?php
declare(strict_types=1);

namespace App\Services\Dialogflow\Actions\Questions;

use Dialogflow\Action\Interfaces\QuestionInterface;

final class SignIn implements QuestionInterface
{
    /** @var null|string */
    private $context;

    /**
     * SignIn constructor.
     *
     * @param null|string $context
     */
    public function __construct(?string $context = null)
    {
        $this->context = $context;
    }

    /**
     * Render a single Rich Response item as array.
     *
     * @return null|mixed[]
     */
    public function renderRichResponseItem(): ?array
    {
        $out = [];

        $out['simpleResponse'] = ['textToSpeech' => 'PLACEHOLDER'];

        return $out;
    }

    /**
     * Render System Intent as array.
     *
     * @return null|mixed[]
     */
    public function renderSystemIntent(): ?array
    {
        $out = [];

        $out['intent'] = 'actions.intent.SIGN_IN';
        $out['data'] = [
            '@type' => 'type.googleapis.com/google.actions.v2.SignInValueSpec',
            'optContext' => $this->context
        ];

        return $out;
    }
}

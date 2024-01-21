<?php

namespace App\AI;

use Exception;
use OpenAI\Laravel\Facades\OpenAI;

class Chat
{
    private const MODEL = 'gpt-3.5-turbo';

    private const ROLE_USER = 'user';
    private const ROLE_SYSTEM = 'system';
    private const ROLE_ASSISTANT = 'assistant';

    protected array $messages = [];

    /**
     * @return array
     */
    public function messages(): array
    {
        return $this->messages;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function system(string $message): static
    {
        $this->push($message, self::ROLE_SYSTEM);

        return $this;
    }

    /**
     * @param string $message
     * @return string
     * @throws Exception
     */
    public function send(string $message): string
    {
        $this->push($message, self::ROLE_USER);

        $response = OpenAI::chat()->create(
            [
                'model'    => self::MODEL,
                'messages' => $this->messages
            ]
        )->choices[0]->message->content;

        if (!$response) {
            throw new Exception('Something went wrong');

        }

        $this->push($response, self::ROLE_ASSISTANT);

        return $response;
    }


    /**
     * Just an alias for send
     *
     * @param string $message
     * @return string
     * @throws Exception
     */
    public function replay(string $message): string
    {
        return $this->send($message);
    }

    /**
     * @param string $message
     * @param string $role
     * @return void
     */
    protected function push(string $message, string $role): void
    {
        $this->messages[] = [
            'role'    => $role,
            'content' => $message
        ];
    }
}

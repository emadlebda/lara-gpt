<?php

namespace App\Console\Commands;

use App\AI\Chat;
use Illuminate\Console\Command;
use function Laravel\Prompts\{info, intro, outro, spin, text};

class ChatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat {--system=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start a chat with OpenAI';

    private Chat $chat;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->chat = new Chat();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        intro('Welcome to OpenAI chat...');

        $chat = new Chat();

        if ($system = $this->option('system')) {
            $chat->system($system);
        }

        $question = text(
            label: 'What is your question for AI',
            required: true
        );

        $this->handleQuestion($question);

        while (!in_array($question = text('Do you want to respond?'), ['n', 'N', 'no', 'No', false])) {
            $this->handleQuestion($question);
        }

        outro('Conversation is over...');
    }

    /**
     * @param string $question
     * @return void
     */
    protected function handleQuestion(string $question): void
    {
        $response = spin(fn() => $this->chat->send($question), 'Sending request...');

        info($response);
    }
}

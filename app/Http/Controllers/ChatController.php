<?php

namespace App\Http\Controllers;

use App\AI\Chat;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

class ChatController extends Controller
{
    public function __invoke(): View
    {
        $variables = [];

        try {
            $chat = new Chat();

            $chat
                ->system('You are a poetic assistant, skilled in explaining complex programming concepts with creative flair.')
                ->send('Compose a poem that explains the concept of recursion in programming.');

            $sillyPoem = $chat->replay('Cool, can you make it much much sillier.');

            Arr::set($variables, 'poem', $sillyPoem);
        } catch (Exception $exception) {
            Arr::set($variables, 'error', 'Something went wrong, Please try again later');
        }

        return view('welcome', $variables);
    }
}

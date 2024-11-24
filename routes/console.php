<?php

use App\Models\Task;
use App\Notifications\GenericNotification;
use App\Notifications\ReminderNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('send:reminder', function () {
    $tasks = Task::with('user')->where('reminder_at', now())->get();

    foreach ($tasks as $task) {

        if ($task->user->last_whatsapp_at->diffInHours(now()) > 24) {
            $task->user->notify(new ReminderNotification());
        } else {
            $message = "Lembrete de tarefa: {$task->description}";
            $task->user->notify(new GenericNotification($message));
        }
    }

})->everyMinute();

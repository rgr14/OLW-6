<?php

namespace App\Notifications;

use App\Notifications\Channels\WhatsAppChannel;
use App\Notifications\Channels\WhatsAppMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification
{
    use Queueable;

    private string $message = "Aqui estão os comandos que você pode usar para aproveitar ao máximo o assistente:

*!menu* - Exibe essa lista com todas as opções de comandos.
*!agenda* - Mostra as próximas tarefas e agendamentos que você tem programados.
*!insights* - Gera insights sobre suas tarefas dos últimos dias, ajudando você a identificar padrões oportunidades para melhorar sua produtividade.
*!update* - Atualizar uma determinada tarefa.

É só escolher o comando que precisa e eu cuido do resto ou me mandar qualquer coisa que eu te ajudo! 😁";

    /**
     * Create a new notification instance.
     */
    public function __construct(protected string $name, protected string $stripeLink)
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notification): WhatsAppMessage
    {
        return (new WhatsAppMessage())
            ->content($this->message);
    }
}

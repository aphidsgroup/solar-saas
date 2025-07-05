<?php

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    /**
     * The client instance.
     *
     * @var \App\Models\Client
     */
    protected $client;

    /**
     * Create a new notification instance.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Client Added: ' . $this->client->name)
            ->greeting('Hello ' . $notifiable->name)
            ->line('A new client has been added to the system.')
            ->line('Client Name: ' . $this->client->name)
            ->line('Client Type: ' . $this->client->client_type)
            ->line('Contact: ' . $this->client->phone . ($this->client->email ? ' / ' . $this->client->email : ''))
            ->action('View Client Details', url('/clients/' . $this->client->id))
            ->line('Thank you for using our CRM system!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'client_id' => $this->client->id,
            'client_name' => $this->client->name,
            'client_type' => $this->client->client_type,
            'message' => 'New client added: ' . $this->client->name
        ];
    }
    
    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'client_id' => $this->client->id,
            'client_name' => $this->client->name,
            'client_type' => $this->client->client_type,
            'icon' => 'users',
            'color' => 'green',
            'message' => 'New client added: ' . $this->client->name,
            'action_url' => '/clients/' . $this->client->id
        ];
    }
}

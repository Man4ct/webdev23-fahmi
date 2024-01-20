<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ArticleComment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleCommented extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected ArticleComment $comment)
    {
        //
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
            ->subject('Komentar baru artikel ' . $this->comment->article->title)
            ->greeting('Halo ' . $notifiable->name)
            ->line('Ada komentar baru pada artikel ' . $this->comment->article->title)
            ->line('"' . $this->comment->content . '"')
            ->action('Lihat artikel', route('article.single', [
                'slug' =>
                    $this->comment->article->slug
            ]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'text' => 'Ada komentar baru pada artikel
            ' . $this->comment->article->title,
            'route' => 'article.single',
            'routeParam' => ['slug' => $this->comment->article->slug]
        ];
    }
}

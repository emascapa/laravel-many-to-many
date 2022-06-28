<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Post;

class PostCreatedMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        //
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.markdown.postcreated')
        ->from('noreply@pipipi.it')
        ->subject('Post created Succefully!')
        ->with([
            'title' => $this->post->title,

            'content' => $this->post->content,

            'date' => $this->post->date,

            'postUrl' => env('APP_URL') . ':8000' . '/admin/posts/' . $this->post->id,
        ]);

        //        return $this->from('noreply@pipipi.it')->subject('I like big hearts')->view('mail.games.created')
        //->with([
        //    'game_title' => $this->game->title
        //]);
    }
}

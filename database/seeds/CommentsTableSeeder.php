<?php

use App\Entities\Note\Note;
use App\Entities\User\User;
use Illuminate\Database\Seeder;
use App\Entities\Comment\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $created_commentator_user = User::where('email', 'lector@apibase.com')->first()->id;
        $created_note_commentary = Note::first()->id;
        $created_commentary = Comment::create([
            'user_id' => $created_commentator_user,
            'note_id' =>$created_note_commentary,
            'body' => 'es un comentario',
            'nick_name' => 'soy Yo',
            'status' => 'aprobado'
        ]);

    }
}

<?php

use App\Entities\Note\Note;
use App\Entities\User\User;
use App\Entities\Note\Category;
use Illuminate\Database\Seeder;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $CATEGORIES = Category::where('description', 'Covid')->first();
        if (is_null($CATEGORIES)) {
            $CATEGORIES = Category::create([
                'description' => "Covid",
                'status' => true
            ]);
        }
        $created_note_user = User::where('email', 'redactor@apibase.com')->first();
        if (isset($created_note_user)) {
        $created_note_user = Note::create([
            'user_id' => $created_note_user->id,
            'category_id' => $CATEGORIES->id,
            'title' => 'Pandemia',
            'location' => 'Rosario, Santa Fe',
            'body' => 'La provincia de Santa Fe reportó 386 nuevos casos de Covid, 143 de ellos en Rosario'
        ]);}
    }
}
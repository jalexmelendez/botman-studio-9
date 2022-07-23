<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class ExampleConversation extends Conversation
{
    protected $firstname;

    protected $email;

    public function run()
    {
        $this->askName();
    }

    public function askName()
    {
        $this->ask('Hello! What is your firstname?', function(Answer $answer) {
            // Save result
            $this->firstname = $answer->getText();

            $this->say('Nice to meet you '.$this->firstname);
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('One more thing - what is your email?', function(Answer $answer) {
            // Save result
            $this->email = $answer->getText();

            $this->say('We will contact you at your email: '.$this->email);
            $this->say('Bye '.$this->firstname.'!');
        });
    }
}
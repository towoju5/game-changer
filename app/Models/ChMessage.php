<?php

namespace App\Models;

use Chatify\Traits\UUID;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class ChMessage extends Model
{
    use UUID;

    public function save(array $options = [])
   {
    static::saving(function($message){
      $fromId =  $message->from_id;
      $toId =  $message->to_id;
      $body = $message->body;

      $user =  User::find($fromId);
      $role = $user->getRoleNames()->first();
      if($role == 'User'){

        $administrator =  User::find($toId);
        $data = ['name' => $administrator->first_name, 'email' => $administrator->email];

        Mail::send([], [], function($message) use($data){
            $message->to($data['email'], $data['name'])->subject("You have new Message: Please take action on it");
            $message->from(config('mail.from.address'),config('mail.from.name'));
            $message->html(get_settings('email_for_new_incomming_message'));
        });

      }
    });
      
    $result = parent::save($options);
    return $result;
   }
}

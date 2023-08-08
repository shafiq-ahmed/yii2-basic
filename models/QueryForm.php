<?php

namespace app\models;

use yii\db\ActiveRecord;

class QueryForm extends ActiveRecord
{
    public $attachment="none";
 public function rules()
 {
     return [
         // name, phone number and query are required
         [['name', 'phone_number',  'query'], 'required'],
         //name can be at least of 3 character and max 50 characters. The upper limit
         //is taken from the database
         ['name','string','length'=>[3,50]],
         // email has to be a valid email address
         ['email', 'email'],
         //subject can be empty or max 80 in length. subject will take a string input. Max length is taken from database
         ['subject','string','length'=>[0,80]],
         // verifyCode needs to be entered correctly
         //ToDo
         //Phone numbers either 11 or 13 digits of length have to be accepted
         ['phone_number','match', 'pattern'=>'/^\d{13}$/'],

         ['attachment','string','length'=>[0,100]]
     ];
 }
}
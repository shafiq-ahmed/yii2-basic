<?php

namespace app\models;

use yii\db\ActiveRecord;

class QueryForm extends ActiveRecord
{
 public function rules()
 {
     return [
         // name, phone number and query are required
         [['name', 'phone_number',  'query'], 'required'],
         // email has to be a valid email address
         ['email', 'email'],
         // verifyCode needs to be entered correctly
         ['phone_number','match', 'pattern'=>'/^\d{13}$/'],
     ];
 }
}
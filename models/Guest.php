<?php

namespace app\models;


use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;


/**
 * This is the model class for table "guests".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $email
 * @property string $phone
 * @property string|null $country
 */


class Guest extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'guests';
    }

    public function rules()
    {
        return [
            [['name', 'surname', 'phone'], 'required'],
            [['name', 'surname', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['country'], 'string', 'max' => 50],
            [['phone', 'email'], 'unique'],
            ['phone', 'match', 'pattern' => '/^\+\d{1,15}$/', 'message' => 'Phone number must be in international format with a leading +.'],
        ];
    }


    public function validateCountry($attribute)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
    
        try {
            $number = $phoneUtil->parse($this->phone, null);
            
            if (!$phoneUtil->isValidNumber($number)) {
                $this->addError($attribute, 'Неверный номер телефона.');

                return;
            }
            $countryCode = $number->getCountryCode();
            $this->country = $phoneUtil->getRegionCodeForCountryCode($countryCode);
        } catch (NumberParseException $e) {
            $this->addError($attribute, 'Неверный формат номера телефона.');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'email' => 'Email',
            'phone' => 'Телефон',
            'country' => 'Страна',
        ];
    }
    
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $sum
 * @property string $card_no
 * @property integer $exp_month
 * @property integer $exp_year
 * @property integer $cvv
 * @property string $city
 * @property string $state
 * @property string $address
 * @property string $zip_code
 */
class Orders extends \yii\base\Model
{
    public $name;
    public $last_name;
    public $phone;
    public $email;
    public $sum;
    public $exp_month;
    public $exp_year;
    public $cvv;
    public $city;
    public $state;
    public $address;
    public $zip_code;
    public $hash;
    public $card_no;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum', 'exp_month', 'exp_year', 'cvv', 'name', 'last_name', 'email', 'city', 'phone', 'card_no', 'state', 'address', 'zip_code'], 'required'],
//            [['sum'], 'number'],
            [['sum'], 'number', 'min' => 0.01],
            [['exp_month', 'exp_year', 'cvv'], 'integer'],
            [['name', 'last_name', 'email', 'city'], 'string', 'max' => 64],
            [['email'], 'email'],
            [['card_no'], 'string', 'max' => 16],
            [['phone'], 'string', 'min' => 16, 'max' => 16],
            [['state'], 'string', 'min' => 2, 'max' => 2],
            [['address'], 'string', 'max' => 255],
            [['zip_code'], 'string', 'max' => 5],
            ['hash', 'checkHash'],
            ['exp_year', 'checkDate', 'params' =>['month' => 'exp_month']],
        ];
    }

    public function checkHash($attribute, $params){
        $hash = sha1($this->name
                .$this->last_name
                .$this->phone
                .$this->email
                .$this->sum
                .$this->card_no
                .$this->exp_month
                .$this->exp_year
                .$this->cvv
                .$this->city
                .$this->state
                .$this->address
                .$this->zip_code);
        if($hash != $this->hash){
            $this->addError('hash', 'Error hash');
        }
    }

    public function checkDate($attribute, $params){
        if($this->{$attribute} < date('y')){
            $this->addError($attribute, 'Year error');
        } elseif($this->{$params['month']} < date('m')) {
            $this->addError($params['month'], 'Month error');
        }
    }

//    public function beforeSave($insert) {
//        parent::beforeSave($insert);
//        $this->hash = sha1($this->name
//                .$this->last_name
//                .$this->phone
//                .$this->email
//                .$this->sum
//                .$this->exp_month
//                .$this->exp_year
//                .$this->cvv
//                .$this->city
//                .$this->state
//                .$this->address
//                .$this->zip_code);
//        $curl = new \linslin\yii2\curl\Curl();
//        $curl->setOption(CURLOPT_POSTFIELDS, http_build_query($this->attributes));
//        $curl->setOption(CURLOPT_RETURNTRANSFER, 1);
//        $response = $curl->post('http://test_api.local/', FALSE);
//        print_r($response);
//        return false;
//    }
        
}

<?php

namespace App\Validation;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoginValidator
 * @package App\Validation
 */
class LoginValidator
{
    private $data;
    public $errors = [];
    public $email;
    public $password;
    private static $fields = ["email", "password"];

    /**
     * LoginValidator constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->data = $request->request->all();
    }

    /**
     * @return void
     */
    public function validateForLogin()
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)){
                trigger_error("$field is not present in data");
                return;
            }
            $methodName = 'validate';
            $this->{$methodName . ucfirst($field)}();
        }

    }


    private function validateEmail(): string
    {
        $this->email = trim($this->data['email']);

        if (empty($this->email)){
            $this->addError('email', 'lütfen bir email giriniz');
        } else{
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                $this->addError('email', 'geçerli bir email giriniz');
            }
        }
        return $this->email;
    }

    private function validatePassword(): string
    {
        $this->password = trim($this->data['password']);

        if (empty($this->password)){
            $this->addError('password', 'parolanızı giriniz');
        } else{
            if (!preg_match('/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])[a-zA-Z0-9]{4,}$/', $this->password)){
                $this->addError('password', 'parolanızı doğru giriniz');
            }
        }
        return $this->password;
    }

    private function addError($key, $value)
    {
        $this->errors[$key] = $value;
    }

}
<?php


namespace App\Validation;


use Symfony\Component\HttpFoundation\Request;


/**
 * Class RegisterValidator
 * @package App\Validation
 */
class RegisterValidator
{
    private $data;
    public $errors=[];
    public $name;
    public $email;
    public $password;
    public $confirmPassword;
    private static $fields = ["name", "email", "password", "confirmPassword"];


    /**
     * RegisterValidator constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->data = $request->request->all();
    }


    public function validateForRegister()
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)){
                trigger_error("$field is not present in data", E_USER_ERROR);
            }
            $methodName = 'validate';
            $this->{$methodName.ucfirst($field)}();
        }
    }

    private function validateName(): string
    {
        $this->name = trim($this->data['name']);

        if (empty($this->name)){
            $this->addError('name', 'lütfen isminizi giriniz.');
        }else{
            if (!preg_match('/^[a-zA-Z\s]+$/', $this->name)){
                $this->addError('name', 'İsminiz sayı ve noktalama işareti içeremez.');
            }
        }
        return $this->name;
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
                $this->addError('password', 'parolanız en az bir büyük harf, bir küçük harf ve sayı içermelidir.');
            }
        }
        return $this->password;
    }

    private function validateConfirmPassword(): string
    {
        $this->confirmPassword = trim($this->data['confirmPassword']);

        if (empty($this->confirmPassword)){
            $this->addError('confirmPassword', 'parolanızı giriniz');
        } else{
            if (!preg_match('/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])[a-zA-Z0-9]{4,}$/', $this->confirmPassword)){
                $this->addError('confirmPassword', 'parolanız en az bir büyük harf, bir küçük harf ve sayı içermelidir.');
            }
        }
        return $this->confirmPassword;
    }

    private function addError($key, $value)
    {
        $this->errors[$key] = $value;
    }

}
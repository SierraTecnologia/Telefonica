<?php
/**
 * Serviço referente a linha no banco de dados
 */

namespace Telefonica\Services;

use Telefonica\Models\Digital\Account;
use Telefonica\Models\Digital\Password;

/**
 * 
 */
class SocialService
{

    protected $config;

    public function __construct($config = false)
    {
        // if (!$this->config = $config) {
        //     $this->config = \Illuminate\Support\Facades\Config::get('sitec.sitec.models');
        // }
    }

    public function setAccount($service, $email = null, $password = null, $username = null, $pk = null)
    {
        $classIntegration = '\Integrations\Connectors\\'.$service.'\\'.$service;
        if (!class_exists($classIntegration)) {
            dd('Erro aqui $classIntegration');
        }

        $account = null;
        if (!empty($pk)) {
            $account =  Account::where(
                [
                    'pk' => $pk,
                    'integration_id' => $classIntegration::$ID,
                ]
            )->first();
        } else if (!empty($username)) {
            $account =  Account::where(
                [
                    'username' => $username,
                    'integration_id' => $classIntegration::$ID,
                ]
            )->first();
        } 

        if (!$account){
            $account = Account::create(
                [
                    'email' => $email,
                    'pk' => $pk,
                    'username' => $username,
                    'password' => $password,
                    'integration_id' => $classIntegration::$ID,
                ]
            );
        }else {
            if (!empty($username)) {
                $account->username = $username;
            }
            if (!empty($pk)) {
                $account->pk = $pk;
            }
            if (!empty($password)) {
                $account->password = $password;
            }
            if (!empty($email)) {
                $account->email = $email;
            }
            $account->save();
        }
        return $account;
    }

    public function savePassword($value, $userAccount = false, $date = false)
    {
        if (!$date) {
            $date = now();
        }
        $pass = Password::firstOrCreate([
            'value' => $value,
            'date' => $date
        ]);
        if ($userAccount) {
            $pass->accounts()->attach($userAccount);
        }

        return $pass;
    }

}

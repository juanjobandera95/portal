<?php


namespace App\Core;



use App\Exception\NotFoundException;
use Exception;

/**
 * Class Security
 * @package App\Core
 */
class Security
{

    /**
     * @param string $minRole
     * @return bool
     * @throws NotFoundException
     */
    public static function isUserGranted(string $minRole): bool
    {
        /**
         *
         * detecta el role
         *
         */

        if ($minRole == 'ROLE_ANONYMOUS')
            return true;
        $user = App::get('user');

        if ($user === null) {
            App::get('router')->redirect('/login');
            return false;
        } else {
            $userRole = $user->getRole();
            $roles = App::get("config")["security"]["roles"];
            $userRoleValue = $roles[$userRole];//ROLE_ADMIN
            $minRoleValue = $roles[$minRole];//ROLE_USER

            return ($userRoleValue >= $minRoleValue);
        }
    }


    /**
     * @param $passwd
     * @return string
     */
    public static function encrypt($passwd): string
    {
        /**
         * encripta la contraseña
         *
         */
        $hash = password_hash($passwd, PASSWORD_BCRYPT);
        return $hash;

    }

    /**
     * @param string $passwd
     * @param string $passwdPost
     * @return bool
     */
    public static function checkPassword(string $passwd, string $passwdPost): bool
    {
        /**
         * compara la contraseña de la bbdd con la introducida en el formulario
         *
         */
        return password_verify($passwdPost, $passwd);
    }

    /**
     * @param string $passwd
     * @return bool
     */
    public static function checkPasswordPolicy(string $passwd): bool
    {
        /**
         * valida la contraseña con la normativa establecida
         *
         */
        if (strlen($passwd) < 6)
            return false;
        elseif (!preg_match('/[A-Za-z0-9]/', $passwd))
            return false;

        return true;
    }
}
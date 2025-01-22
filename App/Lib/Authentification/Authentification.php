<?php
namespace App\Lib\Authentification;
class Authentification
{


    function base64_url_encode(string $text): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }
    public function Gen_jwt(int $userId): string
    {

        $passphrase = $_ENV['DB_PASSPHRASE_JWT'];
        $header = [
            "alg" => "HS512", // security risk
            "typ" => "JWT",   // security risk
        ];
        $header = $this->base64_url_encode(json_encode($header));
        $payload = [
            "userId" => $userId,

            "iat" => time(),      // iat means Issued at  
            "exp" => time() + 3600
        ];
        $payload = $this->base64_url_encode(json_encode($payload));
        $signature = $this->base64_url_encode(hash_hmac('sha512', "$header.$payload", $passphrase, true));
        $jwt = "$header.$payload.$signature";
        #var_dump($jwt) ; // permet de vardump lors de l'exec de fonction
        return $jwt;
    }
    public function Validate_jwt(string $jwt)
    {


        $jwt_list = explode(".", $jwt);
        $passphrase = $_ENV["DB_PASSPHRASE_JWT"];
        $expected_signature = $this->base64_url_encode(hash_hmac('sha512', "$jwt_list[0].$jwt_list[1]", $passphrase, true));
        if ($jwt_list[2] == $expected_signature) {
            return [
                "Istrue" => True,
                "Jwt" => $this->Decode_jwt($jwt_list)
            ];
        } else {
            $_SESSION = array();
            session_regenerate_id(true);
            session_destroy();
            return [
                "Istrue" => False,
                "Jwt" => Null
            ];
        }
    }
    public function Decode_jwt($jwt)
    {
        if (count($jwt) !== 3) { // On verifie la structure du JWT et on l'explose si c'est pas fait
            $jwt = explode(".", $jwt);
        }
        $decodedHeader = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $jwt[0])), true);
        $decodedPayload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $jwt[1])), true);
        if ($decodedPayload["exp"] >= time()) {
            return [
                "dchd" => $decodedHeader,
                "dcpl" => $decodedPayload
            ]

            ;
        } else {
            $_SESSION = array();
            session_regenerate_id(true);
            session_destroy();
            return Null; // token expired
        }
    }
    public function genJwtForEmailValidation(int $userId)
    {
        $passphrase = $_ENV['DB_PASSPHRASE_JWT'];
        $header = [
            "alg" => "HS512", // security risk
            "typ" => "JWT",   // security risk
        ];
        $header = $this->base64_url_encode(json_encode($header));
        $payload = [
            "userId" => $userId,
            "iat" => time(),      // iat means Issued at  
            "exp" => time() + 900 #15 min pour valider un mail
        ];
        $payload = $this->base64_url_encode(json_encode($payload));
        $signature = $this->base64_url_encode(hash_hmac('sha512', "$header.$payload", $passphrase, true));
        $jwt = "$header.$payload.$signature";
        #var_dump($jwt) ; // permet de vardump lors de l'exec de fonction
        return $jwt;
    }
}
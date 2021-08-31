<?php
namespace App\Lib\Encryptor;

interface EncryptorInterface
{
    public function encrypt(string $input): string;
    public function decrypt(string $input): string;
}

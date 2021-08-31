<?php
namespace App\Lib\Encryptor;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class LaravelEncryptor implements EncryptorInterface
{

    public function encrypt(string $input): string
    {
        $data = Storage::disk('public')->get($input);
        if (!Storage::disk('public')->exists('outputs')){
            Storage::disk('public')->makeDirectory('outputs');
        }
        $out = 'outputs/'.basename($input);
        Storage::disk('public')->put($out, Crypt::encrypt($data));
        return $out;
    }

    public function decrypt(string $input): string
    {
        $data = Storage::disk('public')->get($input);
        if (!Storage::disk('public')->exists('outputs')){
            Storage::disk('public')->makeDirectory('outputs');
        }
        $out = 'outputs/'.basename($input);
        Storage::disk('public')->put($out, Crypt::decrypt($data));
        return $out;
    }
}

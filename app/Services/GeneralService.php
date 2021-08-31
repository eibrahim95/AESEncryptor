<?php
namespace App\Services;
use App\Jobs\DecryptFileJob;
use App\Jobs\EncryptFileJob;
use App\Models\UserFile;
use Illuminate\Support\Facades\Storage;

class GeneralService
{

    public function getCurrentUser(){
        $token = request()->header('token');
        return UserFile::where(['token'=>$token])->orderByDesc('updated_at')->first();
    }

    public function useCurrentFile()
    {
        $user_file = $this->getCurrentUser();
        Storage::disk('public')->delete($user_file->path);
        Storage::disk('public')->move($user_file->output_path, $user_file->path);
        $user_file->update(['output_path'=>null, 'status'=>null]);
        return $user_file->fresh();
    }

    public function changeCurrentFile()
    {
        $token = request()->header('token');
        $user_files = UserFile::where(['token'=>$token]);
        Storage::disk('public')->delete(...$user_files->pluck('path'));
        Storage::disk('public')->delete(...$user_files->pluck('output_path'));
        $user_files->delete();
    }

    public function addFile(array $data, array $files)
    {
        $token = request()->header('token');
        $file = $files['input'];
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $path = $file->store('inputs', ['disk'=>'public']);
        return UserFile::create([
            'path' => $path,
            'original_name' => $name,
            'extension' => $extension,
            'size' => $size,
            'token'=>$token
        ]);
    }

    public function encryptCurrentFile()
    {
        $user_file = $this->getCurrentUser();
        EncryptFileJob::dispatch($user_file);
        $user_file->update(['status'=>'inQueue']);
        return $user_file->fresh();
    }

    public function decryptCurrentFile()
    {
        $user_file = $this->getCurrentUser();
        DecryptFileJob::dispatch($user_file);
        $user_file->update(['status'=>'inQueue']);
        return $user_file->fresh();
    }

}

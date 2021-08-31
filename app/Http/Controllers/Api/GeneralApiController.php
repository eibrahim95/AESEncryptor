<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileUploadRequest;
use App\Jobs\DecryptFileJob;
use App\Jobs\EncryptFileJob;
use App\Models\UserFile;
use App\Services\GeneralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GeneralApiController extends Controller
{
    private $generalService;

    public function __construct(GeneralService $generalService)
    {
        $this->generalService = $generalService;
    }

    /**
     * @return array
     */
    public function lastFile(): array
    {
        $user_file = $this->generalService->getCurrentUser();
        return [
            'status' => 1,
            'selectedFile' => $user_file
        ];
    }

    /**
     * @return array
     */
    public function useFile(): array
    {
        $user_file = $this->generalService->useCurrentFile();
        return [
            'status' => 1,
            'selectedFile' => $user_file
        ];
    }

    /**
     * @return array
     */
    public function changeFile(): array
    {
        $this->generalService->changeCurrentFile();
        return [
            'status' => 1,
            'selectedFile' => null
        ];
    }

    /**
     * @param FileUploadRequest $request
     * @return array
     */
    public function uploadFile(FileUploadRequest $request): array
    {
        $user_file = $this->generalService->addFile($request->all(), $request->allFiles());
        return [
            'status' => 1,
            'selectedFile' => $user_file
        ];
    }

    /**
     * @return array
     */
    public function encryptFile(): array
    {
        $user_file = $this->generalService->encryptCurrentFile();
        return [
            'status'=> 1,
            'selectedFile' => $user_file
        ];
    }

    /**
     * @return array
     */
    public function decryptFile(): array
    {
        $user_file = $this->generalService->decryptCurrentFile();
        return [
            'status'=> 1,
            'selectedFile' => $user_file
        ];

    }
}

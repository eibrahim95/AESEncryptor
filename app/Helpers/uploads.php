<?php
if (! function_exists('max_file_upload_in_bytes')) {
    function max_file_upload_in_bytes()
    {
        $return_bytes = function ($val) {
            $val = trim($val);
            $last = strtolower($val[strlen($val) - 1]);
            $val = substr($val,0, (int) strlen($val) - 1);
            switch ($last) {
                case 'g':
                    $val *= 1024;
                case 'm':
                    $val *= 1024;
                case 'k':
                    $val *= 1024;
            }
            return $val;
        };
        //select maximum upload size
        $max_upload = $return_bytes(ini_get('upload_max_filesize'));
        //select post limit
        $max_post = $return_bytes(ini_get('post_max_size'));
        //select memory limit
        $memory_limit = $return_bytes(ini_get('memory_limit'));
        // return the smallest of them, this defines the real limit
        return min($max_upload, $max_post, $memory_limit);
    }
}
if (! function_exists('formatSizeUnits')) {
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
if (! function_exists('max_file_upload')){
    function max_file_upload(){
        return formatSizeUnits(max_file_upload_in_bytes());
    }
}

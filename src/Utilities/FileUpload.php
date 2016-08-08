<?php

namespace Services;

class FileUpload
{
    public function upload($file, $allowedExtensions, $path, $fileName = '')
    {
        $fileActualExtension = strtolower($file->getClientOriginalExtension());
        if (!$this->validateExtension($fileActualExtension, $allowedExtensions)) {
            return array(
                'status' => false,
                'message' => 'File Extension deos not match allowed extensions'
            );
        }
        
        if (empty($fileName)) {
            $fileName = sha1(time()) . "." . $file->getClientOriginalExtension();
        }

        try {
            $file->move($path, $fileName);
            return array(
                'status' => true,
                'message' => 'File Upload was successful',
                'fileName' => $fileName
            );
        } catch (Exception $e) {
            return array(
                'status' => false,
                'message' => 'ERROR: '.$e->getMessage()
            );
        }
    }
    private function validateExtension($fileActualExtension, $allowedExtensions)
    {
        if (!in_array($fileActualExtension, $allowedExtensions)) {
            return false;
        }
        return true;
    }
}

<?php
declare(strict_types=1);

namespace App\Img;

use App\Config\Env;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Common\Exceptions\InvalidArgumentTypeException;

class BlobUpload {
    protected $connectionString;
    protected $containerName;

    // 
    public function __construct() {
        $this->connectionString = "DefaultEndpointsProtocol=https;AccountName=" .
            Env::get('AZURE_BLOB_USER') .
            ";AccountKey=".
            Env::get('AZURE_BLOB_KEY');
        
        $this->containerName = Env::get('AZURE_CONTAINER');
    }


    
    public function upload(string $fileToUpload) : void {
        $blobClient = BlobRestProxy::createBlobService($this->connectionString);

        if (! file_exists($fileToUpload))
            throw new InvalidArgumentTypeException("File not found");

        # Upload file as a block blob
        $content = fopen($fileToUpload, "r");

        //Upload blob
        try {
            $blobClient->createBlockBlob($this->containerName, $fileToUpload, $content);
        } catch(ServiceException $e) {
            throw $e;
        }
    }

}
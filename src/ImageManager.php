<?php
require_once '../../vendor/autoload.php'; // AWS SDK
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class ImageManager {
    private $s3;

    public function __construct() {
        $this->s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'eu-north-1', // Replace with your region
            'credentials' => [
                'key'    => 'AKIAVY2PG4Z3ICVBOCOW', // Replace with your AWS access key
                'secret' => 'oyPiDN865uN7Gwlclz04SQlGTjUk5ztlt9aHKtVu', // Replace with your AWS secret key
            ],
        ]);
    }

    public function uploadToS3($bucket, $filePath, $key) {
        try {
            $this->s3->putObject([
                'Bucket'     => $bucket,
                'Key'        => $key,
                'SourceFile' => $filePath,
                'ACL'        => 'private', // Set permissions
            ]);

            return true;
        } catch (AwsException $e) {
            echo "Error uploading file to S3: " . $e->getMessage();
            return false;
        }
    }
}
?>

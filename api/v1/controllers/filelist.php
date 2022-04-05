<?php
require 'libs/vendor/autoload.php'; // initialize composer library

use Aws\S3\S3Client;

/**
 * 
 */
class Filelist extends Controller
{

    private $client;
    private $spaceApi;
    private $spaceApiEndpoint;
    private $spaceSecret;
    private $spaceName;
    private $cooldown;
    function __construct()
    {
        parent::__construct();
        $this->spaceApi = "EVF5FIEJ4NOMXIZ4GVBB";
        $this->spaceSecret = "RT3Fv6EQFF3YrLoR9w81nddIUgV20qEN6thvWjsh6Rk";
        $this->spaceApiEndpoint = "https://nyc3.digitaloceanspaces.com";
        $this->spaceName = "myan-movie";
        $this->cooldown = '+60 minutes';
        $this->client = new Aws\S3\S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'endpoint' => $this->spaceApiEndpoint,
            'credentials' => [
                'key'    => $this->spaceApi,
                'secret' => $this->spaceSecret,
            ],
        ]);
    }









    public function index()
    {
        $this->responseapi->errormsg = 'something went wrong ..... !';
        $this->responseapi->response('error/index', true);
    }

    public function getfilelist()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');




        $filelist = array();
        try {
            $objects = $this->client->listObjects([
                'Bucket' => $this->spaceName,
            ]);

            foreach ($objects['Contents'] as $obj) {

                $filelist[] = $obj['Key'];
            }


            $this->responseapi->data = $filelist;
        } catch (Exception $e) {
            $this->responseapi->data = $e->getMessage();
        }

        $this->responseapi->response('filelist/get_filelist', true);
    }

    public function getlink()
    {
        $api = new Api();
        $api->accept_header('POST');
        $api->check_method('POST');

        //$json_data = json_decode(file_get_contents("php://input"),true);
        $fileName = empty($_POST['filename']) ? null : $_POST['filename'];
        //$fileName = "Series/ALoveSoBeautiful/aLoveSoBeautifulEp14720p.mp4";

        // get file
        /*
        $cmd = $this->client->getCommand('GetObject', [
            'Bucket' => $this->spaceName,
            'Key'    => $fileName
        ]);
        */
        // generate one time link for 1 minutes
        /*
        try {
            $request = $this->client->createPresignedRequest($cmd, $this->cooldown);
            $presignedUrl = (string) $request->getUri();
            $this->responseapi->data = $presignedUrl;
        } catch (Exception $e) {
            $this->responseapi->data = $e->getMessage();
        }
        */
        $this->responseapi->data = $fileName;

        $this->responseapi->response('filelist/get_link', true);
    }
}

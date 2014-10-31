<?php
/**
 * AkabeiJSON
 *
 * Akabei Json API 
 * This library is licensed under the GPL
 *
 * Copyright (c) 2011 - Manuel Tortosa <manutortosa[at]chakra-project[dot]org>
 **/

/**
 * This class defines a remote interface for fetching data
 * from Akabei using JSON formatted elements.
 * @package rpc
 * @subpackage classes
 **/
class AkabeiJSON {
    private $exposed_methods = array('list_files');
    
    /**
     * Handles post data, and routes the request.
     * @param string $post_data The post data to parse and handle.
     * @return string The JSON formatted response data.
     **/
    public function handle($http_data) {
        // handle error states
        if ( !isset($http_data['type']) || !isset($http_data['arg']) ) {
            return $this->json_error('No request type/data specified.');
        }
        // do the routing
        if ( in_array($http_data['type'], $this->exposed_methods) ) {
            // ugh. this works. I hate you php.
            $json = call_user_func(array(&$this,$http_data['type']),
                $http_data['arg']);
            // allow rpc callback for XDomainAjax
            if ( isset($http_data['callback']) ) {
                // it is more correct to send text/javascript
                // content-type for jsonp-callback
                header('content-type: text/javascript');
                return $http_data['callback'] . "({$json})";
            }
            else {
                // set content type header to app/json
                header('content-type: application/json');
                return $json;
            }
        }
        else {
            return $this->json_error('Incorrect request type specified.');
        }
    }

    /**
     * Returns a JSON formatted error string.
     *
     * @param $msg The error string to return
     * @return mixed A json formatted error response.
     **/
    private function json_error($msg){
        // set content type header to app/json
        header('content-type: application/json');
        return $this->json_results('error',$msg);
    }

    /**
     * Returns a list of files in a given path
     * @param $directory The target directory
     **/
    private function listfiles($directory,$arch){
        $d = "$directory/$arch";
        $results = array();
        $res = array();
        $handler = opendir($d);
        while ($file = readdir($handler)){
            if ($file != "." && $file != ".."){
            $res[] = $file;
            }
        }
        closedir($handler);
        sort($res);
        foreach ($res as $file) {
            // Get the file attributes
            $cleanname = str_replace("-$arch.cb","",$file);
            $onlyname = implode("-",explode("-",$cleanname,-2));
            $vers = str_replace("$onlyname-","",$cleanname);
            $version = reset(explode("-",$vers));
            $revision = end(explode("-",$vers));
            $size = @filesize("$d/$file");
            $date = @filemtime("$d/$file");
            $results[] = array(
            "filename" => $file,
            "name" => $onlyname,
            "version" => $version,
            "release" => $revision,
            "size" => $size,
            "date" => date( "r", $date),
            );
        }
        return $results;
    }

    /**
     * Returns a JSON formatted result data.
     * @param $type The response method type.
     * @param $data The result data to return
     * @return mixed A json formatted result response.
     **/
    private function json_results($type,$data){
        return json_encode( array('type' => $type, 'results' => $data) );
    }

    /**
     * Returns the list of available bundles in a given architechture
     * @param $arch The target architechture
     **/
    private function list_files($arch) {
        if ($arch !== "i686" && $arch !== "x86_64") {
            return $this->json_error('Incorrect architechture.');
        }
        $results = $this->listfiles("../repo/bundles",$arch);
        if ($results) {
            return $this->json_results('list_files', $results);
        }
        else {
            return $this->json_error('No results found');
        }
    }
}

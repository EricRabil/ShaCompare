<?php

class IndexController implements \Steel\MVC\IController {

    private $model;
    private $bundle;
    private $dir1;
    private $dir2;

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
        $this->dir1 = $this->model->steel->config['sha-compare']['directory-one'];
        $this->dir2 = $this->model->steel->config['sha-compare']['directory-two'];
    }

    public function main($params) {
        if(is_dir($this->dir1) && is_dir($this->dir2)){
            $this->calculate_hashes();
        }else{
            $this->model->directory_one = [];
            $this->model->directory_two = [];
        }
    }
    
    private function calculate_hashes(){
        $shasum_dir1 = [];
        $shasum_dir2 = [];
        $contents_dir1 = scandir($this->dir1);
        foreach($contents_dir1 as $key => $name){
            $sum = sha1_file($this->dir1 . '/' . $name);
            $shasum_dir1[$name] = $sum;
        }
        unset($shasum_dir1['.']);
        unset($shasum_dir1['..']);
        unset($shasum_dir1['.DS_Store']);
        $contents_dir2 = scandir($this->dir2);
        foreach($contents_dir2 as $key => $name){
            $sum = sha1_file($this->dir2 . '/' . $name);
            $shasum_dir2[$name] = $sum;
        }
        foreach($shasum_dir2 as $name => $sum){
            if(!array_key_exists($name, $shasum_dir1)){
                unset($shasum_dir2[$name]);
            }
        }
        foreach($shasum_dir1 as $name => $sum){
            if(!array_key_exists($name, $shasum_dir2)){
                unset($shasum_dir1[$name]);
            }
        }
        $this->model->directory_one = $shasum_dir1;
        $this->model->directory_two = $shasum_dir2;
    }

}

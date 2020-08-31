<?php
/**
 * This class has the responsibility to handle JSON files
 */
class DataConnector {

    private $path_file;
    private $data;
    

    public function __construct(string $path_file = '')
    {
        $this->path_file = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Data' . DIRECTORY_SEPARATOR . $path_file;
    }

    public function fetchData() : array
    {
        $json_data =  file_get_contents($this->path_file, FILE_USE_INCLUDE_PATH);
        $json_data = !empty($json_data) ? $json_data : '{}';

        $this->data = json_decode($json_data, true);

        return $this->data;
    }

    public function prependData(array $data) {
        $this->fetchData();
        array_unshift($this->data, $data);
        $this->saveData($this->data);
    }

    private function saveData(array $data) {
        return file_put_contents($this->path_file, json_encode($data));
    }
}

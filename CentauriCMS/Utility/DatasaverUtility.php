<?php

namespace CentauriCMS\Centauri\Utility;

class DatasaverUtility {
    /**
     * Method to get a json file contents (and returning as decoded if found)
     * by its type and if necessary by its data array
     * it can also be used / seen as parameter array
     * 
     * @param string|null $type
     * @param array $data
     * @param boolean $returnArray
     * 
     * @return void
     */
    public function findDatasaverJson($type = NULL, $data = [], $returnArray) {
        if(is_null($type)) return NULL;

        $pathsUtility = new \CentauriCMS\Centauri\Utility\PathsUtility;
        $uri = $pathsUtility->rootPath();

        if($type == "elements") {
            $page = $data["page"];
            if(is_null($page)) return;

            $json = json_decode(file_get_contents($uri . "/CentauriCMS/Datasaver/json/$type.json"), $returnArray);
            if(!isset($json[$page["uid"]])) return [];
            return $json[$page["uid"]];
        }

        return json_decode(file_get_contents($uri . "/CentauriCMS/Datasaver/json/$type.json"), $returnArray);
    }

    /**
     * Method to find data by its type
     * in case the type isn't given it will return null
     * 
     * @param string|null $type
     * @param array $data
     * @param boolean $returnArray
     * 
     * @return null|array|json
     */
    public function findByType($type = NULL, $data = [], $returnArray = true) {
        if(is_null($type)) return NULL;
        return $this->findDatasaverJson($type, $data, $returnArray);
    }
}

<?php
namespace ColineServices;

use ColineServices\PMineAPI;
/**
 * Обновлялка для плагина
 *
 * @author Alexey
 */
class Updater {
    private  $owner, $plugin_id, $filepath;
    
    public function __construct(\pocketmine\plugin\Plugin $owner, $plugin_id, $filepath) {
        $this->owner = $owner ;
        $this->plugin_id = $plugin_id;
        $this->filepath = $filepath;
    }

    public function update(){
        if(is_dir($this->filepath)){
            $data = (new PMineAPI())->method("plugin.getLastVersion", ['plugin_id' => $this->plugin_id]);
            
            if($data['plugin_data']["version"] != $this->owner->getDescription()->getVersion()){
                foreach(glob("plugins/*".$this->owner->getDescription()->getName()."*.phar") as $phar){
                    unlink($phar);
                   
                }
                $plugin_path = "plugins/".$this->owner->getDescription()->getName()." v".$data['plugin_data']["version"].".phar";
                 file_put_contents($plugin_path, (new PMineAPI())->curl_get_contents($data["download_phar_url"]));
//                 $this->owner->getServer()->getPluginManager()->disablePlugin($this->owner);
//                 $this->owner->getServer()->getPluginManager()->loadPlugin($plugin_path);
            }
            
        }
    }
}

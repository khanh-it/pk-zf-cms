<?php
/**
 */
class Post_Bootstrap extends K111_Application_Module_Bootstrap
{
    /**
     * 
     */
    protected function _initABC() {
        return;
        echo ($this->getModuleName());
        
        $evtMan = K111_EventManager_EventManager::getInstance();
        
        $evtMan->trigger('Default.Module_Bootstrap');
    }
}
<?php
namespace CostAclNavigation\Navigation;

class MenuModulesNavigationMapper
{
    protected $source = null;
    
    
    /**
     * 
     * @param string $_module
     * estraggo le voci di menu del modulo associato
     */
    public function getPages(){
        return $this->source->getNavigatorByModule();
    }

    public function getSource()
    {
        return $this->source;
    }

    /**
     * 
     * @param object Tablegateway / Repository $source
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }
 

}

?>
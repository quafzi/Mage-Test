<?php

class Ibuildings_Test_Controller extends Mage_Core_Controller_Front_Action
{

    /**
     * Action predispatch
     *
     * Check customer authentication for some actions
     */
    public function preDispatch()
    {
        parent::preDispatch();
    }

    /**
     * Action postdispatch
     *
     * Remove No-referer flag from customer session after each action
     */
    public function postDispatch()
    {
        parent::postDispatch();
    }
    
    /**
     * undocumented function
     *
     * @return mixed
     * @author Alistair Stead
     **/
    public function __call($name, $args)
    {
    }
}

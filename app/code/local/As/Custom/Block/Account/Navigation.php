<?php
class As_Custom_Block_Account_Navigation extends Mage_Customer_Block_Account_Navigation
{
    public function removeLinkByName($name)
    {
        foreach ($this->_links as $k => $v) { //echo $v->getName().'<br/>' ;
            if ($v->getName() == $name) {
                unset($this->_links[$k]);
            }
        }

        return $this;
     }

}

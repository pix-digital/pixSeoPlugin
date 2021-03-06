<?php

/**
 * PluginPageSat
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PluginPageSat extends BasePageSat
{
    const DISABLED = 0;
    const ENABLED = 1;

    public function __toString()
    {
        return $this->title;
    }

    public function save(Doctrine_Connection $con = null) {
        parent::save($con);

        if(substr($this->slug, 0, 1) != '/'){
            $this->slug = '/'.$this->slug;
            parent::save();
        }
    }
}
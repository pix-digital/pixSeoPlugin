<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Nicolas R.
 * Date: 31/05/2012
 * Time: 17:05
 */

class Doctrine_Template_PixMeta extends Doctrine_Template
{

    protected $_options = array(

        'meta_title' => array('name' => 'meta_title',
            'alias' => null,
            'type' => 'varchar',
            'length' => 255,
            'disabled' => false,
            'expression' => false,
            'options' => array('notnull' => false)),
        'meta_description' => array('name' => 'meta_description',
            'alias' => null,
            'type' => 'clob',
            'disabled' => false,
            'expression' => false,
            'options' => array('notnull' => false)),
        'meta_keywords' => array('name' => 'meta_keywords',
            'alias' => null,
            'type' => 'clob',
            'disabled' => false,
            'expression' => false,
            'options' => array('notnull' => false)),
    );


    public function setTableDefinition()
    {

        if (!$this->_options['meta_title']['disabled']) {
            $name = $this->_options['meta_title']['name'];
            if ($this->_options['meta_title']['alias']) {
                $name .= ' as ' . $this->_options['meta_title']['alias'];
            }
            $this->hasColumn($name, $this->_options['meta_title']['type'], null, $this->_options['meta_title']['options']);
        }

        if (!$this->_options['meta_description']['disabled']) {
            $name = $this->_options['meta_description']['name'];
            if ($this->_options['meta_description']['alias']) {
                $name .= ' as ' . $this->_options['meta_description']['alias'];
            }
            $this->hasColumn($name, $this->_options['meta_description']['type'], null, $this->_options['meta_description']['options']);
        }

        if (!$this->_options['meta_keywords']['disabled']) {
            $name = $this->_options['meta_keywords']['name'];
            if ($this->_options['meta_keywords']['alias']) {
                $name .= ' as ' . $this->_options['meta_keywords']['alias'];
            }
            $this->hasColumn($name, $this->_options['meta_keywords']['type'], null, $this->_options['meta_keywords']['options']);
        }

    }

}
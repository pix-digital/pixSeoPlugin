<?php

/**
 * PluginPageRedirect form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginPageRedirectForm extends BasePageRedirectForm
{
    public function setup(){

        parent::setup();

        unset($this['created_at'],
              $this['updated_at']);

        $this->widgetSchema['url'] =  new sfWidgetFormInputText(array(), array('size' => 80));
        $this->widgetSchema['redirect_url'] =  new sfWidgetFormInputText(array(), array('size' => 80));
    }
}

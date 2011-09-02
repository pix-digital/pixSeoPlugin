<?php

/**
 * PluginPageSat form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginPageSatForm extends BasePageSatForm
{
    public function configure()
    {
        unset($this['created_at'],
              $this['updated_at']);

        $this->widgetSchema['lang'] = new sfWidgetFormI18nChoiceLanguage(array('languages' => array_keys(sfConfig::get('app_pixSeo_enabled_cultures')),
                                                                               'culture' => sfContext::getInstance()->getUser()->getCulture()));

        $this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCE(array(
  											'width'  => 550,
  											'height' => 350,
  	 										'theme' => 'advanced',
										));
    }
}

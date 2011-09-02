<?php

/**
 * pixSeoPlugin configuration.
 *
 * @package    pixSeoPlugin
 * @subpackage config
 * @author     Nicolas Ricci <nr@pix-digital.com>
 */
class pixSeoPluginConfiguration extends sfPluginConfiguration
{
    /**
     * @see sfPluginConfiguration
     */
    public function initialize()
    {
        if (sfConfig::get('app_pixSeo_routes_register', true)) {
            $enabledModules = sfConfig::get('sf_enabled_modules', array());
            if (in_array('pageSat', $enabledModules)) {
                $this->dispatcher->connect('routing.load_configuration', array('pixSeoRouting', 'addRouteForFrontend'));
            }

            if ((in_array('pageSatAdmin', $enabledModules)) or (in_array('pageRedirectAdmin', $enabledModules))){
                $this->dispatcher->connect('routing.load_configuration', array('pixSeoRouting', 'addRouteForBackend'));
            }
        }
    }
}

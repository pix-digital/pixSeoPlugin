<?php

class pixSeoRoutingConfigHandler extends sfRoutingConfigHandler
{

    protected function parse($configFiles)
    {
        // parse the yaml
        $config = self::getConfiguration($configFiles);

        // collect routes
        $routes = array();
        foreach ($config as $name => $params)
        {
            if (
                (isset($params['type']) && 'collection' == $params['type'])
                ||
                (isset($params['class']) && false !== strpos($params['class'], 'Collection'))
            ) {
                $options = isset($params['options']) ? $params['options'] : array();
                $options['name'] = $name;
                $options['requirements'] = isset($params['requirements']) ? $params['requirements'] : array();

                $routes[$name] = array(isset($params['class']) ? $params['class']
                                               : 'sfRouteCollection', array($options));
            }
            else
            {
                $routes[$name] = array(isset($params['class']) ? $params['class']
                                               : $this->getDefaultRouteClass($params), array(
                    $params['url'] ? $params['url'] : '/',
                    isset($params['params']) ? $params['params'] : (isset($params['param']) ? $params['param']
                            : array()),
                    isset($params['requirements']) ? $params['requirements'] : array(),
                    isset($params['options']) ? $params['options'] : array(),
                ));
            }
        }

        return $routes;
    }

    protected function getDefaultRouteClass($params)
    {
        $default = sfConfig::get('app_pixSeo_route_class');
        return isset($default) ? $default : 'sfRoute';

    }
}

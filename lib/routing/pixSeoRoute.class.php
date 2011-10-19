<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Nicolas R.
 * Date: 19/09/2011
 * Time: 15:00
 */

class pixSeoRoute extends sfRequestRoute
{

    public function matchesUrl($url, $context = array())
    {
        if (false === $parameters = parent::matchesUrl($url, $context)) {
            return false;
        }

        if($parameters['module'] != 'pageSat' or ($parameters['module'] == 'pageSat' && $parameters['action'] == 'index')){

            // return false if the default host isn't found
            if (strpos($context['host'], sfConfig::get('app_pixSeo_default_host', false)) === false)
            {
              return false;
            }

            return $parameters;
        }

        // si le slug n'existe pas on est sur la page de listing
        if(!isset($parameters['slug'])){
            return $parameters;
        }



        $slug = '/' . $parameters['slug']; // slug always start with a slash to comply with Apostrophe routing
        $pageSat = Doctrine_Core::getTable('PageSat')->findOneBySlug($slug);

        if (!$pageSat) {
            return false;
        }

        // check if pageSat host is not null
        if (!is_null($pageSat->host)) {
            if ($context['host'] != $pageSat->host) {
                return false;
            }
        }

        return array_merge(array('slug' => $pageSat->slug), $parameters);
    }

    public function matchesParameters($params, $context = array())
    {
        unset($params['host']);
        return parent::matchesParameters($params, $context);
    }

    public function generate($params, $context = array(), $absolute = false)
    {
        $host = isset($params['host']) ? $params['host'] : sfConfig::get('app_pixSeo_default_host', false);
        unset($params['host']);
        if ($host && $host != $context['host']) {
            $url = parent::generate($params, $context, false);
            return $this->getHost($context, $host) . $url;

        }
        return parent::generate($params, $context, $absolute);
    }

    protected function getHost($context, $host)
    {
        $protocol = 'http' . (isset($context['is_secure']) &&
                              $context['is_secure'] ? 's' : '');
        return $protocol . '://' . $host;
    }

}
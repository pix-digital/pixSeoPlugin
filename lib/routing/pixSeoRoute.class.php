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

        if($parameters['module'] != 'pageSat'){

            // return false if the default subdomain isn't found
            if (strpos($context['host'], sfConfig::get('app_pixSeo_default_subdomain', false)) === false)
            {
              return false;
            }

            return $parameters;
        }


        $subdomain = $this->getSubdomain($context);
        $slug = '/' . $parameters['slug']; // slug always start with a slash to comply with Apostrophe routing

        $pageSat = Doctrine_Core::getTable('PageSat')->findOneBySlug($slug);

        if (!$pageSat) {
            return false;
        }

        // check if pageSat subdomain is not null
        if (!is_null($pageSat->subdomain)) {
            if ($subdomain != $pageSat->subdomain) {
                return false;
            }
        }

        return array_merge(array('slug' => $pageSat->slug), $parameters);
    }

    public function matchesParameters($params, $context = array())
    {
        unset($params['subdomain']);
        return parent::matchesParameters($params, $context);
    }

    public function generate($params, $context = array(), $absolute = false)
    {
        $subdomain = isset($params['subdomain']) ? $params['subdomain'] : sfConfig::get('app_pixSeo_default_subdomain', false);
        unset($params['subdomain']);
        if ($subdomain && $subdomain != $this->getSubdomain($context)) {
            $url = parent::generate($params, $context, false);
            return $this->getHostForSubdomain($context, $subdomain) . $url;
        }
        return parent::generate($params, $context, $absolute);
    }

    protected function getSubdomain($context){
        return substr($context['host'], 0, strpos($context['host'], '.')); // we assume the subdomain has not multiple . separation
    }

    protected function getHostForSubdomain($context, $subdomain)
    {
        $parts = explode('.', $context['host']);
        $parts[0] = $subdomain;
        $host = implode('.', $parts);
        $protocol = 'http' . (isset($context['is_secure']) &&
                              $context['is_secure'] ? 's' : '');
        return $protocol . '://' . $host;
    }
}
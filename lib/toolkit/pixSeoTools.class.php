<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Nicolas R.
 * Date: 24/06/2011
 * Time: 10:37
 */
class pixSeoTools
{
    // copied from Apostrophe
    static public function urlForPage($slug, $extra_params = array(), $absolute = true)
    {

        // ajout extra_params
        $slug_params = '';
        foreach($extra_params as $key => $param){
            $slug_params .= '&'.$key.'='.$param;
        }

        $routed_url = sfContext::getInstance()->getController()->genUrl('@pix_page_sat_show?slug=-PLACEHOLDER-'.$slug_params, $absolute);
        $routed_url = str_replace('-PLACEHOLDER-', $slug, $routed_url);
        // We tend to get double slashes because slugs begin with slashes
        // and the routing engine wants to helpfully add one too. Fix that,
        // but don't break http://
        $matches = array();
        // This is good both for dev controllers and for absolute URLs
        $routed_url = preg_replace('/([^:])\/\//', '$1/', $routed_url);
        // For non-absolute URLs without a controller
        if (!$absolute) {
            $routed_url = preg_replace('/^\/\//', '/', $routed_url);
        }
        return $routed_url;
    }
}

<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Nicolas R.
 * Date: 06/06/2012
 * Time: 14:18
 */
function loadMetas($params = array())
{
    if (empty($params)) {
        return;
    }

    $response = sfContext::getInstance()->getResponse();

    if (array_key_exists('title', $params)) {
        $response->setTitle($params['title']);
    }

    if (array_key_exists('description', $params)) {
        $response->addMeta('description', $params['description']);
    }

    if (array_key_exists('keywords', $params)) {
        $response->addMeta('keywords', strtolower($params['keywords']));
    }
}

function loadDefaultMetas()
{
    $response = sfContext::getInstance()->getResponse();
    $culture = sfContext::getInstance()->getUser()->getCulture();
    $request = sfContext::getInstance()->getRequest();

    $metas = sfConfig::get('app_metas_'.$request->getParameter('module'));
    if(array_key_exists($culture, $metas)){
        $response->setTitle($metas[$culture]['title']);
        $response->addMeta('description', $metas[$culture]['description']);
        $response->addMeta('keywords', $metas[$culture]['keywords']);
    }
}

<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Nicolas R.
 * Date: 22/06/2011
 * Time: 14:30
 */
class BasePageSatAutoActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();

        $this->page_sats = Doctrine_Core::getTable('PageSatAuto')->retrieveAllActive($culture);

        // metas
        $this->loadMetas(array(
            'title' => '',
            'description' => '',
            'keywords' => '',
            'placeholder' => '',
            'load_default' => false
        ));
    }

    public function executeShow(sfWebRequest $request)
    {

        $slug = $this->getRequestParameter('slug');

        $page_sat = Doctrine_Core::getTable('PageSatAuto')->findBySlug($slug);
        $this->forward404Unless($page_sat);

        // metas
        $this->loadMetas(array(
            'title' => $page_sat->meta_title,
            'description' => $page_sat->meta_description,
            'keywords' => $page_sat->meta_keywords,
            'placeholder' => $page_sat->keyword
        ));

        $this->page_sat = $page_sat;
    }

    protected function loadMetas($params = array())
    {

        if (empty($params)) {
            return;
        }

        $response = $this->getResponse();
        $config = sfConfig::get('app_pixSeo_pageSatAuto');
        $load_default = isset($params['load_default']) ? $params['load_default'] : $config['load_default'];

        if (array_key_exists('title', $params)) {
            $response->setTitle(str_replace('{keyword}', $params['placeholder'], $load_default ? $config['meta_title'] : $params['title']));
        }

        if (array_key_exists('description', $params)) {
            $response->addMeta('description', str_replace('{keyword}', $params['placeholder'], $load_default ? $config['meta_description'] : $params['description']));
        }

        if (array_key_exists('keywords', $params)) {
            $response->addMeta('keywords', strtolower(str_replace('{keyword}', $params['placeholder'], $load_default ? $config['meta_keywords'] : $params['keywords'])));
        }
    }
}
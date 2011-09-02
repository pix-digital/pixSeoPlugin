<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Nicolas R.
 * Date: 22/06/2011
 * Time: 14:30
 */
class BasePageSatActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();

        $this->page_sats = Doctrine_Core::getTable('PageSat')
                ->retrieveAllActive($culture);
    }

    public function executeShow(sfWebRequest $request)
    {

        $slug = $this->getRequestParameter('slug');

        // remove trailing slashes from $slug
        $pattern = '/\/$/';
        if (preg_match($pattern, $slug) && ($slug != '/')) {
            sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));

            $new_slug = preg_replace($pattern, '', $slug);
            $slug = addcslashes($slug, '/');
            $new_uri = preg_replace('/' . $slug . '/', $new_slug, $request->getUri());

            $this->redirect($new_uri);
        }

        if (substr($slug, 0, 1) !== '/') {
            $slug = "/$slug";
        }

        $page_sat = Doctrine_Core::getTable('PageSat')
                ->retrieveBySlugAndCulture($slug, $this->getUser()->getCulture());
        $this->forward404Unless($page_sat);

        // layout and template
        if ($page_sat->layout) {
            $this->setLayout($page_sat->layout);
        }

        if ($page_sat->template) {
            $this->setTemplate($page_sat->template);
        }

        // metas
        $this->loadMetas(array(
                              'title' => $page_sat->meta_title,
                              'description' => $page_sat->meta_description,
                              'keywords' => $page_sat->meta_keywords
                         ));

        $this->page_sat = $page_sat;
    }

    protected function loadMetas($params = array())
    {

        if (empty($params)) {
            return;
        }

        $response = $this->getResponse();

        if (array_key_exists('title', $params)) {
            $response->setTitle(sfConfig::get('app_pixPage_metas_default_title') . $params['title']);
        }

        if (array_key_exists('description', $params)) {
            $response->addMeta('description', sfConfig::get('app_pixPage_metas_default_description') . $params['description']);
        }

        if (array_key_exists('keywords', $params)) {
            $response->addMeta('keywords', sfConfig::get('app_pixPage_metas_default_keywords') . strtolower($params['keywords']));
        }
    }
}
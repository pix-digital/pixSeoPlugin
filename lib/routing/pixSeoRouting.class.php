<?php

/**
 *
 * @package    pixSeoRouting
 * @subpackage plugin
 * @author     Nicolas Ricci
 */
class pixSeoRouting
{
    /**
     * Listens to the routing.load_configuration event.
     *
     * @param sfEvent An sfEvent instance
     * @static
     */
    static public function addRouteForFrontend(sfEvent $event)
    {
        $r = $event->getSubject();

        // append / preprend our routes
        $r->appendRoute('pix_page_sat_index', new sfRoute('/:sf_culture/pages',
                                                array('module' => 'pageSat', 'action' => 'index'),
                                                array(),
                                                array(
                                                    'requirements' => array(
                                                        'sf_culture' => implode('|',array_keys(sfConfig::get('app_pixSeo_enabled_cultures')))
                                                    )
                                                )
                                            ));
        $r->appendRoute('pix_page_sat_show', new sfRoute('/:sf_culture/page/:slug',
                                               array('module' => 'pageSat', 'action' => 'show'),
                                               array(),
                                                array(
                                                    'requirements' => array(
                                                        'sf_culture' => implode('|',array_keys(sfConfig::get('app_pixSeo_enabled_cultures'))),
                                                        'slug'       => '.*'
                                                    )
                                                )
                                           ));

    }

    static public function addRouteForBackend(sfEvent $event)
    {
        $r = $event->getSubject();

        // preprend our routes

        $r->prependRoute('pix_page_sat_admin', new sfDoctrineRouteCollection(array(
                                                                              'name' => 'pix_page_sat_admin',
                                                                              'model' => 'PageSat',
                                                                              'module' => 'pageSatAdmin',
                                                                              'prefix_path' => 'admin/page-sat',
                                                                              'with_wildcard_routes' => true,
                                                                              'collection_actions' => array('filter' => 'post', 'batch' => 'post'),
                                                                              'requirements' => array(),
                                                                         )));

        $r->prependRoute('pix_page_redirect_admin', new sfDoctrineRouteCollection(array(
                                                                              'name' => 'pix_page_redirect_admin',
                                                                              'model' => 'PageRedirect',
                                                                              'module' => 'pageRedirectAdmin',
                                                                              'prefix_path' => 'admin/redirect',
                                                                              'with_wildcard_routes' => true,
                                                                              'collection_actions' => array('filter' => 'post', 'batch' => 'post'),
                                                                              'requirements' => array(),
                                                                         )));

    }


}
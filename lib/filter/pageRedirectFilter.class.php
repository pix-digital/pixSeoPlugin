<?php
class pageRedirectFilter extends sfFilter
{

    public function execute($filterChain)
    {

        // Code to execute before the action execution
        $request = $this->getContext()->getRequest();
        $host = sfConfig::get('app_pixSeo_multi_domain') ? $request->getHost() : null;

        $pageRedirect = Doctrine_Core::getTable('PageRedirect')->retrieveOneBySlugandHost($request->getPathInfo(), $host);
        if ($pageRedirect) {
            $host = is_null($host) ? $request->getHost() : $host;
            $this->getContext()->getController()->redirect('http://' . $host . $pageRedirect->redirect_url, 301);
        }

        // Execute next filter in the chain
        $filterChain->execute();

        // Code to execute after the action execution, before the rendering

    }

}
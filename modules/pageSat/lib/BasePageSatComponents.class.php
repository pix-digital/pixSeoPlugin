<?php
/**
 * page components.
 *
 * @package    pixSeoPlugin
 * @subpackage pageSat
 * @author     Nicolas Ricci <nr@pix-digital.com>
 */
class BasePageSatComponents extends sfComponents
{
    public function executeMenu(sfWebRequest $request)
    {
        $culture = $this->getUser()->getCulture();

        $this->pages_sat = Doctrine_Core::getTable('PageSat')
                ->retrieveAllActiveInMenu($culture);

    }
}

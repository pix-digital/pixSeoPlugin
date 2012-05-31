# pixSeoPlugin - SEO tools for symfony 1.4 projects

## Introduction

This plugin is born from the recurrent needs of having satelitte pages and an easy way to handle
page redirections.
This plugin only supports Doctrine ORM.

## Installation

cd /your/symfony/project
git clone git://github.com/pix-digital/pixSeoPlugin.git plugins/pixSeoPlugin

Enable the plugin in your ProjectConfiguration.class.php

    [php]
    public function setup()
    {
        $this->enablePlugin('pixSeoPlugin');
    }

Note: if used with pixCmsPlugin, always enable this plugin first

Add the following line before the class implementation in ProjectConfiguration.class.php

    [php]
    require_once(dirname(__FILE__).'/../plugins/pixSeoPlugin/lib/routing/pixSeoRoutingConfigHandler.class.php');
    class ProjectConfiguration extends sfProjectConfiguration

Rebuild your model

    ./symfony doctrine:build --all-classes

Rebuild SQL and import all the new tables in your database (or use the migrate task if you prefer)

    ./symfony doctrine:build-sql

Add a config_handlers.yml file with the following configuration in the application where you want to use pageSat module

    [yaml]
    config/routing.yml:
      class: pixSeoRoutingConfigHandler

Enable modules according to your needs in your application settings.yml

    [yaml]
    all:
      .settings:
        enabled_modules:
          - pageSat
          - pageSatAdmin


pageRedirect
------------

The pageRedirect module allows to specify an old url and the url it should be redirected to.
If the "host" field is specified the script will only redirect if the current host matches (quite useful for multi domain setup)

* Installation

Enable the pageRedirect filter in your application filters.yml

    [yaml]
    pageRedirect:
      class: pageRedirectFilter


pageSat
-------

The pageSat module allows to create satellite pages in multiple languages and for several domains.


trackingFilter
--------------

This filter creates a cookie to store information about where the user is coming from (url, host, keywords)

* Installation

Enable the tracking filter in your application filters.yml

    [yaml]
    tracking:
      class: trackingFilter

* Usage

To collect information for your cookie at anytime

    [php]
    $cookie = $request->getCookie(sfConfig::get('app_cookie_name'));
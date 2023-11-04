<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class GdprBar extends Module
{
    public function __construct()
    {
        $this->name = 'gdprbar';
        $this->tab = 'front_office_features';
        $this->version = '0.0.1';
        $this->author = 'ME';

        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.0',
            'max' => '8.99.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->confirmUninstall = $this->l('Do you still you want to uninstall this module?');
        $this->description = $this->l('This is a simple GDPR cookies module.');
        $this->displayName = $this->l('GDPR Bar');
    }

    public function install()
    {
        return parent::install() && $this->registerHook('displayFooterBefore') && $this->registerHook('actionFrontControllerSetMedia');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookActionFrontControllerSetMedia($params)
    {
        $this->context->controller->registerStylesheet(
            'gdprbar-style',
            $this->_path . 'views/css/bar.css',
            [
                'media' => 'all',
                'priority' => 999,
            ]
        );

        $this->context->controller->registerJavascript(
            'gdprbar-logic',
            $this->_path . '/views/js/bar.js',
            [
                'priority' => 999,
                'attribute' => 'async',
                'version' => '1.0'
            ]
        );
    }
    public function hookDisplayFooterBefore($params)
    {
        return $this->display(__FILE__, 'bar.tpl');
    }
}

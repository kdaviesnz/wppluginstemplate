<?php

namespace kdaviesnz\template;

interface ITemplate
{
    public function admin(): bool;
    public function init();
    public function metaBoxes();
    public function addTemplatePageType();
    public function foot();
    public function head();
    public function adminFoot();
    public function adminHead();
    public function addMenuItems();
    public function onActivation():Callable;
    public function onDeactivation():Callable;
    public function onPluginsLoaded():Callable;
}

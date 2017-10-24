<?php

namespace kdaviesnz\template;


interface ITemplateView
{
    public static function shortcode() :Callable;
    public static function renderAdminForm() :Callable;
    public static function renderMetaboxes() :Callable;
    public static function filterPost() :Callable;
    public static function renderPluginsNotice() :Callable;
    public static function renderEditPageNotice() :Callable;
    public static function renderEditPostNotice() :Callable;
    public static function renderAllPagesNotice() :Callable;
    public static function renderAllPostsNotice() :Callable;
    public static function addPostsTableColumnHeader() :Callable;
    public static function addPostsTableColumnContent() :Callable;

}

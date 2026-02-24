<?php 
/**
* File Paginator
* @copyright Copyright 2018 Ken Albers
* @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
*/

/**
 * File Paginator Plugin
 * @package  File Paginator
 */

class FilePaginatorPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array(
        'public_head',
        'public_footer',
        'config', 
        'config_form',
        );

    protected $_filters = array(
        'files_for_item',
        'file_markup',
        'file_markup_options'
    );

    public function hookInitialize()
    {
        get_view()->addHelperPath(dirname(__FILE__) . '/views/helpers', 'FilePaginator_View_Helper_FileShowPagination');
    }

    public function hookPublicHead($args)
    {   
        queue_js_file('jquery.simplePagination');
        queue_js_file('filePagination');
        queue_css_file('simplePagination');
        queue_css_file('filePaginator');
    }

    public function hookPublicFooter($args)
    {
        $view = $args['view'];
        echo $view->partial('common/file-show-pagination.php');
    }

    public function hookConfigForm($args) {
        $view = $args['view'];
        include('config_form.php');
    }

    public function hookConfig($args){
        $post = $args['post'];
        set_option('file_paginator_theme',$post['theme']);
        set_option('file_paginator_links',$post['links']);
        set_option('file_paginator_metadata',$post['metadata']);
    }

    public function filterFilesForItem($html) {
        $theme = get_option('file_paginator_theme');
        return '<div id="file-pagination" data-theme="' . $theme . '"></div>'.$html;
    }

    public function filterFileMarkupOptions($options) {
        if (get_option('file_paginator_links') == 1) {
            $options['linkAttributes']['target'] = '_blank';
        }
        return $options;
    }

    public function filterFileMarkup($html,$args) {
        $file = $args['file'];
        $options =  $args['options'];
        if (empty($options['filesForItem'])) {
            return $html;
        }
        return '<div class="single-file">'
            . $html
            . (get_option('file_paginator_metadata') == '1' ? all_element_texts($file, array('show_element_set_headings' => false)) : '')
            . '</div>';
    }
}
?>
<?php
/**
 * View helper for previous and next links on file show views.
 * 
 * @package FilePaginator\View\Helper
 */
class FilePaginator_View_Helper_FileShowPagination extends Zend_View_Helper_Abstract
{
    public function fileShowPagination()
    {
        $currentController = Zend_Controller_Front::getInstance()->getRequest()->getControllerName(); 
        $html = '';
        if ($currentController == 'files') {
            $file = get_current_record('file');
            $originalItem = $file->getItem();
            $itemFiles = $originalItem->getFiles();

            if (count($itemFiles) > 1) {
                $html .= '<nav id="file-show-pagination" class="item-pagination" aria-label="' . __('File navigation') . '"><ul class="navigation">';
                $originalItemOrder = metadata($file, 'order');
                $currentFile = null;
                $previousFile = null;
                $nextFile = null;
                foreach($itemFiles as $itemFile) {
                    if ($itemFile->id === $file->id) {
                        $currentFile = $itemFile;
                    } elseif ($currentFile !== null) {
                        $nextFile = $itemFile;
                        break;
                    } else {
                        $previousFile = $itemFile;
                    }
                }
                if ($previousFile) {
                    $html .= '<li class="previous">' . link_to($previousFile, 'show', __('Previous')) . '</li>';
                }
                if ($nextFile) {
                    $html .= '<li class="next">' . link_to($nextFile, 'show', __('Next')) . '</li>';
                }
                $html .= '</ul></nav>';
            }
        }

        return $html;
    }
}
?>
<?php
namespace Front\Util;

use Lib\View\Pagination as Page;

class Pagination extends Page
{
    protected $paginationWrapper = '<div class="pagination menu">%s</div>';

    protected $paginationInner = '<a href="%s" class="blue icon item">%s</a>';

    protected $activeNum = '<span class="active blue item">%s</span>';

    protected $disabledNum = '<span class="disabled icon item">%s</span>';

    protected $dotNum = '<span class="blue item">%s</span>';

    protected $dots = '&middot;&middot;&middot;';

    protected $previous = '<i class="fa fa-chevron-left"></i>';

    protected $next = '<i class="fa fa-chevron-right"></i>';
}
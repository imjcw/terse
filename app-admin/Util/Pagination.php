<?php
namespace Admin\Util;

use Lib\View\Pagination as Page;

class Pagination extends Page
{
    protected $paginationWrapper = '<div class="ui pagination menu">%s</div>';

    protected $paginationInner = '<a href="%s" class="blue icon item">%s</a>';

    protected $activeNum = '<span class="active blue item">%s</span>';

    protected $disabledNum = '<span class="disabled icon item">%s</span>';

    protected $dotNum = '<span class="blue item">%s</span>';

    protected $dots = '&middot;&middot;&middot;';

    protected $previous = '<i class="left arrow icon"></i>';

    protected $next = '<i class="right arrow icon"></i>';
}
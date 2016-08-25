<?php

namespace App\Http\Controllers\Web\UCenter;

use App\Http\Controllers\Web\Controller as WebController;
use App\Services\OrderCommodity\ErpOrder;
use App\Services\OrderCommodity\OrderCommodity;
use App\Services\UserCenter\Collection;
use App\Services\User\User;
use App\Services\KuJiaLe\Design;

abstract class Controller extends WebController
{
    protected $_user;
    protected $_servicesErp;

    public function __construct() {
        parent::__construct();
    }

}

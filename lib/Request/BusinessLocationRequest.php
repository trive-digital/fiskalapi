<?php
/**
 * Trive Fiskal API Library.
 *
 * @category  Trive
 * @package   Trive_FiskalAPI
 * @copyright 2017 Trive d.o.o (http://trive.digital)
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link      http://trive.digital
 */

namespace Trive\FiskalAPI\Request;

use Trive\FiskalAPI\Request;
use Trive\FiskalAPI\Business\BusinessLocation;

class BusinessLocationRequest extends Request
{
    /**
     * BusinessLocationRequest constructor.
     *
     * @param BusinessLocation $businessLocation
     */
    public function __construct(BusinessLocation $businessLocation)
    {
        $this->request = $businessLocation;
        $this->requestName = 'PoslovniProstorZahtjev';
    }
}

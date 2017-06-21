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
use Trive\FiskalAPI\Invoice\Invoice;

class InvoiceRequest extends Request
{
    /**
     * InvoiceRequest constructor.
     *
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->request = $invoice;
        $this->requestName = 'RacunZahtjev';
    }
}
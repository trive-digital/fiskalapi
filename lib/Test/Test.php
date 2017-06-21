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

namespace Trive\FiskalAPI\Test;

use XMLWriter;

class Test
{
    /**
     * Message to send
     *
     * @var string
     */
    public $message = '';

    /**
     * Set message to send in request
     *
     * @param $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message to send in request
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Generate XML request body
     *
     * @return string
     */
    public function toXML()
    {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->setIndent(true);
        $writer->setIndentString('    ');
        $writer->writeRaw($this->getMessage());
        $writer->endElement();

        return $writer->outputMemory();
    }
}

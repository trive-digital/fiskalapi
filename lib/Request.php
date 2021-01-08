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

namespace Trive\FiskalAPI;

use XMLWriter;

class Request
{
    /**
     * Request object
     *
     * @var Request
     */
    public $request;

    /**
     * Request name
     *
     * @var string
     */
    public $requestName;

    /**
     * Get request
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get request name
     *
     * @return string
     */
    public function getRequestName()
    {
        return $this->requestName;
    }

    /**
     * Generate UUID
     *
     * @return string
     */
    private function generateUUID()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }

    /**
     * Generate date and time, and format according to spec
     *
     * @return string
     */
    private function generateDateTime()
    {
        $date = new \DateTime();

        return $date->format('d.m.Y\TH:i:s');
    }

    /**
     * Set headers, get specific request XML body and make request
     *
     * @return string
     */
    public function toXML()
    {
        $namespace = 'tns';
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->setIndent(true);
        $writer->setIndentString('    ');
        $writer->startElementNs($namespace, $this->getRequestName(), 'http://www.apis-it.hr/fin/2012/types/f73');
        $writer->writeAttribute('Id', uniqid());
        $writer->startElementNs($namespace, 'Zaglavlje', null);
        $writer->writeElementNs($namespace, 'IdPoruke', null, $this->generateUUID());
        $writer->writeElementNs($namespace, 'DatumVrijeme', null, $this->getRequest()->getDateTime());
        $writer->endElement();
        $writer->writeRaw($this->getRequest()->toXML());
        $writer->endElement();

        return $writer->outputMemory();
    }
}

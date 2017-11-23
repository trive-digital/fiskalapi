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

use DOMDocument;
use DOMElement;
use Exception;

/**
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Client
{
    /**
     * Demo FINA URL.
     */
    const DEMO_URL = 'https://cistest.apis-it.hr:8449/FiskalizacijaServiceTest';

    /**
     * Live FINA URL.
     */
    const LIVE_URL = 'https://cis.porezna-uprava.hr:8449/FiskalizacijaService';

    /**
     * Certificate directory path.
     */
    const DIR_PATH = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'ssl'.DIRECTORY_SEPARATOR;

    /**
     * Root CA certificate path
     */
    const DEMO_ROOT_CERTIFICATE_PATH = self::DIR_PATH.'demo2014_root_ca_1.crt';

    /**
     * Root CA certificate path
     */
    const LIVE_ROOT_CERTIFICATE_PATH = self::DIR_PATH.'FinaRootCA.crt';

    /**
     * Debug mode flag
     *
     * @var bool
     */
    protected $debug;

    /**
     * Last request.
     *
     * @var string
     */
    private $lastRequest;

    /**
     * Last response.
     *
     * @var string
     */
    private $lastResponse;

    /**
     * Error code
     *
     * @var integer
     */
    private $errorCode;

    /**
     * URL to connect to.
     *
     * @var string
     */
    private $url;

    /**
     * Root certificate path.
     *
     * @var string
     */
    private $rootCertificatePath;

    /**
     * Certificate data.
     *
     * @var array
     */
    private $certificate;

    /**
     * Private key resource of certificate.
     *
     * @var array
     */
    private $privateKeyResource;

    /**
     * Public certificate data.
     *
     * @var array
     */
    private $publicCertData;

    /**
     * FiskalAPI constructor.
     *
     * @param string  $certificate    Path to certificate or raw certificate.
     * @param string  $pass           Certificate password.
     * @param boolean $rawCertificate Determines if certificate is provided in raw form or path.
     * @param boolean $demo           Demo mode flag.
     * @param boolean $debug          Debug mode flag.
     */
    public function __construct($certificate, $pass, $rawCertificate = false, $demo = false, $debug = false)
    {
        $this->debug = $debug;
        $this->initUrl($demo);
        $this->initCertificate($certificate, $pass, $rawCertificate);
        $this->initRootCertificatePath($demo);
    }

    /**
     * Get debug flag.
     *
     * @return boolean
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * Set last request.
     *
     * @param string $request Request string.
     *
     * @return void
     */
    private function setLastRequest($request)
    {
        $this->lastRequest = $request;
    }

    /**
     * Set last response.
     *
     * @param string $response Response string.
     *
     * @return void
     */
    private function setLastResponse($response)
    {
        $this->lastResponse = $response;
    }

    /**
     * Set error code.
     *
     * @param integer $errorCode Error code.
     *
     * @return void
     */
    private function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * Get URL.
     *
     * @return string
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * Get URL.
     *
     * @return string
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Get error code.
     *
     * @return integer
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Request success flag.
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        $successful = false;

        $errorCode = $this->getErrorCode();
        if ($errorCode === 200 || $errorCode === 0) {
            $successful = true;
        }

        return $successful;
    }

    /**
     * Get URL.
     *
     * @return string
     */
    private function getUrl()
    {
        return $this->url;
    }

    /**
     * Set URL.
     *
     * @param string $url URL.
     *
     * @return $this
     */
    private function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get root certificate path.
     *
     * @return string
     */
    private function getRootCertificatePath()
    {
        return $this->rootCertificatePath;
    }

    /**
     * Set root certificate path.
     *
     * @param string $rootCertificatePath Root certificate path.
     *
     * @return $this
     */
    private function setRootCertificatePath($rootCertificatePath)
    {
        $this->rootCertificatePath = $rootCertificatePath;

        return $this;
    }

    /**
     * Get certificate.
     *
     * @return array
     */
    private function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * Set certificate.
     *
     * @param array $certificate Array of certificate data.
     *
     * @return $this
     */
    private function setCertificate(array $certificate)
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * Get certificate private key.
     *
     * @return mixed
     */
    public function getCertificatePrivateKey()
    {
        return $this->certificate['pkey'];
    }

    /**
     * Get certificate cert part.
     *
     * @return mixed
     */
    private function getCertificateCert()
    {
        return $this->certificate['cert'];
    }

    /**
     * Get private key resource of certificate.
     *
     * @return array
     */
    private function getPrivateKeyResource()
    {
        return $this->privateKeyResource;
    }

    /**
     * Set private key resource of certificate.
     *
     * @param resource $privateKeyResource Private key resource.
     *
     * @return $this
     */
    private function setPrivateKeyResource($privateKeyResource)
    {
        $this->privateKeyResource = $privateKeyResource;

        return $this;
    }

    /**
     * Get public certificate data.
     *
     * @return array
     */
    private function getPublicCertificateData()
    {
        return $this->publicCertData;
    }

    /**
     * Set public certificate data.
     *
     * @param array $publicCertData Public certificate data array.
     *
     * @return $this
     */
    private function setPublicCertificateData(array $publicCertData)
    {
        $this->publicCertData = $publicCertData;

        return $this;
    }

    /**
     * Init URL to connect to.
     *
     * @param boolean $demo Demo flag.
     *
     * @return $this
     */
    private function initUrl($demo)
    {
        $url = self::LIVE_URL;
        if ($demo === true) {
            $url = self::DEMO_URL;
        }

        $this->setUrl($url);

        return $this;
    }

    /**
     * Read certificate from provided path, parse it and store in array.
     *
     * @param string  $providedCertificate Path to certificate or raw certificate.
     * @param string  $pass                Certificate Password.
     * @param boolean $rawCertificate      Determines if certificate is provided in raw form or path.
     *
     * @return $this
     */
    private function initCertificate($providedCertificate, $pass, $rawCertificate = false)
    {
        $certificateContent = $providedCertificate;
        if ($rawCertificate === false) {
            $certificateContent = $this->readCertificateFromDisk($providedCertificate);
        }

        openssl_pkcs12_read($certificateContent, $certificate, $pass);
        $this->setCertificate($certificate);
        $this->setPrivateKeyResource(openssl_pkey_get_private($this->getCertificatePrivateKey(), $pass));
        $this->setPublicCertificateData(openssl_x509_parse($this->getCertificateCert()));

        return $this;
    }

    /**
     * Init root certificate path.
     *
     * @param boolean $demo Demo flag.
     *
     * @return $this
     */
    private function initRootCertificatePath($demo)
    {
        $rootCertificatePath = self::LIVE_ROOT_CERTIFICATE_PATH;
        if ($demo === true) {
            $rootCertificatePath = self::DEMO_ROOT_CERTIFICATE_PATH;
        }

        $this->setRootCertificatePath($rootCertificatePath);

        return $this;
    }

    /**
     * Read certificate from provided path.
     *
     * @param string $path Path to certificate.
     *
     * @return string|bool Certificate content.
     * @throws \Exception Exception in case certificate cannot be read.
     */
    private function readCertificateFromDisk($path)
    {
        $cert = @file_get_contents($path);
        if ($cert === false) {
            throw new \Exception('Can not read certificate from location: '.$path, 1);
        }

        return $cert;
    }

    /**
     * Get public certificate string.
     *
     * @return string
     */
    private function getPublicCertificateString()
    {
        $publicCertString = str_replace(
            ['-----BEGIN CERTIFICATE-----', '-----END CERTIFICATE-----'],
            '',
            $this->getCertificateCert()
        );

        return $publicCertString;
    }

    /**
     * Get certificate issuer name.
     *
     * @return string
     */
    private function getCertificateIssuerName()
    {
        $publicCertData = $this->getPublicCertificateData();
        $x509Issuer = $publicCertData['issuer'];
        $x509IssuerC = isset($x509Issuer['C']) ? $x509Issuer['C'] : '';
        $x509IssuerO = isset($x509Issuer['O']) ? $x509Issuer['O'] : '';
        $x509IssuerOU = isset($x509Issuer['OU']) ? $x509Issuer['OU'] : '';

        $x509IssuerName = sprintf('OU=%s,O=%s,C=%s', $x509IssuerOU, $x509IssuerO, $x509IssuerC);

        return $x509IssuerName;
    }

    /**
     * Get certificate issuer serial number.
     *
     * @return string
     */
    private function getCertificateIssuerSerialNumber()
    {
        $publicCertData = $this->getPublicCertificateData();

        return $publicCertData['serialNumber'];
    }

    /**
     * Generate signature.
     *
     * @param DOMElement $signedInfoNode Signed info node.
     *
     * @return null|string
     * @throws \Exception Exception.
     */
    private function generateSignature(DOMElement $signedInfoNode)
    {
        $signature = null;

        if (!openssl_sign(
            $signedInfoNode->C14N(true),
            $signature,
            $this->getPrivateKeyResource(),
            OPENSSL_ALGO_SHA1
        )
        ) {
            throw new \Exception('Unable to sign the request');
        }

        return $signature;
    }

    /**
     * Sign XML request.
     *
     * @param string $xmlRequest XML request to sign.
     *
     * @return string Signed XML request
     * @throws \Exception Exception.
     */
    private function signXML($xmlRequest)
    {
        $xmlRequestDOMDoc = new DOMDocument();
        $xmlRequestDOMDoc->loadXML($xmlRequest);

        $canonical = $xmlRequestDOMDoc->C14N();
        $digestValue = base64_encode(hash('sha1', $canonical, true));
        $rootElem = $xmlRequestDOMDoc->documentElement;

        /** @var \DOMElement $signatureNode Signature node */
        $signatureNode = $rootElem->appendChild(new DOMElement('Signature'));
        $signatureNode->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');

        /** @var \DOMElement $signedInfoNode Signed info node */
        $signedInfoNode = $signatureNode->appendChild(new DOMElement('SignedInfo'));
        $signedInfoNode->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');

        /** @var \DOMElement $canonicalMethodNode Canonicalization method node */
        $canonicalMethodNode = $signedInfoNode->appendChild(new DOMElement('CanonicalizationMethod'));
        $canonicalMethodNode->setAttribute('Algorithm', 'http://www.w3.org/2001/10/xml-exc-c14n#');

        /** @var \DOMElement $signatureMethodNode Signature method node */
        $signatureMethodNode = $signedInfoNode->appendChild(new DOMElement('SignatureMethod'));
        $signatureMethodNode->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');

        /** @var \DOMElement $referenceNode */
        $referenceNode = $signedInfoNode->appendChild(new DOMElement('Reference'));
        $referenceNode->setAttribute('URI', sprintf('#%s', $xmlRequestDOMDoc->documentElement->getAttribute('Id')));

        /** @var \DOMElement $transformsNode */
        $transformsNode = $referenceNode->appendChild(new DOMElement('Transforms'));

        /** @var \DOMElement $transform1Node */
        $transform1Node = $transformsNode->appendChild(new DOMElement('Transform'));
        $transform1Node->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');

        /** @var \DOMElement $transform2Node */
        $transform2Node = $transformsNode->appendChild(new DOMElement('Transform'));
        $transform2Node->setAttribute('Algorithm', 'http://www.w3.org/2001/10/xml-exc-c14n#');

        /** @var \DOMElement $digestMethodNode */
        $digestMethodNode = $referenceNode->appendChild(new DOMElement('DigestMethod'));
        $digestMethodNode->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#sha1');
        $referenceNode->appendChild(new DOMElement('DigestValue', $digestValue));

        $signedInfoNode = $xmlRequestDOMDoc->getElementsByTagName('SignedInfo')->item(0);
        $signatureNode = $xmlRequestDOMDoc->getElementsByTagName('Signature')->item(0);

        $signatureValueNode = new DOMElement(
            'SignatureValue',
            base64_encode($this->generateSignature($signedInfoNode))
        );
        $signatureNode->appendChild($signatureValueNode);
        $keyInfoNode = $signatureNode->appendChild(new DOMElement('KeyInfo'));
        $x509DataNode = $keyInfoNode->appendChild(new DOMElement('X509Data'));

        $x509CertificateNode = new DOMElement('X509Certificate', $this->getPublicCertificateString());
        $x509DataNode->appendChild($x509CertificateNode);
        $x509IssuerSerialNode = $x509DataNode->appendChild(new DOMElement('X509IssuerSerial'));

        $x509IssuerNameNode = new DOMElement('X509IssuerName', $this->getCertificateIssuerName());
        $x509IssuerSerialNode->appendChild($x509IssuerNameNode);

        $x509SerialNumberNode = new DOMElement('X509SerialNumber', $this->getCertificateIssuerSerialNumber());
        $x509IssuerSerialNode->appendChild($x509SerialNumberNode);

        return $this->plainXML($xmlRequestDOMDoc);
    }

    /**
     * Generate XML request
     *
     * @param DOMDocument $xmlRequest XML request to parse to plain XML
     *
     * @return string
     */
    private function plainXML($xmlRequest)
    {
        $envelope = new DOMDocument();
        $envelope->loadXML(
            '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
		    <soapenv:Body></soapenv:Body>
		</soapenv:Envelope>'
        );

        $envelope->encoding = 'UTF-8';
        $envelope->version = '1.0';
        $xmlRequestType = $xmlRequest->documentElement->localName;
        $xmlRequestTypeNode = $xmlRequest->getElementsByTagName($xmlRequestType)->item(0);
        $xmlRequestTypeNode = $envelope->importNode($xmlRequestTypeNode, true);

        $envelope->getElementsByTagName('Body')->item(0)->appendChild($xmlRequestTypeNode);

        return $envelope->saveXML();
    }

    /**
     * Send SOAP request to service
     *
     * @param string $payload Payload to send via SOAP/CURL
     *
     * @return mixed Response from API
     * @throws Exception
     */
    public function sendSoap($payload)
    {
        $options = [
            CURLOPT_URL            => $this->getUrl(),
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_SSLVERSION     => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CAINFO         => $this->getRootCertificatePath(),
        ];

        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, $options);

        $this->setLastRequest($payload);

        $response = curl_exec($curlHandle);
        $code = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        $error = curl_error($curlHandle);

        $this->setErrorCode($code);
        $this->setLastResponse($response);

        curl_close($curlHandle);

        if ($response) {
            return $this->parseResponse($response, $code);
        } else {
            throw new Exception($error);
        }
    }

    /**
     * Parse response from service
     *
     * @param string $response Response from API
     * @param int    $code     Error code from API
     *
     * @return mixed
     * @throws Exception
     */
    public function parseResponse($response, $code = 4)
    {
        $domResponse = new DOMDocument();
        $domResponse->loadXML($response);

        if ($code === 200 || $code == 0) {
            return $response;
        } else {
            $errorCode = $domResponse->getElementsByTagName('SifraGreske')->item(0);
            $errorMessage = $domResponse->getElementsByTagName('PorukaGreske')->item(0);
            $faultCode = $domResponse->getElementsByTagName('faultcode')->item(0);
            $faultMessage = $domResponse->getElementsByTagName('faultstring')->item(0);

            if ($errorCode && $errorMessage) {
                throw new Exception(sprintf('[%s] %s', $errorCode->nodeValue, $errorMessage->nodeValue));
            } else {
                if ($faultCode && $faultMessage) {
                    throw new Exception(sprintf('[%s] %s', $faultCode->nodeValue, $faultMessage->nodeValue));
                } else {
                    throw new Exception(print_r($response, true), $code);
                }
            }
        }
    }

    /**
     * Signs and sends request
     *
     * @param  Request $xmlRequest
     *
     * @return mixed
     */
    public function sendRequest($xmlRequest)
    {
        $payload = $this->signXML($xmlRequest->toXML());

        return $this->sendSoap($payload);
    }
}

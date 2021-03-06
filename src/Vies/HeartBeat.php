<?php
/**
 * \DragonBe\Vies
 *
 * Component using the European Commission (EC) VAT Information Exchange System (VIES) to verify and validate VAT
 * registration numbers in the EU, using PHP and Composer.
 *
 * @author Michelangelo van Dam <dragonbe+github@gmail.com>
 * @license MIT
 *
 */
namespace DragonBe\Vies;
/**
 * Class HeartBeat
 *
 * This class provides a simple but essential heartbeat cheack
 * on the VIES service as it's known to have availability issues.
 *
 * @category DragonBe
 * @package \DragonBe\Vies
 * @link http://ec.europa.eu/taxation_customs/vies/faqvies.do#item16
 */
class HeartBeat
{
    /**
     * @var string The host you want to verify
     */
    protected $host;
    /**
     * @var int The port you want to verify
     */
    protected $port;

    /**
     * @var bool Allow the service to be tested without integration of sockets
     */
    public static $testingEnabled = false;

    /**
     * @var bool Allow to define the validation return setting
     */
    public static $testingServiceIsUp = true;

    /**
     * @param string|null $host
     * @param int $port
     */
    function __construct($host = null, $port = 80)
    {
        if (null !== $host) {
            $this->setHost($host);
        }
        $this->setPort($port);
    }

    /**
     * @return string
     */
    public function getHost()
    {
        if (null === $this->host) {
            throw new \DomainException('A host is required');
        }
        return $this->host;
    }

    /**
     * @param string $host
     * @return HeartBeat
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return HeartBeat
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * Checks if the VIES service is online and available
     */
    public function isAlive()
    {

        $status = $this->connect($this->getHost(), $this->getPort());
        if (false === $status) {
            return false;
        }
        return true;
    }

    /**
     * Make a connection outwards to test an online service
     *
     * @param $host
     * @param $port
     * @return bool|resource
     * @private
     */
    private function connect($host, $port)
    {
        $status = HeartBeat::$testingServiceIsUp;
        if (false === HeartBeat::$testingEnabled) {
            $status = fsockopen($host, $port);
        }
        return $status;
    }
}

<?php

namespace Egate\EgateOtp\Classes;

use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Egate\EgateOtp\Modles\EgateOtp;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthenticationProvider
{
    protected $engine;

    public function __construct(Google2FA $engine)
    {
        $this->engine = $engine;
    }

    public function generateSecretKey()
    {
        return $this->engine->generateSecretKey();
    }

    public function generateRecoveryCodes($times = 8, $random = 10)
    {
        return Collection::times($times, function () use ($random) {
            return Str::random($random).'-'.Str::random($random);
        })->toArray();
    }

    public function qrCodeUrl(string $companyName, string $companyEmail, string $secret)
    {
        return $this->engine->getQRCodeUrl($companyName, $companyEmail, $secret);
    }

    public function verify(string $secret, string $code, $Slots = Null )
    {
        return $this->engine->verifyKey($secret, $code, $Slots);      //$Slots   x  * 30 seconds
    }

    public function getFreshCode(EgateOtp $egtaeOtp)
    {
        $secret = decrypt($egtaeOtp->code);
        return $this->GenerateValidOTP($secret);
    }

    /**
     * Find a valid One Time Password.
     *
     * @param string $secret
     * @return bool|int
     */
    public function GenerateValidOTP($secret)
    {

        $startingTimestamp = $this->makeCurretTimestamp();
        return $this->engine->oathTotp($secret, $startingTimestamp);

    }

    /**
     * Get/use a starting timestamp for key verification.
     *
     * @param string|int|null $timestamp
     *
     * @return int
     */
    protected function makeCurretTimestamp($timestamp = null)
    {
        if (is_null($timestamp)) {
            return $this->engine->getTimestamp();
        }

        return (int)$timestamp;
    }


    public function twoFactorQrCodeSvg($URL)
    {
        $svg = (new Writer(
            new ImageRenderer(
                new RendererStyle(config('egate-otp.qr_code_size'), 0, null, null, Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(45, 55, 72))),
                new SvgImageBackEnd
            )
        ))->writeString($URL);

        return trim(substr($svg, strpos($svg, "\n") + 1));
    }

}

<?php

namespace Egate\EgateOtp;

class EgateOtp
{


    public function getFreshCode(\Egate\EgateOtp\Modles\EgateOtp $egate_otp){
        return app(MFA::class)->getFreshCode($egate_otp);
    }




}

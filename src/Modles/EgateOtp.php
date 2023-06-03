<?php

namespace Egate\EgateOtp\Modles;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class EgateOtp extends Model
{

    use HasUuids;
    protected $table = 'egate_otps';

    protected $fillable = [
        'code',
        'active',
    ];

    protected $casts = [
        'code'=>'encrypted',
        'active'=>'boolean',
    ];


    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'EgateOtp';


    public function otpable()
    {
        return $this->morphTo('otpable');
    }
}

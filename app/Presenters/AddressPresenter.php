<?php

namespace App\Presenters;

use App\Models\Address;
use DB;

class AddressPresenter
{
    public function getStateName(Address $address)
    {
        $state = DB::table('states')->find($address->state_id);
        if (empty($state)) {
            return '';
        }
        return $state->name;
    }

}
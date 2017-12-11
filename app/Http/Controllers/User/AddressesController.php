<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressesController extends Controller
{
    protected $response = [
        'code' => 1,
        'msg' => 'Server error. Please try again later',
    ];

    public function index()
    {
        $addresses = $this->guard()->user()->addresses;

        $states = DB::table('states')->get();
        // $cities = DB::table('cities')->where('state_id', $states->first()->id)->get();

        return view('user.addresses.index', compact('addresses', 'states'));
    }


    public function store(AddressRequest $request)
    {
        $addressesData = $this->getFormatRequest($request);
        $this->guard()->user()->addresses()->create($addressesData);

        return back()->with('status', 'Added successfully');
    }


    public function show(Address $address)
    {
        return $address;
    }


    public function edit(Address $address)
    {
        $addresses = $this->guard()->user()->addresses;

        $states = DB::table('states')->get();

        return view('user.addresses.edit', compact('addresses', 'address', 'states'));
    }


    public function update(AddressRequest $request, Address $address)
    {
        $this->checkPermission($address->user_id);

        $addressesData = $this->getFormatRequest($request);

        $address->update($addressesData);

        return back()->with('status', 'Modified successfully');
    }

    public function destroy(Address $address)
    {
        if (!$this->owns($address->user_id)) {
            return $this->response;
        }

        if ($address->delete()) {
            $this->response = ['code' => 0, 'msg' => 'Deleted successfully'];
        }

        return $this->response;
    }

    public function setDefaultAddress(Address $address)
    {
        if (! $this->owns($address->user_id)) {
            return $this->response;
        }

        Address::where('user_id', $address->user_id)->update(['is_default' => 0]);
        $address->is_default = 1;

        if ($address->save()) {
            $this->response = [
                'code' => 0,
                'msg' => '设置成功',
            ];
        }

        return $this->response;
    }

    protected function checkPermission($userID)
    {
        if (! $this->owns($userID)) {
            abort(404, 'You do not have permission');
        }
    }

    protected function owns($userID)
    {
        return $this->guard()->user()->id == $userID;
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function getFormatRequest($request)
    {
        return $request->only(['first_name', 'last_name', 'phone', 'country', 'zipcode', 'state_id', 'city', 'addr',]);
    }


    public function getCities($id)
    {
        return DB::table('cities')->where('state_id', $id)->get();
    }

    public function getRegion($id)
    {
        return DB::table('regions')->where('city_id', $id)->get();
    }
}

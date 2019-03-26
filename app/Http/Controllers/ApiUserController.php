<?php namespace App\Http\Controllers;
use App\User;
class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::get();
    }

    /**
     * Return rentals for a particular customer
     * @param $id
     * @return int
     */
    public function rentals($id)
    {
        $rentals = User::where('id', $id)
            ->with('rentals')
            ->get();

        return $rentals;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }
}

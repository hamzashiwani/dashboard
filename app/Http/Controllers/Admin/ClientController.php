<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $contact_us;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Client $contact_us)
    {
        $this->middleware('auth:admin');
        $this->contact_us = $contact_us;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = $this->contact_us->allContact();
            return view('admin.client.index', compact('data'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data = $this->contact_us->findContact($id);
        return view('admin.client.show', compact('data'));
    }


    public function destroy($id)
    {
        try {
            $contact_us = $this->contact_us->deleteContact($id);
            return redirect()
                ->route('admin.client.index')
                ->with('success', 'Contact Us has been deleted successfully.');
        }catch (\Exception $exception) {
            return redirect()
                ->back()
                ->with('error', $exception->getMessage());
        }
    }
}

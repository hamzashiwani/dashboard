<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{
    private $contact_us;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $url = 'https://andrea.thecodifiedlab.co.uk/wp-json/custom/v1/bookly-logs';

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
            curl_setopt($ch, CURLOPT_HTTPGET, true); // Specify the request type as GET
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo 'cURL error: ' . curl_error($ch);
            } else {
                $data = json_decode($response, true); // Output the response data
            }

            curl_close($ch);
            return view('admin.log.index', compact('data'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $data = $this->contact_us->findContact($id);
        return view('admin.log.show', compact('data'));
    }


    public function destroy($id)
    {
        try {
            $contact_us = $this->contact_us->deleteContact($id);
            return redirect()
                ->route('admin.log.index')
                ->with('success', 'Contact Us has been deleted successfully.');
        }catch (\Exception $exception) {
            return redirect()
                ->back()
                ->with('error', $exception->getMessage());
        }
    }
}

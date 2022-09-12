<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Email;
use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Email::orderBy('updated_at', 'desc');

        // If something in search, then process more
        $searched = request()->s;
        if (!empty($searched)) {
            $query->where('email', 'like', '%' . $searched .'%');
        }

        $emails = $query->paginate(10);
        return view('emails.index', compact('emails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailRequest $request)
    {
        $emails = explode(',' , $request->emails);
        $validEmails = [];
        $total = 0;

        foreach($emails as $emailString) {
            $emailString = trim($emailString);
            if(filter_var($emailString , FILTER_VALIDATE_EMAIL)){
                if(!Email::where('email' ,$emailString)->limit(1)->exists()){
                    $validEmails[] = [
                        'email' => $emailString,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    $total++;
                } 
            }
        }
        
        if ($total > 0) {
            // Save in DB
            Email::insert($validEmails);
        }

        if ($total > 0) {
            session()->flash('success', 'Emails have been added. Total added emails: ' . $total);
        } else {
            session()->flash('error', 'Sorry, No valid emails found.');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        if ($email) {
            $email->delete();
            session()->flash('success', 'Email has been deleted successfully !');
        }
        return back();
    }
}

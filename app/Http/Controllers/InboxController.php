<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Inbox;
use Illuminate\Http\Request;
use Faker;
use DB;
use Auth;
use App\Contact;

class InboxController extends Controller {

    /**
     * Display list of messages received
     * @return response
     */
	public function index()
    {

        $data['inbox'] = DB::table('contact')
                                                ->select('inbox.number as inboxNumber','inbox.smsdate','inbox.insertdate','inbox.text','contact.name','contact.number as contactNumber')
                                                ->rightJoin('inbox', 'inbox.number', '=', 'contact.number')
                                                ->paginate(30);
        $data['active'] = 'inbox';
        return view('inbox.index', $data);
    }

}

<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Outbox;
use Illuminate\Http\Request;
use Faker;
use DB;
use Auth;
use App\Contact;

class OutboxController extends Controller {

    /**
     * Display list of messages received
     * @return response
     */
	public function index()
    {

        $data['outbox'] = DB::table('contact')
                                                ->select('outbox.number as outboxNumber','outbox.insertdate','outbox.text','contact.name','contact.number as contactNumber')
                                                ->rightJoin('outbox', 'outbox.number', '=', 'contact.number')
                                                ->orderBy('insertdate', 'desc')
                                                ->paginate(30);
        $data['active'] = 'outbox';
        return view('outbox.index', $data);
    }

}

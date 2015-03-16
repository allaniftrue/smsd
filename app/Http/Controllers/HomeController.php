<?php namespace App\Http\Controllers;

use App\Inbox;
use App\Outbox;
use App\Contact;
use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['active'] = 'home';
		$data['existingContacts'] = Contact::all();
		return view('home', $data);
	}

	public function sendMessage()
	{
		$data['active'] = 'home';
		$data['existingContacts'] = Contact::all();
		$validator = Validator::make(
		    [
		        'number'	=> Input::get('number'),
		        'message'	=> Input::get('message')
		    ],
		    [
		        'number' 	=> 'required|digits:11',
		        'message' 	=> 'required|max:150'
		    ]
		);

		if ($validator->fails()) {
			return view('home', $data)->withErrors($validator->errors());
		} else {

			$outbox = new Outbox;
			$outbox->user_id = Auth::id();
			$outbox->number = Input::get('number');
			$outbox->text = Input::get('message');

			if($outbox->save()) {
				$message = '<div class="alert alert-success" role="alert"><strong>Oh yeah!</strong> Your SMS has been scheduled.</div>';
			} else {
				$message = '<div class="alert alert-danger" role="alert"><strong>Oh snap!</strong> Unable to save and send your SMS.</div>';
			}

			return redirect('/')->with('message', $message);
		}
	}

	/**
	 * Show inbox data
	 *
	 * @return Response
	 */
	public function getInbox()
	{
		$data['active'] = 'home';
		$data['result'] =  DB::select( DB::raw("
													SELECT * FROM contact
													RIGHT JOIN inbox ON inbox.number = contact.number
													GROUP BY inbox.number
													ORDER BY inbox.smsdate DESC
											")
							);

		return view('inbox', $data);
	}

	public function getConversation($phoneNumber)
	{

	}

}

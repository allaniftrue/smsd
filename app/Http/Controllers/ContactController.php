<?php namespace App\Http\Controllers;

use App\Contact;
use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ContactController extends Controller {

    public function index()
    {
        $data['contacts'] = DB::table('contact')->orderBy('name', 'asc')->paginate(30);

        return view('contacts.index', $data);
    }

    /**
     * Search contact table based on kw
     * @param  string $kw search keyword
     * @return json     returns query result
     */
    public function search($kw=NULL)
    {
        $data['contacts'] = DB::table('contact')->where('name', 'like', '%'.Input::get('kw').'%')->orWhere('number', 'like', '%'.Input::get('kw').'%')->paginate(30);

        return view('contacts.index', $data);
    }

    /**
     * Prepare form based on phone number from url
     * @param  int $phoneNumber user's phone number
     * @return json              show's prepared form
     */
    public function prepare($phoneNumber=NULL)
    {

        $data['existingContacts'] = Contact::all();

        if(! empty($phoneNumber)) {

            $validator = Validator::make(
                [
                    'phoneNumber'    => $phoneNumber
                ],
                [
                    'phoneNumber'    => 'required|digits:11'
                ]
            );

            $data['numberExist'] = $phoneNumber;

            if ($validator->fails()) {
                return view('home', $data)->withErrors($validator->errors());
            }
        }

        return view('home', $data);

    }

    /**
     * Store new contact
     * @return json returns error else message
     */
    public function store()
    {
        // $data['contacts'] = DB::table('contact')->paginate(30);

        $validator = Validator::make(
            [
                'number'    => Input::get('number'),
                'name'      => Input::get('name')
            ],
            [
                'number'    => 'required|digits:11|unique:contact,number',
                'name'      => 'required|max:150|unique:contact,name'
            ]
        );

        if ($validator->fails()) {

            return redirect('contacts')->withErrors($validator->errors())->withInput();

        } else {

            $contact = new Contact;
            $contact->user_id = Auth::id();
            $contact->name = Input::get('name');
            $contact->number = Input::get('number');

            if($contact->save()) {
                $message = '<div class="alert alert-success" role="alert"><strong>Oh yeah!</strong> New contact number saved.</div>';
            } else {
                $message = '<div class="alert alert-danger" role="alert"><strong>Oh snap!</strong> Unable to save contact number.</div>';
            }

            return redirect('contacts')->with('message', $message);
        }
    }

    /**
     * Completely removes data from the database
     * @return json returns result
     */
    public function destroy()
    {

        $contact = Contact::find(Input::get('id'));

        if($contact->delete()) {
            $array = ['status'=>1];
        } else {
            $array = ['status'=>0];
        }

        return response()->json($array);
    }

}

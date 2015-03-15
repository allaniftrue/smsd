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
        $data['inbox'] = Inbox::orderBy('insertdate', 'desc')->paginate(30);

        return view('inbox.index', $data);
    }

    public function faker()
    {
        $faker = Faker\Factory::create();
        $c = new Contact;
        $c->user_id = Auth:id();

        for($x=0; $x<100; $x++) {

            $c->name = $faker->name;
            $c->number = $faker->numerify("###########");

            $c->save();
        }
        return 'end';
    }

}

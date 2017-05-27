<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use Auth;

class BlogController extends Controller
{

    /**
     *
     */
    public function __construct()
    {
        if(!Auth::check()) {
            return redirect(action('Auth\LoginController@getLogin'));
        }
    }

	/**
	 * 
	 */
    public function index()
    {
    	return view('home');
    }

    /**
     * 
     */
    public function manageContent()
    {
    	return view('manage-content');
    }

    /**
     * 
     */
    public function postAddArticle(Request $request)
    {
    	$title = $request->get('title');
        $body = $request->get('body');

        $blogPost = BlogPost::create([

            'title' => $title,
            'body' => $body,
            'user_id' => Auth::id() ? : 1,

        ]);

        return redirect(action('BlogController@index'));

    }
}

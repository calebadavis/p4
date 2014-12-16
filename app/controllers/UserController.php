<?php

class UserController extends BaseController {

    public function __construct() {

        parent::__construct();

        /* This filter causes login and signup to be only accessible to guest users */
        $this->beforeFilter('guest', array('only' => array('getLogin','getSignup')));

    }


    /**
     * Show the new user signup form
     * @return View
     */
    public function getSignup() {

        $galleries = Gallery::all();
        return View::make(
            'signup', 
            array(
                'navInfo'=>Gallery::navInfo("signup"),
                'galleries'=>$galleries
            )
        );
    }

    /**
     * Process the new user signup
     * @return Redirect
     */
    public function postSignup() {

        $rules = array(
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()) {
            return Redirect::to('/signup')
                ->with('flash_message', 'Sign up failed; please fix the errors listed below.')
                ->withInput()
                ->withErrors($validator);
        }

        $user = new User();
        $user->email      = Input::get('email');
        $user->password   = Hash::make(Input::get('password'));
        $user->first_name = Input::get('first_name');
        $user->last_name  = Input::get('last_name');

        try {

            $user->save();

        } catch (Exception $e) {

            return Redirect::to('/signup')
                ->with('flash_message', 'Sign up failed; please try again.')
                ->withInput();

        }

        Auth::login($user);

        return Redirect::to('/')->with('flash_message', 'Welcome to Lily Sprite Images!');

    }

    /**
     * Display the login form
     * @return View
     */
    public function getLogin() {

        return View::make(
            'login',
            array(
                'navInfo'=>Gallery::navInfo("login"),
                'galleries'=>Gallery::all()
            )
        );
    }

    /**
     * Process the login form
     * @return View
     */
    public function postLogin() {

        $reset = Input::get("reset-password");

	if ($reset == 'reset') {
		switch ($response = Password::remind(Input::only('email')))
		{
			case Password::INVALID_USER:
				return Redirect::back()->with('flash_message', Lang::get($response));

			case Password::REMINDER_SENT:
				return Redirect::back()->with('flash_message', Lang::get($response));
		}

        }

        $credentials = Input::only('email', 'password');

        if (Auth::attempt($credentials, $remember = true)) {
            return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
        } else {
            return Redirect::to('/login')->with('flash_message', 'Log in failed; please try again.');
        }

    }


    /**
     * Logout
     * @return Redirect
     */
    public function getLogout() {

        Auth::logout();
        return Redirect::to('/');

    }

}
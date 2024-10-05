## Todo:
- Implementation of Guidance Role
  - UI (Pending)
  - Migrations (Table)
  - Back-end (Logic)
    - update SA Account logic:
      - for task voluntary and autohandle -> cannot received tasks if under probation period for MAJOR OFFENSE

- UI Upgrades and Implementation
  - Ongoing UI Changes:
    - DO
      - Main Background
      - Side Nav
      - Tables
      - Colors
    - Guidance (New)
    - ALL
      - Center all Headers to center
  - Change UI DONE:
    - Student Assistant
      - UI 
    - Office
      - UI
    - Guidance
      - Dashboard (New)

- (fix): ROUTE??

- To Test:
  - Student Assistant:
    - Timein/Timeout 
  - Office:
    - ADD Task Automation
    - SA Task List Review


## Revisions

### Background: 
Kaya nagiging SA/student assistant ang isang student, dahil sa scholarship niya. Kapag natanggal yung scholarship, hindi na siya magiging part SA.

### Added Module/Features: 
Check  scholarship status BEFORE assigning tasks to SAs 

### New User: Guidance Office 
- Dashboard 
- Probation Page: Shows lists SAs with 0.0 at the end of school year
- Revoke Scholarship page: Shows lists SAs with 0.0 for TWO CONSECUTIVE school YEARS
- Revoke Scholarship page: Enter his/her verdict on SA's scholarship status; "probation", "remove scholarship"

### New features on SA Manager Side:
- Dashboard
- Can Add Major Offense: name, type of offense, offense status, duration(can add only if offense status is "probation")
- Probation Page: Track students with probation for major offenses
- Revoke Scholarship Page: Enter his/her verdict on SA's scholarship status; "probation", "remove scholarship"

### New features on SA:
- Account is deactivated once guidance/sa manager revoked SA's scholarship
- Account cannot received tasks if under probation period for MAJOR OFFENSE
- Account can still receive tasks and be opened when under probation for 0.0 GRADE

### Database: 
- Add new tables for grades and major offenses...(?) (Not "?" Yes we need this)


# Code References

## SATasker\vendor\laravel\ui\auth-backend\AuthenticatesUsers.php

```
<?php

namespace Illuminate\Foundation\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm($id)
    {


        $portalNames = [
            'student-assistant' => 'Student Assistant',
            'office' => 'Office Admin',
            'do' => 'Sa Manager',
            'guidance' => 'Guidance Office',
        ];
        // Set the login name based on the provided ID or default to 'Unknown Portal'
        $portalName = $portalNames[$id] ?? 'Unknown Portal';

        // Optionally, you could log a warning or redirect if the portal is unknown
        if ($portalName === 'Unknown Portal') {
            // Log warning, redirect or handle this scenario
            // dd("Unknown login ID: $portalNames[$id]"); // Example logging (if you use logging)
            abort(404); // Or redirect to a 404 page
        }

        return view('auth.login', compact('portalName'));
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $user = User::withTrashed()->where('email', $request->email)->first();

        // dd($user);

        // Check if the user is soft deleted
        if ($user->trashed()) {
            Auth::logout();
            return redirect()->back()->withErrors(['email' => 'Your account has been deactivated.']);
        }

        $portalSnake = Str::snake($request->portal_details);
        $role = $user->getRoleNames()->first();
        if ($portalSnake !== $role) {
            return redirect()->route('landing')->with('error', 'Entered Wrong Portal');
        }

        // dd($portalSnake == $role , $portalSnake, $role);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}

```

<?php

namespace App\Http\Controllers\Api;

use Mail;
use JWTAuth;
use Stripe\Stripe;
use App\Models\User;
use App\Models\ContactUs;
use App\Models\Log;
use App\Models\Package;
use App\Models\Country;
use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use ESolution\DBEncryption\Encrypter;
use App\Http\Controllers\Api\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function signup(Request $request)
    {
        try {
            if (!empty($request)) {
                $validator = Validator::make($request->all(), [
                    'name'                => 'required|min:4',
                    'email'               => 'required|unique:users,email',
                    'password'            => 'required|min:8'
                ]);

                if ($validator->fails()) {
                    $error   = 201;
                    $data    = [];
                    $message = $validator->errors()->first();
                } else {
                    $userData['email']    = $request->email;
                    $userData['password'] = bcrypt($request->password);
                    $userData['name']     = $request->name;

                    try {
                        // Creating user's account
                        $data    = User::create($userData);
                        // Login created user.
                        $token = JWTAuth::attempt(
                            ['id' => $data->id, 'password' => $request->password]
                        );

                        $message = "User has been created successfully.";
                        $error   = 200;
                    } catch (Exception $e) {
                        // if user is created so rollback it.
                        if (isset($data->id)) {
                            User::where('id', $data->id)->delete();
                        }

                        return response()->json([
                            'statusCode' => 402,
                            'message'    => $e->getMessage(),
                            'data'       => json_decode('{}')
                        ]);
                    }
                }
            } else {
                $data    = [];
                $message = "Something went wrong, please try again later.";
                $error   = 406;
            }

            $response['statusCode']            = $error;
            $response['message']               = $message;
            $response['data']                  = (!empty($data)) ? $data : [];
            $response['data']['authorisation'] = isset($token) ? 
                ['token' => $token, 'type'  => 'bearer'] : json_decode('{}');
            $response['data']                  = (!empty($data)) ? $data : json_decode('{}');


            return response()->json($response);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }

    public function storeContact(Request $request)
    {
        try {
            if (!empty($request)) {
                $validator = Validator::make($request->all(), [
                    'name'                => 'required|min:4',
                    'email'               => 'required',
                    'phone'            => 'required'
                ]);

                if ($validator->fails()) {
                    $error   = 201;
                    $data    = [];
                    $message = $validator->errors()->first();
                } else {
                    $userData['email']    = $request->email;
                    $userData['phone'] = $request->phone;
                    $userData['first_name']     = $request->name;
                    $userData['message']     = $request->name;

                    try {
                        // Creating user's account
                        $data    = ContactUs::create($userData);
                        $message = "Contact has been created successfully.";
                        $error   = 200;
                    } catch (Exception $e) {
                        // if user is created so rollback it
                        return response()->json([
                            'statusCode' => 402,
                            'message'    => $e->getMessage(),
                            'data'       => json_decode('{}')
                        ]);
                    }
                }
            } else {
                $data    = [];
                $message = "Something went wrong, please try again later.";
                $error   = 406;
            }

            $response['statusCode']            = $error;
            $response['message']               = $message;
            $response['data']                  = (!empty($data)) ? $data : [];
            $response['data']                  = (!empty($data)) ? $data : json_decode('{}');


            return response()->json($response);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }


    public function storeLog(Request $request)
    {
        try {
            if (!empty($request)) {
                $validator = Validator::make($request->all(), [
                    'title'                => 'required|min:4',
                    'description'               => 'required',
                ]);

                if ($validator->fails()) {
                    $error   = 201;
                    $data    = [];
                    $message = $validator->errors()->first();
                } else {
                    $userData['title']    = $request->title;
                    $userData['description'] = $request->description;

                    try {
                        // Creating user's account
                        $data    = Log::create($userData);
                        $message = "Log has been created successfully.";
                        $error   = 200;
                    } catch (Exception $e) {
                        // if user is created so rollback it
                        return response()->json([
                            'statusCode' => 402,
                            'message'    => $e->getMessage(),
                            'data'       => json_decode('{}')
                        ]);
                    }
                }
            } else {
                $data    = [];
                $message = "Something went wrong, please try again later.";
                $error   = 406;
            }

            $response['statusCode']            = $error;
            $response['message']               = $message;
            $response['data']                  = (!empty($data)) ? $data : [];
            $response['data']                  = (!empty($data)) ? $data : json_decode('{}');


            return response()->json($response);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }


    public function storeClient(Request $request)
    {
        try {
            if (!empty($request)) {
                $validator = Validator::make($request->all(), [
                    'name'                => 'required|min:4',
                ]);

                if ($validator->fails()) {
                    $error   = 201;
                    $data    = [];
                    $message = $validator->errors()->first();
                } else {
                    $userData['name']    = $request->name;
                    $userData['dob'] = $request->dob;
                    $userData['address']     = $request->address;
                    $userData['postcode']     = $request->postcode;
                    $userData['mobile_number']     = $request->mobile_number;
                    $userData['email']     = $request->email;
                    $userData['surgery_name']     = $request->surgery_name;
                    $userData['contact_name']     = $request->contact_name;
                    $userData['are_you_pregnant']     = $request->are_you_pregnant;
                    $userData['any_allergies']     = $request->any_allergies;
                    $userData['reciving_medical_treatment'] = $request->reciving_medical_treatment;
                    $userData['pacemaker']     = $request->pacemaker;
                    $userData['dnr']     = $request->dnr;
                    $userData['blood_thinner']     = $request->blood_thinner;
                    $userData['current_medications']     = $request->current_medications;
                    $userData['date']     = $request->date;
                    $userData['reason']     = $request->reason;

                    $image = $request->input('patient_signature');
                    $image = str_replace('data:image/png;base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = time() . '.png'; // Or any other logic for generating image name
                    Storage::disk('public')->put($imageName, base64_decode($image));
                    $userData['patient_signature'] = $imageName; 

                    try {
                        // Creating user's account
                        $data    = Client::create($userData);
                        $message = "Client Form has been created successfully.";
                        $error   = 200;
                    } catch (Exception $e) {
                        // if user is created so rollback it
                        return response()->json([
                            'statusCode' => 402,
                            'message'    => $e->getMessage(),
                            'data'       => json_decode('{}')
                        ]);
                    }
                }
            } else {
                $data    = [];
                $message = "Something went wrong, please try again later.";
                $error   = 406;
            }

            $response['statusCode']            = $error;
            $response['message']               = $message;
            $response['data']                  = (!empty($data)) ? $data : [];
            $response['data']                  = (!empty($data)) ? $data : json_decode('{}');


            return response()->json($response);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }

    public function backgroundLogin(Request $request)
    {
        try {
            $user = JWTAuth::authenticate();

            if (!$user) {
                return response()->json([
                    'statusCode' => 404,
                    'message'    => "Could not found user, please try again.",
                    'data'       => json_decode('{}')
                ]);
            }

            return [
                'statusCode' => 200,
                'data'       => $user,
                'message'    => 'Login successful.'
            ];
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }

    public function forgetPassword(Request $request)
    {
        try {
            if (isset($request->email)) {
                $user = User::whereEncrypted('email', $request->email)->first();

                if ($user) {
                    $reset['token'] = rand(11111111, 99999999);

                    $update = User::whereId($user->id)->update([
                        'password'           => bcrypt($reset['token']),
                        'is_using_temp_pass' => 1
                    ]);

                    if ($update) {
                        // if user input email
                        Mail::send(
                            'emails.front.reset-password', 
                            ['data' => $reset],
                            function ($message) use ($user) {
            
                                $email = $user->email;
                                $message->to($email, $email);
                                if (config('mail.bcc.address') != '') {
                                    $message->bcc(config('mail.bcc.address'), config('mail.bcc.name'));
                                }

                                $message->replyTo(config('mail.from.address'), config('mail.from.name'));
                                $subject = "Reset Password.";
                                $message->subject($subject);
                            }
                        );

                        $data    = [];
                        $error   = 200;
                        $message = "Temporary password has been sent to your email.";

                    } else {
                        $error   = 500;
                        $data    = [];
                        $message = "Something went wrong, please try again later!";
                    }
                } else {
                    $error   = 404;
                    $data    = [];
                    $message = "Could not found user, please provide valid email.";
                }
            } else {
                $error   = 406;
                $data    = [];
                $message = "Please enter email.";
            }

            return response()->json([
                'statusCode' => $error,
                'message'    => $message,
                'data'       => (!empty($data)) ? $data : json_decode('{}')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            if (isset($request->email) && isset($request->temporary_password)) {
                $resetData = User::whereEncrypted('email', $request->email)->first();

                if (!$resetData) {
                    return response()->json([
                        'statusCode' => 404,
                        'message'    => "email is invalid!",
                        'data'       => json_decode('{}')
                    ]);
                }

                if (Hash::check($request->temporary_password, $resetData->password)) {

                    $validator = Validator::make($request->all(), [
                        'new_password'     => 'required_with:confirm_password|min:8|same:confirm_password',
                        'confirm_password' => 'min:8'
                    ]);

                    if ($validator->fails()) {
                        $error   = 201;
                        $message = $validator->errors()->first();
                        $data    = [];
                    } else {

                        User::whereEncrypted('email', $request->email)->update([
                            'password'           => bcrypt($request->new_password),
                            'is_using_temp_pass' => 0
                        ]);

                        $data    = User::whereEncrypted('email', $request->email)->first();
                        $error   = 200;
                        $message = "Password has been reset successfully.";
                    }

                } else {
                    $data    = [];
                    $error   = 406;
                    $message = "Temporary password is incorrect!";
                }

            } else {
                $error   = 404;
                $data    = [];
                $message = "Please enter email and Temporary password.";
            }

            return response()->json([
                'statusCode' => $error,
                'message'    => $message,
                'data'       => (!empty($data)) ? $data : json_decode('{}')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            if (!empty($request)) {
                $validator = Validator::make($request->all(), [
                    'email'    => 'required',
                    'password' => 'required',
                ]);

                if ($validator->fails()) {
                    $error   = 201;
                    $data    = [];
                    $message = $validator->errors()->first();
                } else {
                    $user = User::whereEncrypted('email', $request->email)->first();

                    if (!$user) {
                        return response()->json([
                            'statusCode' => 404,
                            'message'    => "User does not exist, please enter valid email",
                            'data'       => json_decode('{}')
                        ]);
                    }

                    $token = JWTAuth::attempt(
                        ['id' => $user->id, 'password' => $request->password]
                    );

                    if (Hash::check($request->password, $user->password)) {

                        $data    = $user;
                        $error   = 200;
                        $message = "Login successful.";
                    } else {
                        $data    = [];
                        $error   = 406;
                        $message = "Password is incorrect!";
                    }
                }
            } else {
                $data    = [];
                $message = "Something went wrong, please try again later.";
                $error   = 406;
            }

            $response['statusCode'] = $error;
            $response['message']    = $message;
            $response['data']       = (!empty($data)) ? $data : json_decode('{}');

            if (isset($token) && $token != '') {
                $response['data']['authorisation'] = [
                    'token' => $token,
                    'type'  => 'bearer',
                ];
            }

            return response()->json($response);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'email' => 'required',
                'name'  => 'required|max:32'
            ]);

            if ($validator->fails()) {
                $error   = 201;
                $message = $validator->errors()->first();
                $data    = [];
            } else {
                $userData['email'] = Encrypter::encrypt($request->email);
                $userData['name']  = Encrypter::encrypt($request->name);

                $checkUser = JWTAuth::authenticate();
                User::whereId($checkUser->id)->update($userData);

                $data    = User::whereId($checkUser->id)->first();
                $error   = 200;
                $message = "Profile has been updated successfully.";

                $data['authorisation'] = [
                    'token' => $request->bearerToken(),
                    'type'  => 'bearer',
                ];
            }

            return response()->json([
                'statusCode' => $error,
                'message'    => $message,
                'data'       => (!empty($data)) ? $data : json_decode('{}')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'new_password'     => 'required_with:confirm_password|min:8|same:confirm_password',
                'confirm_password' => 'min:8'
            ]);

            if ($validator->fails()) {
                $error   = 201;
                $message = $validator->errors()->first();
                $data    = [];
            } else {
                $checkUser    = JWTAuth::authenticate();

                User::whereId($checkUser->id)->update(
                    ['password' => bcrypt($request->new_password)]
                );

                $data    = [];
                $error   = 200;
                $message = "Password has been updated successfully.";
            }

            return response()->json([
                'statusCode' => $error,
                'message'    => $message,
                'data'       => (!empty($data)) ? $data : json_decode('{}')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }

    public function viewProfile(Request $request)
    {
        try {
            $user = JWTAuth::authenticate();

            if ($user) {
                $error              = 200;
                $data               = $user;
                $message            = 'Your profile has been retrieved successfully.';
            } else {
                $error   = 406;
                $data    = [];
                $message = "Could not found user, please provide valid email.";
            }

            return [
                'statusCode' => $error,
                'data'       => (!empty($data)) ? $data : json_decode('{}'),
                'message'    => $message
            ];
        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {

            $user = JWTAuth::authenticate();
            JWTAuth::invalidate($request->bearerToken());

            return response()->json([
                'statusCode' => 200,
                'message'    => 'User has been logged out successfully.',
                'data'       => json_decode('{}')
            ]);

        } catch (Exception $e) {
            return response()->json([
                'statusCode' => 500,
                'message'    => $e->getMessage(),
                'data'       => json_decode('{}')
            ]);
        }
    }
}

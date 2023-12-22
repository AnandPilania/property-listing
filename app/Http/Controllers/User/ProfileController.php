<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = auth()->user();
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view($this->activeTemplate . 'user.profile_setting', compact('pageTitle', 'user', 'countries'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required' => 'Last name field is required'
        ]);

        $user = auth()->user();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;

        $user->address = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
            'gender' => $request->gender,
            'pet_ownership' => $request->pet_ownership,
            'ethnicity' => $request->ethnicity,
            'nationality' => $request->nationality,
            'bio' => $request->bio,
        ];

        $user->save();
        $notify[] = ['success', 'Profile has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $passwordValidation = Password::min(6);
        $general = gs();
        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $passwordValidation]
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changes successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }


    public function profileUpdate(Request $request)
    {
        $this->validate($request, [

            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
        $user = auth()->user();
        if ($request->hasFile('image')) {
            try {
                $old = $user->image;
                $user->image = fileUploader($request->image, getFilePath('UserProfile'), getFileSize('UserProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->save();
        $notify[] = ['success', 'Profile has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function profileKYC(Request $request)
    {
        $this->validate($request, [
            'doc' => ['required', 'file', new FileTypeValidate(['jpg', 'jpeg', 'png', 'pdf'])],
            'doc_type_' => 'required',
        ]);
        $user = auth()->user();
        if ($request->hasFile('doc')) {
            try {
                $user->doc_kyc_document_type = $request->doc_type_;
                $user->doc_kyc_status = 'pending';
                $user->doc_kyc_doc_file = fileUploader($request->doc, getFilePath('UserProfile'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your KYC image'];
                return back()->withNotify($notify);
            }
        }

        $user->save();
        $notify[] = ['success', 'KYC has been updated successfully, please await our response.'];
        return back()->withNotify($notify);
    }
}

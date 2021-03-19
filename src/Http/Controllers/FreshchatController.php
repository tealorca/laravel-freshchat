<?php

namespace TealOrca\LaravelFreshchat\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FreshchatController extends Controller
{
    /**
     * Store Freshchat Restore ID to User
     */
    public function storeFreshchatUserId(Request $request)
    {
		$response = array();
		$response['success'] = false;
		$response['message'] = '';

		if ($request->has('restoreId')) {

			$freshchatRestoreId = $request->restoreId;

			$laravelUser = auth()->user();

			if(isset($freshchatRestoreId) && isset($laravelUser) && isset($laravelUser->id)){
				if (method_exists($laravelUser, $method = 'setFreshchatRestoreId')) {
					$laravelUser = $laravelUser->{$method}($freshchatRestoreId);
				}
			}

			if (method_exists($laravelUser, $method = 'getFreshchatRestoreId')) {

				$userRestoreId = $laravelUser->{$method}();

				if(isset($userRestoreId)){
					$response['success'] = true;
					$response['message'] = __('saved successfully');
				}
			}
		}

		return response()->json($response);
    }
}

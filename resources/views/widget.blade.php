@php
$authUser = auth()->user();

$authUserExist = (isset($authUser) && isset($authUser->id));

$widgetInitDetails = $authUserExist ? $authUser->getFreshchatUserWidgetInitDetails() : array(
	'token' => config('laravel-freshchat.token', null),
	'host' => config('laravel-freshchat.host', null)
);

@endphp

@if(isset($widgetInitDetails['token'])&& isset($widgetInitDetails['host']) )

	<script>
	/*
	https://developers.freshchat.com/web-sdk/
	https://developers.freshchat.com/web-sdk/#restore-user
	*/

	if(!window.laravelFreshchat) {

		window.laravelFreshchat = {};
		window.laravelFreshchat.widgetInitDetails = @json($widgetInitDetails,JSON_UNESCAPED_SLASHES);
		@if($authUserExist)
		window.laravelFreshchat.userRestoreId   = @json($authUser->getFreshchatRestoreId());
		@endif
		@if($authUserExist)
		window.laravelFreshchat.userProperties = @json($authUser->getFreshchatUserProperties(),JSON_UNESCAPED_SLASHES);
		@endif

		@if($authUserExist)

		window.laravelFreshchat.storeFreshchatUserId = function (fcResponse) {

			if(!window.laravelFreshchat.userRestoreId) {

				var fcData = fcResponse && fcResponse.data;

				if (fcData.restoreId) {

					var freshchatStoreUrl = '{{ route('user.storeFreshchatUserId') }}';

					var appHttp = new XMLHttpRequest();
					appHttp.open('POST', freshchatStoreUrl, true);

					//Send the proper header information along with the request
					appHttp.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');       
					appHttp.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
					appHttp.setRequestHeader('Accept', 'application/json');

					appHttp.onreadystatechange = function() {//Call a function when the state changes.
						if(appHttp.readyState == 4 && appHttp.status == 200) {
							console.log(appHttp.responseText);
						}
					}
					appHttp.send(JSON.stringify(fcData));
				}
			}
    	};
    	@endif

	}

	if(window.laravelFreshchat) {

		function initFreshChat() {

			window.fcWidget.init(window.laravelFreshchat.widgetInitDetails);

			@if($authUserExist)

			window.fcWidget.user.get(function(resp) {
				var status = resp && resp.status,
					data = resp && resp.data;

				if (status !== 200) {

					window.fcWidget.user.setProperties(window.laravelFreshchat.userProperties);

					window.fcWidget.on('user:created', function(resp) {
						var status = resp && resp.status,
							data = resp && resp.data;

						if (status === 200) {
							if (data.restoreId) {
								// Update restoreId in your database
								window.laravelFreshchat.storeFreshchatUserId(resp);
							}
						}
					});
				}

				if (status === 200) {
					if (data.restoreId) {
						// Update restoreId in your database
						window.laravelFreshchat.storeFreshchatUserId(resp);
					}
				}
			});
			@endif

		}

		function initialize(i,t){var e;i.getElementById(t)?initFreshChat():((e=i.createElement("script")).id=t,e.async=!0,e.src= window.laravelFreshchat.widgetInitDetails.host + "/js/widget.js",e.onload=initFreshChat,i.head.appendChild(e))}

		function initiateCall(){initialize(document,"freshchat-js-sdk")}

		window.addEventListener?window.addEventListener("load",initiateCall,!1):window.attachEvent("load",initiateCall,!1);
	}

	</script>

@endif
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <div class="alert alert-success" id="sentSuccess" style="display: none;"></div>
        <form id="phone_number_form">
            <label>Enter Phone Number:</label>
            <x-input class="block mt-2 mb-2 w-full" id="number" type="text" name="phone" placeholder="+91********" required autofocus />
            <div id="recaptcha-container"></div>
            <button type="button" style="background-color: #0b5ed7;" class="mt-2 btn btn-primary" onclick="phoneSendAuth();">SendCode</button>
        </form>

        <div class="alert alert-success" id="successRegsiter" style="display: none;"></div>
        <form id="verify_code_form"  style="display: none;">
            <label>Enter Verification code :</label>
            <x-input class="block mt-2 mb-2 w-full" id="verificationCode" type="text" name="phone" placeholder="Enter verification code" required autofocus />
            <button type="button" class="btn btn-success" style="background-color: #157347;" onclick="codeverify();">Verify code</button>  
        </form>
        <form method="POST" action="{{ route('login') }}" id="login_form" style="display: none;">
            @csrf
            <x-input class="block mt-1 w-full" type="hidden" id="phone" name="phone" :value="old('phone')" required autofocus />

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

<script>
    var firebaseConfig = {
        apiKey: "AIzaSyBvMVptOXTP7qvsAebDxIZCewFsliZjx8E",
        authDomain: "mobile-message-aae25.firebaseapp.com",
        projectId: "mobile-message-aae25",
        storageBucket: "mobile-message-aae25.appspot.com",
        messagingSenderId: "425620651384",
        appId: "1:425620651384:web:840768f11134927dfd9c8d"
    };

    firebase.initializeApp(firebaseConfig);
</script>

<script type="text/javascript">
    window.onload = function() {
        render();
    };

    function render() {
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
        recaptchaVerifier.render();
    }

    function phoneSendAuth() {

        let number = $("#number").val();

        firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {

            window.confirmationResult = confirmationResult;
            coderesult = confirmationResult;
            console.log(coderesult);

            $("#sentSuccess").text("Message Sent Successfully.");
            $("#sentSuccess").show();
            $("#phone_number_form").hide();
            $("#verify_code_form").show();
            setTimeout(() => {
                $("#sentSuccess").hide();
            $("#successRegsiter").hide();
            }, 1000);

        }).catch(function(error) {
            $("#error").text(error.message);
            $("#error").show();
        });

    }

    function codeverify() {

        let code = $("#verificationCode").val();

        coderesult.confirm(code).then(function(result) {
            let user = result.user;
            console.log(user);
            let phone_number = $("#number").val();
            $("#phone").val(phone_number.split('+2')[1]);
            $("#successRegsiter").text("you are register Successfully.");
            $("#successRegsiter").show();
            $("#phone_number_form").hide();
            $("#verify_code_form").hide();
            $('#login_form').show();
            setTimeout(() => {
            $("#successRegsiter").hide();
            }, 1000);
          
            

        }).catch(function(error) {
            $("#error").text(error.message);
            $("#error").show();
        });
    }
</script>

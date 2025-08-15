<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #dfa974;, #fff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 50px;
            width: 600px;
            max-width: 100%;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 700;
            color: #333;
            text-align: center;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }
        

        .form-group input  {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }
        .form-group select  {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #ee7e0e;
        }

        .login-container button {
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background: #e6aa6f;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background: #f3881d;
        }

        .login-container .footer {
            text-align: center;
            margin-top: 15px;
        }

        .login-container .footer a {
            color: #f3881d;
            text-decoration: none;
            font-weight: 500;
        }

        .login-container .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>{{ __('message.register') }}</h2>
    <!-- Show success message after registration -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <br>
        <form action="{{route('authregister')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                 <!-- Name Field -->
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">{{ __('message.first_name') }}</label>
                        <input type="text" id="first_name" name="first_name"  >
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">{{ __('message.last_name') }}</label>
                        <input type="text" id="last_name" name="last_name"  required>
                    </div>
                
                </div>
         </div>
       <div class="row">
        <div class="col-6">
              <!-- Email Field -->
              <div class="form-group mb-3">
                <label for="email" class="form-label">{{ __('message.email') }}</label>
                <input type="email" id="email" name="email" required>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group mb-3">
                <label for="moblieno" class="form-label">{{ __('message.mobile_number') }}</label>
                <input type="text" id="moblieno" name="moblieno" required>
            </div>
        </div>
       </div>

        <div class="row">
            <div class="col-6">
                 <!-- Password Field -->
                <div class="form-group mb-3">
                    <label for="password" class="form-label">{{ __('message.password') }}</label>
                    <input type="password" id="password" name="password"  required>
                </div>
            </div>
            <div class="col-6">
                  <!-- Confirm Password Field -->
                <div class="form-group mb-3">
                    <label for="cpassword" class="form-label">{{ __('message.confirm_password') }}</label>
                    <input type="password" id="cpassword" name="password_confirmation"  required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="cpassword">{{ __('message.address') }}</label>
            <input type="text" id="address" name="address" required>
        </div>
            <div class="row">
                <div class="col-6">
                    <div class=" form-group mb-3">
                        <label for="country" class="form-label">{{ __('message.country') }}</label>
                        <select class="form-select" name="country" id="country">
                            <option value="">{{ __('message.select_country') }}</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="state" class="form-label">{{ __('message.state') }}</label>
                        <select class="form-select" name="state" id="state">
                            <option value="">{{ __('message.select_state') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                      <!-- Mobile Number Field -->
                      <div class="form-group mb-3">
                        <label for="city" class="form-label">{{ __('message.city') }}</label>
                        <select class="form-select" name="city" id="city">
                            <option value="">{{ __('message.select_city') }}</option>
                        </select>
                      </div>
                </div>
                <div class="col-6">
                    <div class="form-group mb-3">
                        <label for="moblieno" class="form-label">{{ __('message.zipcode') }}</label>
                        <input type="text" id="zipcode" name="zipcode"  required>
                    </div>  
                </div>   
            </div>
           
            <div class="form-group">
                <label for="role">{{ __('message.role') }}</label>
                <select name="role">
                    <option value="hotel_owner">{{ __('message.hotel_owner') }}</option>
                    <option value="customer">{{ __('message.customer') }}</option>
                </select>
            </div>
            <button type="submit">{{ __('message.register') }}</button>
        </form>
        <div class="footer">
            <p>{{ __('message.already_have_an_account') }} <a href="{{route('login')}}">{{ __('message.login') }} </a></p>
        </div>
    </div>
    <script>


      

$(document).ready(function() {
    $('#country').change(function() {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                url: '/fetch-states',
                type: 'GET',
                data: { country_id: countryId },
                success: function(data) {
                    $('#state').html('<option value="">Select a state...</option>');
                    $.each(data.states, function(key, value) {
                        $('#state').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });

    $('#state').change(function() {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: '/fetch-cities',
                type: 'GET',
                data: { state_id: stateId },
                success: function(data) {
                    $('#city').html('<option value="">Select a city...</option>');
                    $.each(data.cities, function(key, value) {
                        $('#city').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });
});
    </script>
</body>
</html>

<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<link rel="stylesheet" href="{{asset('resources/css/app.css')}}">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<div class="container">
    <div class="row">

        <div class="pen-title">
            <h2>Login Form</h2>
        </div>
        <div class="container">
            <div class="card"></div>
            <div class="card">
                <h1 class="title">Login</h1>
                <form method="post" action="{{route('proses.login')}}">
                    {{ csrf_field() }}
                    <div class="input-container">
                        <input type="text" id="Username" required="required" name="email" />
                        <label for="Username">Username</label>
                        <div class="bar"></div>
                    </div>
                    <div class="input-container">
                        <input type="password" id="Password" required="required" name="password" />
                        <label for="Password">Password</label>
                        <div class="bar"></div>
                    </div>
                    <div class="button-container">
                        <button type="submit"><span>Login</span></button>
                    </div>
                    <!-- <div class="footer"><a href="#">Forgot your password?</a></div> -->
                </form>
            </div>
            <div class="card alt">
                <div class="toggle"></div>
                <h1 class="title">Register
                    <div class="close"></div>
                </h1>
                <form method="post" action="{{route('register')}}">
                    {{ csrf_field() }}
                    <div class="input-container">
                        <input type="text" id="Username" required="required" />
                        <label for="Username">Username</label>
                        <div class="bar"></div>
                    </div>
                    <div class="input-container">
                        <input type="password" id="Password" required="required" />
                        <label for="Password">Password</label>
                        <div class="bar"></div>
                    </div>
                    <div class="input-container">
                        <input type="password" id="Repeat Password" required="required" />
                        <label for="Repeat Password">Repeat Password</label>
                        <div class="bar"></div>
                    </div>
                    <div class="button-container">
                        <button><span>Next</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.toggle').on('click', function() {
            $('.container').stop().addClass('active');
        });

        $('.close').on('click', function() {
            $('.container').stop().removeClass('active');
        });

    });
</script>
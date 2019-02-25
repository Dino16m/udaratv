<!DOCTYPE html>
<html>
<head>
    <title>UdaraTV subscription mail</title>
</head>
<body style=" background-color: #1e2129; color: #8e95a5;  font-weight: 300; font-size: 20px; padding-right: 10px; padding-left: 10px;">
    <div class="image-container" style="display: block; width: 100%; height: 30%; background-color: #000000; align-items: center;" >
        <img style=" display: block; align-self: center; position: relative; margin-left: auto; margin-right: auto;" src="{{ $message->embed('public/images/udaralogo.png') }}">
    </div>
    <div class="message" style="color: white; font-family: Roboto ,sans-serif; ">
        <p>
            Dear subscriber {{print_r($receiver)}},<br>
                We at UdaraTv are delighted to inform you that the {{$type}} {{$name}} which you requested for earlier has been added to <a href="{{url('/')}}">UdaraTv</a>
                the link to the {{$type}} is <a style=" display: inline-block; width: 50px; height: 26px; border-color: black; background-color: #e88607; color: black; align-content: center; align-items: center; text-decoration: none" href="{{$link}}">Here</a>
        </p>
        <p>
            However, if you are having problems following the link to the {{$type}} given above, kindly copy the following link to your browser <a href="{{$link}}"> {{$link}}</a>
        </p>

        <p>
            Please note that the reception of this email means that you have been automatically unsubscribed from this particular mailing list,
            however, to make a request for another movie or series kindly visit or copy this link to your browser <a href="{{url('/#request')}}"> {{url('/#request')}}</a>
        </p>
        <p style="display: block; align-content: right; position: relative; float: right;" >
             regards,<br>
             UdaraTv team.
        </p>
    </div>
</body>
</html>
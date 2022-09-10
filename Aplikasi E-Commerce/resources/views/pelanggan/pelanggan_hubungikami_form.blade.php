@extends('layouts.layout')

@section('title', 'Hubungi Kami')
@section('subtitle', 'Pages')
@section('content')
    <div class="card mx-4 my-2">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Hubungi Kami
            </h4>
            <div id="contact-form">
                @php
                    $auth = Auth::user();
                @endphp
                <form onsubmit="sendEmail(); reset(); return false;">
                    <div class="wow fadeInUp form-group" data-wow-delay="1s">
                        <input name="name" value="{{ $auth->name }}" type="text" class="form-control" id="name"
                            placeholder="Your Name" required>
                    </div>
                    <div class="wow fadeInUp form-group" data-wow-delay="1.2s">
                        <input name="email" value="{{ $auth->email }}" type="email" class="form-control" id="email"
                            placeholder="Your Email" required>
                    </div>
                    <div class="wow fadeInUp form-group" data-wow-delay="1s">
                        <input name="subject" type="text" class="form-control" id="subject" placeholder="Your Subject" value="Report">
                    </div>
                    <div class="wow fadeInUp form-group" data-wow-delay="1.4s">
                        <textarea name="message" rows="5" class="form-control" id="message" placeholder="Write your message..." required></textarea>
                    </div>
                    <div class="wow fadeInUp col-md-2 col-sm-8" data-wow-delay="1.6s">
                        <input name="submit" type="submit" class="form-control bg-success text-white" id="submit"
                            value="Send">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>
    <script>
        (function() {
            emailjs.init("35-_yhIfBhVutU3yP");
        })();

        // email
        function sendEmail() {
            var contactParams = {
                to_name: "pt.anekaterpal@gmail.com",
                from_name: document.getElementById("name").value,
                from_email: document.getElementById("email").value,
                subject: document.getElementById("subject").value,
                message: document.getElementById("message").value,
            }

            emailjs.send("service_dwbblt8", "template_8flw4d8", contactParams).then(function(res) {
                return swal("Good job!", "You clicked the button!", "success");
            })
        }
    </script>
@endsection

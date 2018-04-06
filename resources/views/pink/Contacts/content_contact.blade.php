<div id="content-page" class="content group">
    <div class="hentry group">
       {{-- {{ print_r($errors->all()) }}--}}

        <form id="contact-form-contact-us" class="contact-form" method="post" action="{{ route('contact') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="usermessagea"></div>
            <fieldset>
                <ul>
                    <li class="text-field">
                        <label for="name-contact-us">
                            <span class="label">Name</span>
                            <br />					<span class="sublabel">This is the name</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span><input type="text" name="name" id="name-contact-us"  value="{{ old('name') }}" /></div>
                        <div class="msg-error">
                            @if($errors->has('name'))
                                <p class="alert-danger">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                    </li>


                    <li class="text-field">
                        <label for="email-contact-us">
                            <span class="label">Email</span>
                            <br />					<span class="sublabel">This is a field email</span><br />
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-envelope"></i></span><input type="text" name="email" id="email-contact-us"  value="{{ old('email') }}" /></div>
                        <div class="msg-error">
                            @if($errors->has('email'))
                                <p class="alert-danger">{{ $errors->first('email') }}</p>
                            @endif

                        </div>
                    </li>



                    <li class="textarea-field">
                        <label for="message-contact-us">
                            <span class="label">Message</span>
                        </label>
                        <div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span><textarea name="message" id="message-contact-us" rows="8" cols="30">{{ old('message') }}</textarea></div>
                        <div class="msg-error">
                            @if($errors->has('message'))
                                <p class="alert-danger">{{ $errors->first('message') }}</p>
                            @endif


                        </div>
                    </li>

                    <li class="submit-button">
                       <input type="text" name="yit_bot" id="yit_bot" />
                        <input type="hidden" name="yit_action" value="sendmail" id="yit_action" />
                        <input type="hidden" name="id_form" value="126" />
                        <input type="submit" name="yit_sendmail" value="Send Message" class="sendmail alignright" />
                    </li>
                </ul>
            </fieldset>
        </form>

    </div>

</div>
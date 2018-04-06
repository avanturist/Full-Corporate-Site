@if(count($contact) > 0)

    <div class="widget-first widget contact-info">
        <h3>Contacts</h3>
        <div class="sidebar-nav">
            <ul>
                <li>
                    <i class="icon-map-marker" style="color:#979797;font-size:20pxpx"></i> Location: {{ $contact->location }}
                </li>
                <li>
                    <i class="icon-info-sign" style="color:#979797;font-size:20pxpx"></i> Phone: {{ $contact->phone }}
                </li>
                <li>
                    <i class="icon-print" style="color:#979797;font-size:20pxpx"></i> Fax: +39 0035 356 765
                </li>
                <li>
                    <i class="icon-envelope" style="color:#979797;font-size:20pxpx"></i> Email: {{ $contact->email }}
                </li>
            </ul>
        </div>
    </div>

<div class="widget-last widget text-image">
    <img src="{{ asset(config('settings.theme')) }}/images/95.gif " style="width: 15%; float: left" alt=""><h3> Customer Support</h3>
    <div class="text-image">

        <div class="phone">
           <h7 style="text-align: center"><i><strong>Call us:</strong></i> <strong>{{ $contact->phone }}</strong></h7>


        </div>
    </div>
    <p>Nunc sit amet pretium purus. Pellet netus et malesuada fames ac turpis egestas.entesque habitant morbi tristique senectus </p>
</div>
{{--
<img src="{{ asset(config('settings.theme')) }}/images/callus.gif" alt="Customer Support" />--}}
@endif
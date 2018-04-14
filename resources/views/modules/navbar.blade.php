 <div class="{{ $container }}">
     <div class="top-left {{ $linkStyle }}">
         @if (Auth::check())
             <a href="{{ url('/account') }}">My Account</a>
             <a href="{{ url('/account/messages') }}">Messages</a>
             <a href="{{ url('/night-out') }}">Find a Night Out</a>
             <a href="{{ url('/logout') }}">Logout</a>
         @else
             <a href="{{ url('/login') }}">Login</a>
             <a href="{{ url('/register') }}">Register</a>
         @endif
     </div>
     <div class="top-right {{ $linkStyle }}">
         <a href="{{ url('/') }}">Dinner For Two</a>
     </div>
 </div>
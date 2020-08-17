<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
    <meta name="user-nm" content="{{ Auth::user()->name }}">
    <script>window.laravel={
       csrfToken:'{{ csrf_token() }}',
       userNm:"{{ Auth::user()->name }}",
       userId:"{{ Auth::user()->id }}",
      }
    </script>
    @else
    <script>window.laravel={
       csrfToken:'{{ csrf_token() }}',
      //  user_nm:user->name,
      }
    </script>
    @endauth

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
    <style>
      .list-group{
        overflow-y:scroll;
        max-height:350px;
        min-height:350px;
      }
      ::-webkit-scrollbar {
        width: 6px;
        border: 1px solid #d5d5d5;
      }

      ::-webkit-scrollbar-track {
        border-radius: 0;
        background: #eeeeee;
      }

      ::-webkit-scrollbar-thumb {
        border-radius: 0;
        background: #b0b0b0;
      }
    </style>
</head>
<body>
    <div class="container">
        <div class="row" id='app'>
          <div class="offset-lg-4 col-lg-4 my-5 offset-sm-1 col-sm-10 offset-md-3 col-md-6">
            <li class="list-group-item active col-12 d-flex justify-content-between">
              <div style='font-size:16px;'>Chat Room
                <span class='badge-pill badge-danger'> @{{ numberOfUsers }} </span>
              </div>
              <div class="text-right mr-4"> @{{ typing }}</div>
            </li>
            <ul class="list-group" v-chat-scroll="{always: false, smooth: true, scrollonremoved:true, smoothonremoved: false}" >
              <message v-for="value,index in chat.message"
              :user=chat.user[index]
              :time=chat.time[index]
              :key=value.index
              color="success">@{{ value }}</message>
            </ul>
            <li class="list-group-item p-0 border-0">
              <input v-model="message" v-on:keyup.enter="send" type="text" placeholder='Type your message...' class="form-control h-100 w-100 p-3">
            </li>
            <br>
            <span class='btn btn-warning' style='cursor: pointer;' @click="clearFromSession()"> Clear Chats</span>
          </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>



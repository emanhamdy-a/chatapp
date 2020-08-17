
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

import { timers } from 'jquery';

import Toaster from 'v-toaster'
import 'v-toaster/dist/v-toaster.css'
Vue.use(Toaster, {timeout: 5000})

Vue.prototype.$usernm = document.querySelector("meta[name='user-nm']").getAttribute('content');
Vue.component('message', require('./components/message.vue').default);
Vue.component('replay', require('./components/replay.vue').default);

const app = new Vue({
    el: '#app',
    data:{
      message:'',
      userNm:laravel.userNm,
      chat:{
        message:[],
        replay:[],
        user:[],
        time:[]
      },
      typing:'',
      numberOfUsers:0
    },
    watch:{
      message(){
        Echo.private('chat')
        .whisper('typing', {
            msg: this.message,
            name: laravel.userNm,
        });
      }
    },
    methods:{
      send(){
        if(this.message.length != 0){
          this.chat.message.push(this.message);
          this.chat.user.push('Me');
          this.chat.time.push(this.getTime());
          const el = this.$el.getElementsByClassName('scrollist')[0];
          // console.log(this.message);
          axios
          .post("/send" ,{
            chat:this.chat,
            message:this.message,
          })
          .then(response => {
            console.log(response);
          })
          .catch(err => console.log(err));
          this.message='';
        }
      },
      scroldown(){
        this.$refs.chat.scrollIntoView();
        // Which the ref is on
      },
      getTime(){
        let time=new Date();
        return time.getHours()+" : "+time.getMinutes();
      },
      getOldMessages(){
        axios.post('/getOldMessages')
        .then(response=>{
          console.log(response);
          if(response.data!=''){
            this.chat=response.data;
          }
        })
        .catch(error=>{
          console.log(error);
        })
      },
      clearFromSession(){
        axios.post('/clearFromSession')
        .then(response=>{
            this.$toaster.success('Your chats have deleted.', {timeout: 1500})
            this.chat.message=[];
            this.chat.user=[];
            this.chat.time=[];
        })
        .catch(error=>{
          console.log(error);
        })
      },
    },
    mounted(){
      Echo.private(`chat`)
      .listen('ChatEvent', (e) => {
          this.chat.message.push(e.message);
          this.chat.user.push(e.user);
          this.chat.time.push(this.getTime());
          axios.post('/saveToSession',{
            chat:this.chat,
          })
        })
      .listenForWhisper('typing', (e) => {
        if(e.msg!=''){
          console.log(e.name);
          this.typing=e.name + ' is typing now...';
        }else{
          this.typing='';
        }
      })

      Echo.join(`chat`)// .${roomId}
      .here((users)=>{
        this.numberOfUsers=users.length;
        // console.log(users);
      })
      .joining((user)=>{
        this.numberOfUsers+=1;
        this.$toaster.success(user.name+' is joined the room.', {timeout: 1500})
      })
      .leaving((user)=>{
        this.numberOfUsers-=1;
        this.$toaster.warning(user.name+' is joined the room.', {timeout: 1500})
      })
      .listen('NewMessage', (e) => {
        this.$toaster.success('new message from '+user.name+'.', {timeout: 1500})
      });
    },
    created(){
      this.getOldMessages();
    }
});
// app/Http/Controllers/Auth/LoginController.php and app/Http/Controllers/Auth/RegisterController.php to:
// protected $redirectTo = '/';

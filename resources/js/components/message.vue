<template>
<div>
  <li class="list-group-item rounded" :class="className"> <slot></slot> </li>
  <div class="rounded" style=""  :class="badgeClass">{{ user }}</div>
  <div class="rounded mx-2" style=""  :class="badgeClass">{{ time }}</div>
</div>
</template>

<script>
  export default {
    props:[
      'color',
      'user',
      'time'
    ],
    computed:{
      className(){
        if(this.user=='Me'){
          return "list-group-item-success";
        }else{
          return "list-group-item-warning";
        }
          // return "list-group-item-"+this.color;
      },
      badgeClass(){
        if(this.user=='Me'){
          return "float-right badge badge-success";
        }else{
          return "float-left badge badge-warning";
        }
      }
    },
    mounted() {
        console.log('Component mounted.')
    }
  }
</script>

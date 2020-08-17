<template>
<div>
  <li class="list-group-item rounded" :class="className"> <slot></slot> </li>
  <div class="float-left rounded-circle" style=""  :class="badgeClass">other</div>
</div>
</template>

<script>
    export default {
      props:[
        'color'
      ],
      computed:{
        className(){
          return "list-group-item-"+this.color;
        },
        badgeClass(){
          return "badge badge-"+this.color;
        }
      },
      mounted() {
          console.log('Component mounted.')
      }
    }
</script>

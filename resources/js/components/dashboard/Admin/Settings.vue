<template>
    <div class="col-lg-8 show-alert-messaage">
         <img class="schedule-img" :src="require('../../../img/image_processing20200627-19092-c2s8xo.gif')">
         <p class="description-schedule-empty">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus tenetur nam adipisci deserunt consequuntur eius laboriosam, eaque eveniet assumenda esse. Cumque architecto culpa cupiditate dolorem ipsa, quae neque repudiandae impedit.</p>
         <div class="frame-btn-schedule">
              <router-link tag="button" class="btn btn-success" :to="{name:'add-schedules'}">اضافة حملة جديدة</router-link>
         </div>
    </div>
</template>
<style scoped>
.row{
    margin: 0px;
}
.show-alert-messaage{
    height:auto;
    /*background-color: antiquewhite;*/
    padding:20px;
    text-align:center;
    margin:auto;
    margin-top:5%;
}

.schedule-img{
    width: 31%;
    height: 220px;
    border-radius: 60%;
}

p.description-schedule-empty{
    padding: 6% 15%;
}
@media(max-width:1000px){
    .schedule-img{
        width: 70%;
        height: auto;
    }
}
</style>

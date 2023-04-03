<template>
    <div class="container-fluid">
        <section class="row" :style="`min-height:755px;background-color: rgb(28 65 158);`">
            <div class="col-lg-7 text-center container-alert-integrated">
                <img src="@/img/tigara-trans.png" style="width: 20%;"/>
                <template v-if="steps == 0">
                    <h1 class="big-title">
                        تهانيا تم انشاء الحساب بنجاح
                    </h1>
                    <h2 class="title-login" style="">
                        تم انشاء الحساب بنجاج و لكن تحتاج قبل البدء فى التسويق و جنى الارباح مطلوب استكمال بيانات حسابك لكى يتم الموافقة عليها من قبل المسؤلين و البدء فى البيع
                    </h2>
                    <button @click="nextSteps" class="btn btn-primary action-go" style="display:inline-block">
                        البدء فى استكمال الحساب
                    </button>
                    <!-- <router-link :to="{name:'marketer-reports'}" class="btn btn-success action-go" style="display:inline-block">
                        لوحة التحكم
                    </router-link> -->
                </template>
                <template v-if="steps == 1">
                    <form @submit.prevent="nextSteps()">
                        <br/>
                        <span class="counter-step">{{ steps }}</span>
                        <div class="form-group container-who-you">
                            <label>
                                عرف نفسك *
                                <p class="description-who-you">
                                    بشكل تفصيلي لكى يتم معرفة مدى قدرتك على التميز فى عمليات البيع و التسويق
                                </p>
                            </label>
                            <textarea class="form-control" v-model="field.who_you"
                            placeholder="عرف نفسك بشكل مفصل"
                             rows="5" required></textarea>
                        </div>
                        <button @click="prevSteps" class="btn btn-danger btn-sm action-go" style="display:inline-block">
                            <i class="fas fa-long-arrow-alt-right"></i>
                            السابق
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm action-go" style="display:inline-block">
                            التالي
                            <i class="fas fa-long-arrow-alt-left"></i>
                        </button>

                    </form>
                </template>
                <template v-if="steps == 2">
                    <form methos="post" @submit.prevent="AttachDetailsToMarketer()">
                        <br/>
                        <span class="counter-step">{{ steps }}</span>
                        <div class="form-group container-who-you">
                            <label>
                                 طريقة التسويق التي ستقوم بها*
                                <p class="description-who-you">
                                    أكتب بالتفصيل طريقة تسويقك التى سوف تتبعها لكى تقوم بعمليات التسويق و البيع داخل المنصة
                                </p>
                            </label>
                            <textarea class="form-control" v-model="field.which_marketing_will_follow"
                            placeholder="طريقة التسويق التي ستقوم بها"
                             rows="5" required></textarea>
                        </div>
                        <button @click="prevSteps" class="btn btn-danger btn-sm action-go" style="display:inline-block">
                            <i class="fas fa-long-arrow-alt-right"></i>
                            السابق
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm action-go" style="display:inline-block">
                            التالي
                            <i class="fas fa-long-arrow-alt-left"></i>
                        </button>

                    </form>
                </template>
                <template v-if="steps == 3">
                    <h1 class="big-title">
                        تهانيا لقد تم ارفاق التفاصيل بنجاح
                    </h1>
                    <h2 class="title-login" style="">
                        لقد تم ارفاق التفاصيل لبيانتك و توجيهها للمسؤل لكى يتم معاينة الطلب و قبولك و البدء فى التسويق
                        عند اتاحة الحساب سيتم اتاحة جميع مزايا المنصة من أجلك
                    </h2>
                    <router-link :to="{name:'marketer-reports'}" class="btn btn-success" style="display:inline-block">
                        لوحة التحكم
                    </router-link>
                </template>
            </div>
        </section>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data(){
        return {
            steps:0,
            field:{
                who_you:null,
                which_marketing_will_follow:null
            }
        }
    },
    methods:{
        nextSteps:function(){
            console.log(this.steps);
            this.steps = this.steps + 1;
            console.log(this.steps);
        },
        prevSteps:function(){
            console.log(this.steps);
            this.steps = this.steps - 1;
            console.log(this.steps);
        },
        AttachDetailsToMarketer:async function(){
            let self = this;
            await axios.post('/api/marketer-attach-marketing-details',this.field).then(function({data}){
                 console.log(data);
                 if(data.status == 'success'){
                    self.nextSteps();
                 }
            }).catch(function({response}){
                console.log(response);
            });
        }
    },
    created(){
        this.field = this.$auth.user.addition_informations || this.field;
        console.log(this.field);
    }
}
</script>
<style scoped>
.container-alert-integrated{
    margin: auto;
    background: white;;
    padding: 3% 6%;
    border-radius: 10px;
}
.container-alert-integrated .title-login
{
    line-height: 2em;
    font-size: 15px;
    color: #474444;
    padding: 13px 0px 35px 0px;
}
.big-title{
    font-size: 18px;
    color: green;
    margin-top:20px;
}
.container-alert-integrated .img-zid
{
   width:20%;
}
.frame{
    width:100%;
}
.frame img{
    width:100%;
}
.frame .container-instapp{
    background: white;
    padding: 20px;
    border-radius: 60px;
}
.description-login{
    color: white;
    padding: 10px;
    border-radius: 10px;
    background: rgba(33, 34, 45, 0.72);
    width: 95%;
    font-size: 17px;
    text-align: right;
    margin: auto;
}
.manageapp{
    background: #A9DFD8;
    border-radius: 20px;
    font-weight: bold;
}
.container-who-you{
    padding: 16px;
    text-align: right;
    font-size: 17px;
}
.container-who-you label{
    line-height: 2.5em;
}
.container-who-you p.description-who-you
{
    width: 100%;
    padding: 0px 0%;
    line-height: 1.5;
    color: #0d6efd;
    font-weight: bold;
    font-size: 13px;
}
.counter-step{
    background-color: #abaaa9;
    width: 20%;
    padding: 0px 16px;
    border-radius: 65%;
    font-size: 31px;
    color: white;
    box-shadow: 5px 11px 12px 10px #eee;
}
.container-who-you textarea{
    background-color: white;
    border: 5px solid #3f649b4a;
}
.action-go{
    margin: 10px;
}
@media(max-width:1000px){
    section{
        padding: 12%;
    }
    .container-alert-integrated .title-login{
        font-size:20px;
    }
    .frame img{
        width: 70%;
    }
    .frame{
        padding: 12px;
    }
    .conncetionapp{
        width:100% !important;
    }
    .description-login{
        font-size: 15px;
    }
    .container-alert-integrated{
        padding: 9% 6%;
    }
    .counter-step{
        padding: 0px 14px;
        font-size: 25px;
    }
}

</style>

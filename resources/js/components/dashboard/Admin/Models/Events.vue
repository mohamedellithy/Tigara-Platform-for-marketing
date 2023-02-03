<template>
    <div v-if="ShowEvents" class="model-browose-products">
        <div class="card card-model">
            <form method="post" @submit.prevent="AddEventForCampaign">
                <div class="top-header-model">
                    <p class="title-model">
                        تصفح المهمات المتوفرة التى يمكن جدولتها
                    </p>
                </div>
                <div class="body-of-model">
                    <table class="list-items">
                        <tbody>
                            <tr>
                                <td>
                                    <input type="radio" v-model="campaign.action" value="0" class="" required/>
                                </td>
                                <td class="even-td">
                                    <h6>
                                        نشر المنتجات
                                    </h6>
                                    <p>
                                        هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" v-model="campaign.action" value="1" class="" required/>
                                </td>
                                <td class="even-td">
                                    <h6>
                                        الغاء نشر المنتجات
                                    </h6>
                                    <p>
                                        هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.
                                    </p>
                                </td>
                            </tr> 
                            <tr>
                                <td>
                                    <input type="radio" v-model="campaign.action" value="2" class="" required/>
                                </td>
                                <td class="even-td">
                                    <h6>
                                        تخفيضات على المنتجات
                                    </h6>
                                    <p>
                                        هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" v-model="campaign.action" value="3" class="" required/>
                                </td>
                                <td class="even-td">
                                    <h6>
                                        تغير فى السعر المنتجات
                                    </h6>
                                    <p>
                                        هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" v-model="campaign.action" value="4" class="" required/>
                                </td>
                                <td class="even-td">
                                    <h6>
                                    اضافة الترميزات الخاصة للمنتجات
                                    </h6>
                                    <p>
                                        هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="radio" v-model="campaign.action" value="5" class="" required/>
                                </td>
                                <td class="even-td">
                                    <h6>
                                    حذف الترميزات الخاصة للمنتجات
                                    </h6>
                                    <p>
                                        هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="top-footer-model">
                    <button type="submit" class="btn btn-primary">اضافة المهمة</button>
                    <button @click="CloseModel" type="button" class="btn btn-danger">الغاء</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    export default {
        props:{
            ShowEvents:{
                default:false,
                type: Boolean
            },
            campaign:{
                default:{},
                type: Object
            }
        },
        data(){
            return{
                checked:null
            }
        },
        methods:{
            CloseModel:function(){
                this.$emit('modelshow', false);
            },
            AddEventForCampaign:function(){
                this.CloseModel();
                this.$emit('updateFromEventCampaign', this.campaign);
            }
        }
    }
</script>
<style scoped>
   .model-browose-products{
        position: fixed;
        left:0%;
        right:0%;
        top:0%;
        bottom:0%;
        background-color:#00000047;
        text-align: center;
        overflow-y:auto;
        z-index: 100000;
   }
   .card-model{
        background-color:white;
        width:40%;
        height:auto;
        margin:auto;
        margin-top: 5%;
   }
   .title-model{
        padding: 9px 15px;
        text-align: right;
        font-size: 17px;
        line-height: 3em;
        border-bottom: 1px solid #eee;
   }
   .list-items{
         overflow-y: auto;
   }
   .body-of-model
   {
        max-height:400px;
        overflow-y: auto;
   }
   .list-items tr{
        padding: 14px;
   }
   .top-footer-model{
        text-align: left;
        padding: 10px;
        border-top:1px solid #eee;
   }
   .even-td
   {
        text-align: right;
        width: 90%;
        padding: 3px 0px 7px 80px;
   }
   td input[type="radio"]
   {
        float: right;
        margin-top: -40px;
        margin-right: 20px;

        height: 20px;
        width: 20px;
        vertical-align: middle;
   }
   @media(max-width:1000px){
        .card-model{
            width: 95%;
        }
        .even-td{
            width:100%;
            padding: 3px 0px 7px 10px;
        }
        td input[type="radio"]{
            margin-top: -56px;
            margin-right: 10px;
            margin-left: 10px;
        }
    }
</style>
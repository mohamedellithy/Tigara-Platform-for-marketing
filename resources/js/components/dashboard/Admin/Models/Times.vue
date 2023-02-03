<template>
    <div v-if="ShowTimes" class="model-browose-products">
        <form method="post" @submit.prevent="AddTimesForCampaign">
            <div class="card card-model">
                <div class="top-header-model">
                    <p class="title-model">
                        اعدادات مرات تكرار المهمة
                    </p>
                </div>
                <div class="body-of-model">
                    <table class="list-items">
                        <tbody>
                            <tr>
                                <td colspan="3" class="even-td">
                                    <h6>
                                        تكرار المهمة
                                    </h6>
                                    <select v-model="campaign.repeate" class="form-control">
                                        <option value="0">بدون تكرار</option>
                                        <option value="daily">يوميا</option>
                                        <option value="weekly">اسبوعيا</option>
                                        <option value="monthly">شهريا</option>
                                        <option value="annually">سنويا</option>
                                        <option value="weekends"> ايام العطلات</option>
                                        <option value="custom">تحديد معاد اخر</option>
                                    </select>
                                </td>
                            </tr>
                            <template v-if="campaign.repeate == 'daily'">
                                <tr>
                                    <td class="td-3-col">
                                        <h6 style="text-align: right;">
                                            اختيار الوقت
                                        </h6>
                                    </td>
                                    <td class="td-3-col" colspan="2">
                                        <input class="form-control" type="time" v-model="campaign.repeate_at_time" />
                                    </td>
                                </tr>
                            </template>
                            <template v-if="campaign.repeate == 'weekly' || campaign.repeate == 'monthly' || campaign.repeate == 'weekends'">
                                <tr>
                                    <td colspan="3" class="td-3-col">
                                        <h6 class="title-repeate-on">
                                            اختيار الايام 
                                            <template v-if="campaign.repeate == 'weekends'">
                                                <br/>
                                                <p class="alert alert-info" style="margin-top:10px">
                                                    ( اذا لم يتم تحديد يوم فسوف يتم ارسال وفقا للعطلات التابعة لتوقيت المنطقة)
                                                </p>
                                            </template>
                                        </h6>
                                        <div class="container-repeate-on">
                                            <ul>
                                                <li :class="[this.campaign.reapete_on.indexOf('SATURDAY') !== -1 ? 'active' : '']">
                                                    <label for="">السبت</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="SATURDAY" class="reapete_on" />
                                                </li>
                                                <li :class="[this.campaign.reapete_on.indexOf('SUNDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الاحد</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="SUNDAY" class="reapete_on" />
                                                </li>
                                                <li v-if="campaign.repeate != 'weekends'" :class="[this.campaign.reapete_on.indexOf('MONDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الاثنين</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="MONDAY" class="reapete_on" />
                                                </li>
                                                <li v-if="campaign.repeate != 'weekends'" :class="[this.campaign.reapete_on.indexOf('TUESDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الثلاثاء</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="TUESDAY" class="reapete_on" />
                                                </li>
                                                <li v-if="campaign.repeate != 'weekends'" :class="[this.campaign.reapete_on.indexOf('WEDNESDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الاربعاء</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="WEDNESDAY" class="reapete_on" />
                                                </li>
                                                <li v-if="campaign.repeate != 'weekends'" :class="[this.campaign.reapete_on.indexOf('THURSDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الخميس</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="THURSDAY" class="reapete_on" />
                                                </li>
                                                <li :class="[this.campaign.reapete_on.indexOf('FRIDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الجمعة</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="FRIDAY" class="reapete_on" />
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template v-if="campaign.repeate == 'custom'">
                                <tr>
                                    <td colspan="3">
                                        <h6 class="second-title">تحديد تكرار</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-3-col">
                                        <h6>
                                            عدد مرات التكرار
                                        </h6>
                                    </td>
                                    <td class="td-3-col">
                                        <input class="form-control" placeholder="3" type="number" v-model="campaign.count_repeate" />
                                    </td>
                                    <td>
                                        <select v-model="campaign.unit_repeate" class="form-control">
                                            <option value="0">يوم</option>
                                            <option value="1">اسبوع</option>
                                            <option value="2">شهر</option>
                                            <option value="3">سنة</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="td-3-col">
                                        <h6 class="title-repeate-on">
                                            التكرار في
                                        </h6>
                                        <div class="container-repeate-on">
                                            <ul>
                                                <li :class="[this.campaign.reapete_on.indexOf('SATURDAY') !== -1 ? 'active' : '']">
                                                    <label for="">السبت</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="SATURDAY" class="reapete_on" />
                                                </li>
                                                <li :class="[this.campaign.reapete_on.indexOf('SUNDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الاحد</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="SUNDAY" class="reapete_on" />
                                                </li>
                                                <li :class="[this.campaign.reapete_on.indexOf('MONDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الاثنين</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="MONDAY" class="reapete_on" />
                                                </li>
                                                <li :class="[this.campaign.reapete_on.indexOf('TUESDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الثلاثاء</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="TUESDAY" class="reapete_on" />
                                                </li>
                                                <li :class="[this.campaign.reapete_on.indexOf('WEDNESDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الاربعاء</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="WEDNESDAY" class="reapete_on" />
                                                </li>
                                                <li :class="[this.campaign.reapete_on.indexOf('THURSDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الخميس</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="THURSDAY" class="reapete_on" />
                                                </li>
                                                <li :class="[this.campaign.reapete_on.indexOf('FRIDAY') !== -1 ? 'active' : '']">
                                                    <label for="">الجمعة</label>
                                                    <input type="checkbox" v-model="campaign.reapete_on" value="FRIDAY" class="reapete_on" />
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="td-3-col">
                                        <h6 class="title-repeate-on">
                                            موعد الانتهاء
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td  class="td-3-col">
                                        <input id="never" v-model="campaign.end_type_cal" type="radio" value="0" />
                                        <label class="label-end" for="never">ابدا</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-3-col">
                                        <input id="on"  v-model="campaign.end_type_cal" type="radio" value="1" />
                                        <label class="label-end" for="on">فى</label>
                                    </td>
                                    <td colspan="2">
                                        <input id="on" class="form-control" v-model="campaign.end_at" type="date" :disabled="this.campaign.end_type_cal != '1' ? true : false"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td-3-col">
                                        <input id="never" v-model="campaign.end_type_cal" type="radio" value="2" />
                                        <label class="label-end" for="never">بعد</label>
                                    </td>
                                    <td>
                                        <input id="on" placeholder="3" class="form-control" v-model="campaign.end_at" type="number" :disabled="this.campaign.end_type_cal != '2' ? true : false"/>
                                    </td>
                                    <td>
                                        <p class="times-text">مرات</p>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <div class="top-footer-model">
                    <button type="submit" class="btn btn-primary btn-sm">اضافة المهمة</button>
                    <button @click="CloseModel" type="button" class="btn btn-danger btn-sm">الغاء</button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        props:{
            ShowTimes:{
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
                checked:null,
                repeate:0,
                unit:0,
                time:1
            }
        },
        methods:{
            CloseModel:function(){
                this.$emit('modelshow', false);
            },
            AddTimesForCampaign:function(){
                this.CloseModel();
                this.$emit('updateFromTimesCampaign', this.campaign);
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
        font-weight: bold;
        line-height: 2em;
        border-bottom: 1px solid #eee;
   }
   .list-items{
        max-height:400px;
        overflow-y: auto;
        width: 100%;
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
   }
   .body-of-model{
        padding: 0px 16px;
   }
   td input[type="radio"]
   {
        /* float: right;
        margin-top: -40px;
        margin-right: 20px; */
   }
   .second-title{
        padding: 25px 7px 4px 0px;
        text-align: right;
   }
   .td-3-col{
       width: 30%;
       padding:10px;
       
   }
   .container-repeate-on ul li
   {
        display:inline-block;
   }
   .container-repeate-on{
        text-align:right;
   }
   .container-repeate-on ul li
   {
        list-style: none;
   }
   .container-repeate-on ul li
   {
        padding: 17px 0px;
        border-radius: 46px;
        height: 54px;
        width: 55px;
        background-color: #eee;
        margin: 5px;
        text-align: center;
        font-size: 12px;
        cursor: pointer;
        position: relative;
   }
   .container-repeate-on ul li.active
   {
        background-color: #42a5f5;
        color: white;
   }
   .title-repeate-on{
        text-align: right;
        padding: 5px 30px;
   }
   td p.times-text{
        text-align: right;
        padding: 10px;
        line-height: 2em;
   }
   .label-end{
        font-weight: bold;
        padding: 2px;
   }
   .container-repeate-on ul li .reapete_on{
        width: 100%;
        position: absolute;
        left: 0;
        height: 100%;
        top: 0;
        bottom: 0;
        opacity: 0;
        cursor: pointer;
   }
   @media(max-width:1000px){
        .card-model{
            width: 95%;
        }
        .container-repeate-on ul{
            padding: 10px 25px 0px 0px;
        }
    }
</style>
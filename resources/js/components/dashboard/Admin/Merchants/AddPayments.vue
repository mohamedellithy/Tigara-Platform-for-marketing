<template>
    <div class="container-body-merchant">
        <form method="post" @submit.prevent="CreateNewPayment">
            <div class="row">
                <h3 class="col-md-8 title-merchant">
                    <i class="fas fa-user-tie" style="font-size: 18px;"></i>
                    اضافة مدفوعات للتاجر
                </h3>

                <div class="col-md-4 container-submit-btn-merchant">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i>
                        اضافة المدفوعات
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 container-form-new-merchant">
                    <div class="form-group">
                        <label for="merchant-name">
                           <i class="fas fa-user-edit" style="padding: 5px;"></i>
                            التاجر
                        </label>
                        <template v-if="this.$route.params.id">
                             <input type="text" class="form-control" v-model="merchant.name" disabled/>
                        </template>
                        <template v-else>
                            <select @change="SelectMerchant()" id="merchant-name" placeholder="اسم التاجر" class="form-control" type="text" v-model="payment.merchant_id">
                                <option :value="undefined" disabled>اختيار التاجر</option>
                                <option v-for="(merchant,index) in merchants" :value="merchant.id" :key="index">{{ merchant.name  }}</option>
                            </select>
                        </template>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-user-edit" style="padding: 5px;"></i>
                            نوع المدفوعات
                        </label>
                        <select id="merchant-name" class="form-control" type="text" v-model="payment.type">
                            <option value="1" selected>تسديد مستحقات</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                             المبلغ المطلوب اضافتة
                        </label>
                        <input id="merchant-name" placeholder="المبلغ" class="form-control" type="number" v-model="payment.value"/>
                    </div>
                    <div class="form-group">
                        <label for="merchant-name">
                            <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                             اضافة ملاحظة
                        </label>
                        <textarea id="merchant-name" placeholder="ملاحظة على المدفوعات" class="form-control" v-model="payment.notice">
                        </textarea>
                    </div>
                </div>
                <div  class="col-lg-4 container-form-new-merchant">
                    <div v-if="Object.keys(merchant).length != 0" class="statics-merchants">
                        <div class="profile">
                             <img class="prof-account" :src="this.iconsProfile">
                             <p class="owner-account">{{ merchant.name }}</p>
                             <p class="status-owner-account">

                                <template v-if="merchant.status == 0">
                                    <i class="fas fa-circle" style="color:gray;"></i>
                                    تاجر غير مفعل
                                </template>
                                <template v-if="merchant.status == 1">
                                    <i class="fas fa-circle"></i>
                                    تاجر فعال
                                </template>
                            </p>
                             <ul class="container-features-prof-account">
                                <li>
                                    <label>اجمالى المدفوعات الخاصة بالتاجر</label>
                                </li>
                                <li class="evenval">
                                    <strong> {{ merchant.payments_total }} MRU</strong>
                                </li>
                                <li>
                                    <label>اجمالى المدفوعات المستحقة الخاصة بالتاجر</label>
                                </li>
                                <li class="evenval">
                                    <strong> {{ merchant.payments_due }} MRU</strong>
                                </li>
                                <li>
                                    <label>اجمالى المدفوعات المسددة الخاصة بالتاجر</label>
                                </li>
                                <li class="evenval">
                                    <strong> {{ merchant.payments_made }} MRU</strong>
                                </li>
                             </ul>
                        </div>
                    </div>
                    <div class="merchant_not_found" v-else>
                        <img style="width:40%" :src="iconsProfile" />
                        <p> لم يتم تحديد التاجر لعرض تفاصيل الحساب</p>
                    </div>
                </div>
            </div>
        </form>
        <alert-response :showsuccess="showsuccess" :showerrors="showerrors"
        @update_success="showsuccess = false"
        @update_errors="showerrors = false" :errors="errors"
        :success_message="success_message"
        :error_message="error_message"></alert-response>
        <div v-if="this.loading" style="position: fixed;top: 0px;bottom: 0px;background-color:#1d2024d1;left: 0;right: 0;z-index: 100000;text-align: center;">
            <img style="margin: 10% auto;" src="@/img/Enso-2.gif"/>
        </div>
    </div>
</template>
<script>
import iconsProfile from '@/img/Circle-icons-profile.svg.png';
export default {
    data(){
        return{
            merchants:{},
            merchant:{},
            payment:{
               type:1,
               value:0
            },
            iconsProfile,
            errors:{},
            success:null,
            showsuccess:false,
            showerrors:false,
            success_message:'تم انشاء التاجر بنجاح',
            error_message:'حدث خطأ اثناء انشاء التاجر',
            loading:true
        }
    },
    methods:{
        CreateNewPayment:function(){
            let self = this;
            axios.post('/api/merchant-payments',this.payment).then(function({data}) {
                console.log(data);
                self.success = data.result;
                self.showsuccess = true;
                self.success_message = data.result;
                self.payment = {
                    merchant_id: self.merchant.id ? self.merchant.id : null,
                    type:0,
                    value:0
                };
                self.SelectMerchant();
            }).catch(function({response}) {
               console.log(response);
               self.showerrors = true;
               self.errors = response.data;
            });
        },
        SelectMerchant:function(){
            let self = this;
            axios.get('/api/merchants/'+this.payment.merchant_id).then(function({data}){
                self.merchant = data.merchant;
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            });
        }
    },
    created(){
        let self = this;
        this.payment.merchant_id = this.$route.params.id || undefined;
        if(!this.$route.params.id){
            axios.get('/api/merchants').then(function({data}){
                self.merchants = data.data_info.data;
                console.log(data);
            }).catch(function({response}){
                console.log(response);
            });
        }else{
            this.SelectMerchant();
        }
    },
    mounted:function(){
        let self = this;
        setTimeout(() => {
            self.loading = false;
        }, 1000);
    }
}
</script>

<style scoped>
.container-body-merchant{
    padding: 4%;
}
.title-merchant{
    line-height:2.5em;
    color: #795548;
}
.container-form-new-merchant{
    padding: 0% 0% 0% 5%;
}
.container-form-new-merchant .form-group label
{
    line-height: 3em;
    font-size: 17px;
}
.container-submit-btn-merchant{
    text-align: left;
}
.merchant-event-name{
    padding: 10px 23px;
    background-color: #cff0d0;
    font-weight: bold;
    position: relative;
    border: 1px solid #eee;
}
.change-event{
    position: absolute;
    left: 0;
    top: 0;
    padding: 10px;
    background-color: white;
    box-shadow: 0px 9px 15px 8px #d0d0d0;
    cursor: pointer;
}
.container-errors{
    padding: 20px 30px 0px 26px;
}
.container-errors .alert
{
    border-radius: 0px;
    box-shadow: 0px 0px 0px 0px #eee;
    border: none;
}

.container-submit-btn-merchant  button{
    margin: 5px;
}
.container-form-new-merchant .form-group{
    padding: 10px;
}
.container-form-new-merchant input[type='text'],
.container-form-new-merchant input[type='number'],
.container-form-new-merchant select,
.container-form-new-merchant textarea
{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
    height: 46px;
}
.profile{
    text-align: center;
}
.prof-account{
    width:15%;
}
.container-features-prof-account{
    padding: 1px;
}
.container-features-prof-account li
{
    list-style: none;
    padding: 10px;
    background-color: #e3f2fd;
    margin-top: 10px;
}
.container-features-prof-account li.evenval{
    background-color:transparent;
    padding:5px 10px;
    margin: 5px 10px;
}
.container-features-prof-account li label{

    font-size: 16px;
}
.container-features-prof-account li strong
{
    font-weight: bold;
    font-size: 20px;
    color: black;
}
p.owner-account{
    margin-bottom: 0px;
    padding: 13px 0px 3px 0px;
    font-weight: 600;
}
p.status-owner-account .fa-circle
{
    font-size: 11px;
    color: #22e322;
}
.merchant_not_found{
    text-align: center;
    padding: 10px;
    font-size: 18px;
    font-weight: bold;
    color: #5d5d5c;
}
@media(max-width:1000px){
    .container-submit-btn-merchant button{
        margin: 1px;
        font-size: 12px;
    }
    .filter-bar .filter-results .filter-item{
        font-size: 11px;
        margin-bottom: 2px;
    }
}
</style>

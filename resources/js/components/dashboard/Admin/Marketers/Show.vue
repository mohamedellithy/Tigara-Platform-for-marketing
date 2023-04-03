<template>
    <div class="container-body-merchant">
        <div class="row">
            <div class="col-lg-11 profile-image">
                <img :src="iconsProfile" />
                <p>
                    <template v-if="marketer.status == 0">
                        <i class="fas fa-circle" style="color:gray;"></i>
                        مسوق غير مفعل
                    </template>
                    <template v-if="marketer.status == 1">
                        <i class="fas fa-circle" style="color:#2fc12f"></i>
                        مسوق فعال
                    </template>
                </p>
            </div>
            <p style="text-align: left;padding:0% 4%">
                <button @click="UpdateMarketer(1)" v-if="marketer.status == 0" class="btn btn-success btn-sm" style="margin:2px">
                    تفعيل المسوق
                </button>
                <button @click="UpdateMarketer(0)" v-if="marketer.status == 1" class="btn btn-danger btn-sm" style="margin:2px">
                     الغاء تفعيل المسوق
                </button>
            </p>
            <p>التفاصيل مسوق</p>
            <div class="col-lg-6 container-form-new-merchant">
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اسم مسوق
                    </label>
                    <p class="container-value-p">{{ marketer.name }}</p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        تعريف المسوق
                    </label>
                    <p class="container-value-p" style="color:blueviolet;font-weight: bold;">
                        <template v-if="marketer.addition_informations != null">
                            {{ marketer.addition_informations.who_you }}
                        </template>
                        <template v-else>
                            -
                        </template>
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        طريقة المتبعة للتسويق
                    </label>
                    <p class="container-value-p" style="color:blueviolet;font-weight: bold;">
                        <template v-if="marketer.addition_informations != null">
                            {{ marketer.addition_informations.which_marketing_will_follow }}
                        </template>
                        <template v-else>
                            -
                        </template>
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اجمالى المبيعات
                    </label>
                    <p class="container-value-p">
                        {{ marketer.total_sales }} MRU
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اجمالى الارباح
                    </label>
                    <p class="container-value-p">
                        {{ marketer.total_profites }} MRU
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        اجمالى أرباح المسوق
                    </label>
                    <p class="container-value-p">
                        {{ marketer.total_profites }} MRU
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        المبالغ الغير مسددة
                    </label>
                    <p class="container-value-p">
                        {{ marketer.total_un_paid ? marketer.total_un_paid : 0 }} MRU
                    </p>
                </div>
            </div>
            <div class="col-lg-6 container-form-new-merchant">
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        رقم الجوال
                    </label>
                    <p class="container-value-p">{{ marketer.phone }}</p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        منتجات المسوق
                    </label>
                    <p class="container-value-p">
                        {{ marketer.products ? marketer.products.length : 0 }} منتج
                        <router-link :to="{path:'/dashboard/show-products-marketer/'+marketer.id}" class="btn btn-primary btn-sm show-products-merchants">عرض منتجات المسوق</router-link>
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        عدد طلبات الشراء
                    </label>
                    <p class="container-value-p">
                        {{ marketer.total_compelete_orders}} طلبات
                        <router-link :to="{path:'/dashboard/show-orders-marketer/'+marketer.id}" class="btn btn-primary btn-sm show-products-merchants">عرض طلبات المسوق</router-link>
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        اجمالى أرباح
                    </label>
                    <p class="container-value-p">
                        {{ marketer.all_marketer_and_platform_orders_profits}} MRU
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                    اجمالى أرباح المنصة
                    </label>
                    <p class="container-value-p">
                        {{ marketer.total_platform_profits }} MRU
                    </p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        المبالغ المسددة
                    </label>
                    <p class="container-value-p">
                        {{ marketer.total_paid ? marketer.total_paid : 0 }} MRU
                    </p>
                </div>
            </div>
        </div>
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
    components:{
        iconsProfile
    },
    data(){
        return{
            marketer:{
                addition_informations:{}
            },
            field:{},
            errors:{},
            success:null,
            iconsProfile,
            loading:true,
            showsuccess:false,
            showerrors:false,
            success_message:'تم انشاء التاجر بنجاح',
            error_message:'حدث خطأ اثناء انشاء التاجر',
        }
    },
    methods:{
        FetchMarketer:function(){
            let self = this;
            console.log(this.$route.params.id);
            axios.get('/api/marketers/'+this.$route.params.id).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.marketer = data.marketer;
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
            console.log(this.merchant);
        },
        UpdateMarketer:function(status){
            let self = this;
            this.field.status = status;
            console.log(this.field);
            axios.put('/api/marketers/'+this.$route.params.id,this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.showsuccess = true;
                self.success_message = data.result;
                self.FetchMarketer();
                console.log(self.success);
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
        },
        UpdateDraftMerchant:function(){
            this.field.status = 0;
            this.UpdateMarketer();
        }
    },
    created(){
        this.FetchMarketer();
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
    padding: 0px;
}
.container-form-new-merchant input[type='text'],
.container-form-new-merchant input[type='tel'],
.container-form-new-merchant input[type='email'],
.container-form-new-merchant input[type='password']
{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
    height: 46px;
}
.container-value-p{
    padding: 5px 30px;
    background-color: #e1dfdf94;
    line-height: 2.5em;
}
.show-products-merchants{
    float: left;
}
.container-body-merchant .profile-image img{
    width: 100px;
}
.container-body-merchant .profile-image
{
    text-align: center;
    padding: 10px;
}
.container-body-merchant .profile-image p
{
    padding: 11px 0px;
    margin-bottom: 0px;
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
    .container-form-new-merchant{
        padding: 0% 5% 0% 5%;
    }
}
</style>

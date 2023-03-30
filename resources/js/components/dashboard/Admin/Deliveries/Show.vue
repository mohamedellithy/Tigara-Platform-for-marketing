<template>
    <div class="container-body-merchant">
        <div class="row">
            <div class="col-lg-11 profile-image">
                <img :src="iconsProfile" />
                <p>
                    <template v-if="delivery.status == 0">
                        <i class="fas fa-circle" style="color:gray;"></i>
                        شركة شحن غير مفعل
                    </template>
                    <template v-if="delivery.status == 1">
                        <i class="fas fa-circle" style="color:#2fc12f"></i>
                        شركة شحن فعال
                    </template>
                </p>
            </div>
            <p>التفاصيل شركة شحن</p>
            <div class="col-lg-6 container-form-new-merchant">
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اسم شركة شحن
                    </label>
                    <p class="container-value-p">{{ delivery.name }}</p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        البريد الالكترونى
                    </label>
                    <p class="container-value-p">{{ delivery.email }}</p>
                </div>
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اجمالى الطلبات
                    </label>
                    <p class="container-value-p">
                        {{ delivery.total_orders }} USD
                    </p>
                </div>

                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اجمالى الأرباح
                    </label>
                    <p class="container-value-p">
                        {{ delivery.total_profits }} USD
                    </p>
                </div>

                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اجمالى أرباح المنصة
                    </label>
                    <p class="container-value-p">
                        {{ delivery.total_platforms_profit_from_delivery_cash }} USD
                    </p>
                </div>

                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اجمالى المدفوعات الغير مسددة
                    </label>
                    <p class="container-value-p">
                        {{ delivery.payments_due }} USD
                    </p>
                </div>
            </div>
            <div class="col-lg-6 container-form-new-merchant">
                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        رقم الجوال
                    </label>
                    <p class="container-value-p">{{ delivery.phone }}</p>
                </div>

                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-mobile-alt" style="padding: 5px;"></i>
                        عدد طلبات الشراء
                    </label>
                    <p class="container-value-p">
                        {{ delivery.orders ? delivery.orders.length : 0 }} طلبات
                        <router-link :to="{path:'/dashboard/show-orders-delivery/'+delivery.id}" class="btn btn-primary btn-sm show-products-merchants">عرض طلبات شركة شحن</router-link>
                    </p>
                </div>

                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اجمالى المبيعات
                    </label>
                    <p class="container-value-p">
                        {{ delivery.total_sales }} USD
                    </p>
                </div>

                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        اجمالى أرباح شركة الشحن
                    </label>
                    <p class="container-value-p">
                        {{ delivery.total_delivery_profits }} USD
                    </p>
                </div>

                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                         اجمالى المدفوعات المستحقة
                    </label>
                    <p class="container-value-p">
                        {{ delivery.payments_total }} USD
                    </p>
                </div>

                <div class="form-group">
                    <label for="merchant-name">
                        <i class="fas fa-user-edit" style="padding: 5px;"></i>
                        المدفوعات المسددة
                    </label>
                    <p class="container-value-p">
                        {{ delivery.payments_made }} USD
                    </p>
                </div>
            </div>
        </div>
        <div v-if="this.loading" style="position: fixed;top: 0px;bottom: 0px;background-color:#1d2024d1;left: 0;right: 0;z-index: 100000;text-align: center;">
            <img style="margin: 10% auto;" src="@/img/Enso-2.gif"/>
        </div>
    </div>
</template>
<script>
import iconsProfile from '@/img/shipping-delivery.png';
export default {
    components:{
        iconsProfile
    },
    data(){
        return{
            delivery:{},
            errors:{},
            success:null,
            iconsProfile,
            loading:true
        }
    },
    methods:{
        FetchDelivery:function(){
            let self = this;
            console.log(this.$route.params.id);
            axios.get('/api/deliveries/'+this.$route.params.id).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.delivery = data.delivery;
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
            console.log(this.merchant);
        },
        UpdateDelivery:function(){
            let self = this;
            axios.put('/api/deliveries/'+this.$route.params.id,this.marketer).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.success  = data.result;
                console.log(self.success);
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
        },
        UpdateDraftDelivery:function(){
            this.field.status = 0;
            this.UpdateDelivery();
        }
    },
    created(){
        this.FetchDelivery();
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
        font-size: 10px;
    }
    .filter-bar .filter-results .filter-item{
        font-size: 11px;
        margin-bottom: 2px;
    }
}
</style>

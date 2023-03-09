<template>
    <div class="container-body-merchant">
        <form method="post" @submit.prevent="UpdateProduct">
            <div class="row">
                <h3 class="col-md-8 title-merchant">
                    <i class="fas fa-pallet" style="font-size: 18px;"></i>
                    الطلب رقم # {{ order.id }}
                </h3>
            </div>
            <div class="row">
                <div class="col-lg-12 container-form-new-merchant">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="alert" style="margin-bottom:0px;padding-bottom: 0px;">
                                <strong>
                                    بيانات الطلبية
                                </strong>
                            </p>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    رقم الطلب
                                </label>
                                <p class="alert">{{ order.id }}</p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    سعر الطلبية
                                </label>
                                <p class="alert">{{ order.total }} USD</p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    كمية الطلبية
                                </label>
                                <p class="alert">{{ order.quantity  }}</p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    حالة الطلبية
                                </label>
                                <p class="alert">{{ order.order_status_txt }}</p>
                            </div>
                        </div>
                        <div class="col-lg-3" v-if="order.cash_delivered > 0">
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    ما تم تحصيلة من الزبون
                                </label>
                                <p class="alert">{{ order.cash_delivered }} USD</p>
                            </div>
                        </div>
                        <div class="col-lg-3" v-if="order.cash_delivery_refund">
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    ما تم استرجاعه الى الزبون
                                </label>
                                <p class="alert">{{ order.cash_delivery_refund }} USD</p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    حالة الشحن
                                </label>
                                <p class="alert">{{ order.shipping_status_txt }}</p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    تاريخ الانشاء
                                </label>
                                <p class="alert">{{ order.created_at }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    ملاحظات شركة الشحن
                                </label>
                                <p class="alert">{{ order.delivery_notice || 'لا توجد اى ملاحظات' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr/>
                        <br/>
                        <div class="col-lg-6">
                            <p class="alert" style="margin-bottom:0px;padding-bottom: 0px;">
                                <strong>
                                    تفاصيل شركة الشحن
                                </strong>
                            </p>
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    اسم شركة الشحن
                                </label>
                                <p v-if="order.delivery" class="alert">
                                    {{ order.delivery.name }}
                                    <router-link  class="btn btn-primary btn-sm" style="float:left" :to="{path:'/dashboard/show-delivery/'+order.delivery.id}">تفاصيل</router-link>
                                </p>
                                <p v-else class="alert">
                                    لم تحدد بعد
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <p class="alert" style="margin-bottom:0px;padding-bottom: 0px;">
                                <strong>
                                 تفاصيل المسوق
                                </strong>
                            </p>
                            <div class="form-group">
                                <label for="merchant-name">
                                <i class="fas fa-user-edit" style="padding: 5px;"></i>
                                    اسم المسوق
                                </label>
                                <p class="alert">
                                    {{ order.marketer.name }}
                                    <router-link class="btn btn-primary btn-sm" style="float:left" :to="{path:'/dashboard/show-marketer/'+order.marketer.id}">تفاصيل</router-link>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <hr/>
                        <br/>
                        <div class="col-lg-12">
                            <p class="alert" style="margin-bottom:0px;">
                                <strong>
                                    تفاصيل الطلبية
                                </strong>
                            </p>
                            <table class="table table-condensed">
                                <thead class="table-light">
                                    <tr>
                                        <td>اسم المنتج</td>
                                        <td>كمية</td>
                                        <td>خصم </td>
                                        <td>سعر الوحدة</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(order_detail,key) in order.order_details" :key="key">
                                        <td>
                                            <router-link style="text-decoration:none" :to="{path:'/dashboard/show-product/'+order_detail.id}">
                                                {{ order_detail.product_name }}
                                            </router-link>
                                        </td>
                                        <td>{{ order_detail.quantity }}</td>
                                        <td>{{ order_detail.discount }}</td>
                                        <td>{{ order_detail.unit_price }} USD</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <strong>
                                                المجموع الكلي
                                            </strong>
                                        </td>
                                        <td colspan="2">
                                            <strong>
                                                {{ order.total }} USD
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import ImageUploadHere from '@/img/upload-1118929_960_720.webp';
import AttachmentsUploadHere from '@/img/upload-1118929_960_720.webp';
export default {
    components: {ImageUploadHere,AttachmentsUploadHere},
    data(){
        return{
            order:{
                delivery:{},
                marketer:{}
            },
            errors:{},
            success:null
        }
    },
    methods:{
        FetchOrder:async function(){
            let self = this;
            let attachments;
            console.log(this.$route.params.id);
            await axios.get('/api/orders/'+this.$route.params.id).then(function({data}) {
                self.errors        = {};
                self.order       = data.order;
                console.log(self.order);
            }).catch(function({response}) {
                self.errors = response.data;
            });
        }
    },
    async created(){
        await this.FetchOrder();
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
    /* padding: 0% 0% 0% 5%; */
    padding: 0% 0% 0% 1%;
}
.container-form-new-merchant .form-group label
{
    line-height: 3em;
    font-size: 14px;
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
.container-form-new-merchant input[type='text']
{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
    height: 46px;
}
.container-form-new-merchant textarea{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
}
.attachments{
    padding: 10px 10px;
}
.upload-product-image{
    text-align: center;
    list-style: none;
    text-align: center;
    list-style: none;
    padding: 15px;
    border: 5px dashed #eee;
    cursor: pointer;
    margin-bottom:20%;
    background: #fff;
}
.upload-product-image p
{
    padding: 15px;
    font-weight: bold;
}
.btn-upload-attachment{
     margin-bottom:5%;
     list-style: none;
     position:relative;
}
.upload-attachments-image{
    border: 1px solid #f4f2f2;
    list-style: none;
    background-color: white;
    padding: 12px;
}
.upload-attachments-image label{
    padding: 15px;
}
.btn-upload-attachment button{
    width: 100%;
}
.btn-upload-attachment input[type="file"]{
    position: absolute;
    left: 0px;
    top: 0px;
    right: 0px;
    opacity: 0;
    z-index: 1000;
    cursor: pointer;
}
.form-group .alert{
    font-weight: bold;
    margin: 0px;
    padding: 10px 32px;
    background-color: #eee;
    border-radius: 0px;
}
hr{
    border: 2px dashed gray;
    height: 1px;
    margin: 18px;
}
</style>

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
                <div class="col-12" style="text-align: left;">
                    <template v-if="order.order_status != '4'">
                        <button v-if="order.delivery" @click="SingleStatus(order)" class="btn btn-warning btn-sm">
                            تحديث الحالة
                        </button>

                        <button v-if="!order.delivery" @click="AttachOrderDelivery(order)" class="btn btn-warning btn-sm">
                            تحديد شركة الشحن
                        </button>
                    </template>
                </div>
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
                        <div class="col-lg-6">
                            <p class="alert" style="margin-bottom:0px;">
                                <strong>
                                    تفاصيل الزبون
                                </strong>
                            </p>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>اسم الزبون</th>
                                        <td>{{ order.customer.name  }}</td>
                                    </tr>
                                    <tr>
                                        <th>رقم الجوال</th>
                                        <td>{{ order.customer.phone  }}</td>
                                    </tr>
                                    <tr>
                                        <th>رقم جوال اخر</th>
                                        <td>{{ order.customer.another_phone  }}</td>
                                    </tr>
                                    <tr>
                                        <th>المدينة</th>
                                        <td>{{ order.customer.city  }}</td>
                                    </tr>
                                    <tr>
                                        <th>العنوان كاملا</th>
                                        <td>{{ order.customer.address  }}</td>
                                    </tr>
                                    <tr>
                                        <th>ملاحظات اخري</th>
                                        <td>{{ order.customer.notice  }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
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
        <div v-show="this.showModel == true " id="exampleModalLive" class="modal fade " :class="[ this.showModel == true ? 'show' : '' ]" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" :style="`padding-right: 17px; display:block;padding-top: 10%;z-index: 100000;background:rgb(0 0 0 / 28%)`">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <template v-if="field.delivery_model">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLiveLabel">
                                        ارفاق شركة الشحن للطلبية رقم
                                        <template v-if="field.order_id != null">
                                            # {{ field.order_id }}
                                        </template>
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <p>شركة الشحن</p>
                                    <select type="text" class="form-control" v-model="field.delivery_id">
                                        <option v-for="(delivery,key) in deliveries" :value="delivery.id" :key="key">{{  delivery.name  }}</option>
                                    </select>
                                </div>
                            </template>
                            <template v-else>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLiveLabel">
                                        تحديث حالة الطلب
                                        <template v-if="field.order_id != null">
                                            # {{ field.order_id }}
                                        </template>
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <p>حالة الطلبية</p>
                                    <select type="text" class="form-control" v-model="field.order_status">
                                        <option :value="0" selected>بانتظار الموافقة</option>
                                        <option :value="1">جاري التنفيذ</option>
                                        <option :value="2">مكتملة</option>
                                        <option :value="3">مرفوضة</option>
                                    </select>
                                </div>
                                <div class="modal-body">
                                    <p>حالة الشحن</p>
                                    <select type="text" class="form-control" v-model="field.shipping_status">
                                        <option :value="0" selected>بانتظار الموافقة</option>
                                        <option :value="1">جاري التنفيذ</option>
                                        <option :value="2">مكتملة</option>
                                        <option :value="3">مرفوضة</option>
                                    </select>
                                </div>
                            </template>
                            <div class="modal-footer">
                                <template v-if="field.order_id == null">
                                    <button @click="UpdateStatus()" type="button" class="btn btn-primary btn-sm" fdprocessedid="3xp1pw">تحديث الحالة</button>
                                </template>
                                <template v-if="field.order_id != null">
                                    <button @click="UpdateSingleStatus(field.order_id)" type="button" class="btn btn-primary btn-sm" fdprocessedid="3xp1pw">تحديث الحالة</button>
                                </template>
                                <button @click="CloseModelUpdateStatus()" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" fdprocessedid="c9npk">الغاء</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                marketer:{},
                customer:{}
            },
            errors:{},
            success:null,
            showModel:false,
            field:{
                order_status:0,
                shipping_status:0,
                order_id:null,
                ids:[],
                delivery_model:false
            },
            deliveries:[],
            showsuccess:false,
            showerrors:false,
            success_message:'تم انشاء التاجر بنجاح',
            error_message:'حدث خطأ اثناء انشاء التاجر'
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
        },
        FetchDeliveries:async function(){
            let self = this;
            await axios.get('/api/deliveries',{
                params:{
                    paginate : '-1'
                }
            }).then(function({data}){
                console.log(data);
                self.deliveries       = data.data_info;
                console.log(self.deliveries,'nnnnnnnnnnn');
            }).catch(function({response}){
                console.log(response);
            });
        },
        ShowModelUpdateStatus:function(){
           this.showModel = true;
        },
        CloseModelUpdateStatus:function(){
            this.field = {
                order_status:0,
                shipping_status:0,
                order_id:null,
                ids:[]
            }
           this.showModel = false;
        },
        SingleStatus:function(order){
            let self = this;
            this.field.order_status = order.order_status;
            this.field.shipping_status = order.shipping_status;
            this.field.order_id = order.id;
            this.ShowModelUpdateStatus();
        },
        AttachOrderDelivery:function(order){
            let self = this;
            this.field.delivery_model = true;
            this.field.order_id = order.id;
            console.log(this.field);
            this.ShowModelUpdateStatus();
        },
        UpdateSingleStatus:function(order_id){
            let self = this;
            axios.put('/api/orders/'+order_id,this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.showsuccess = true;
                self.success_message = data.result;
                console.log(self.success);
                self.params = {
                    page:(self.$route.params.page_no ? self.$route.params.page_no : 1)
                };
                self.FetchOrder();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.showerrors = true;
                self.errors = response.data;
            });
        }
    },
    async created(){
        await this.FetchOrder();
        await this.FetchDeliveries();
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

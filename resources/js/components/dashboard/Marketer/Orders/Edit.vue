<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="top-cart-complete">
                    <li @click="this.$router.push({
                        path:'/marketer/edit-order/' + this.$route.params.order_id
                    })" :class="!this.$route.params.action ? 'active':''" style="cursor:pointer">
                        <span class="container-icon">
                            <i class="fas fa-pallet"></i>
                        </span>
                        <label>بيانات الطلبية</label>
                    </li>
                    <li @click="this.$router.push({
                        path:'/marketer/edit-order/' + this.$route.params.order_id + '/customer-info'
                        })" :class="this.$route.params.action == 'customer-info' ? 'active':''" style="cursor:pointer">
                        <span class="container-icon">
                            <i class="fas fa-id-card-alt"></i>
                        </span>
                        <label>بيانات الزبون</label>
                    </li>
                </ul>
                <div class="row">
                    <div class="container-page-content" v-if="!this.$route.params.action">
                        <h4 style="padding:10px">تفاصيل الطلبية</h4>
                        <div class="content-mini-cart">
                            <table class="table mini-cart">
                                <tr>
                                    <th>المنتج</th>
                                    <th>كمية المنتج</th>
                                    <th>سعر المنتج</th>
                                    <th>ارباحك</th>
                                    <th></th>
                                </tr>
                                <tr v-for="(item,key) in order.order_details" :key="key">
                                    <td>
                                        <img :src="item.product.thumbnail_item.image_url"  class="mini-cart-product-image"/>
                                        <label class="product-name">
                                            {{ item.product.name }}
                                        </label>
                                    </td>
                                    <td>
                                        <span class="fas fa-plus quantity-varite" @click="PlusQuantity(item,key)"></span>
                                        <label class="quantity-mini-cart">{{  item.quantity || 1  }}</label>
                                        <span class="fas fa-minus quantity-varite" @click="MinusQuantity(item,key)"></span>
                                    </td>
                                    <td>{{ item.unit_price }} USD</td>
                                    <td>{{ item.product.marketer_profit * item.quantity }} USD</td>
                                    <td>
                                        <i class="fas fa-times-circle" @click="deleteItemFromOrder(item,key)"></i>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <ul class="buttons-arrows-actions">
                            <li>
                                <button @click="UpdateOrderDetails()" class="btn prev btn-block">
                                    تعديل الطلبية
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="container-page-content" v-if="this.$route.params.action == 'customer-info'">
                        <h4 style="padding:10px">بيانات الزبون</h4>
                        <form method="post" @submit.prevent="UpdateCustomerInfo()">
                            <div class="row content-customer-info">
                                <div class="form-group col-md-12">
                                    <!-- <label class="form-label">اسم الزبون</label> -->
                                    <input v-model="order.customer.name" type="text" class="form-control" placeholder="اسم الزبون" required/>
                                </div>
                                <div class="form-group col-md-12">
                                    <!-- <label class="form-label">البريد الالكترونى</label> -->
                                    <input v-model="order.customer.email" type="text" class="form-control" placeholder="البريد الالكترونى" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label class="form-label">رقم الجوال</label> -->
                                    <input v-model="order.customer.another_phone" type="text" class="form-control" placeholder="رقم جوال أخر" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label class="form-label">رقم الجوال</label> -->
                                    <input v-model="order.customer.phone" type="text" class="form-control" placeholder="رقم الجوال" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label class="form-label">المدينة</label> -->
                                    <select v-model="order.customer.city" class="form-control" placeholder="المدينة" required>
                                        <option value="undefined" disabled selected>المدينة</option>
                                        <option v-for="(city,key) in cities" :value="city" :key="key">{{ city }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <!-- <label class="form-label">العنوان بالكامل</label> -->
                                    <textarea v-model="order.customer.address" class="form-control" placeholder="العنوان بالكامل" required></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <!-- <label class="form-label">ملاحظات </label> -->
                                    <textarea v-model="order.customer.notice" class="form-control" placeholder="ملاحظات "></textarea>
                                </div>
                            </div>
                            <ul class="buttons-arrows-actions">
                                <li>
                                    <button type="submit" class="btn prev btn-block">
                                        تعديل بيانات الزبون
                                    </button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 order-details">
                <div class="order-details-info">
                    <h5 style="padding:20px">تفاصيل الطلب</h5>
                    <table class="table">
                        <tr>
                            <th>رقم الطلبية</th>
                            <td>
                                <strong># {{ order.id }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>كمية الطلبية</th>
                            <td>
                                <strong>{{ order.quantity }} قطعة</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>الخصم على الطلبية</th>
                            <td>
                                <strong>0 USD</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>اجمالى الطلبية</th>
                            <td>
                                <strong>{{ order.total }} USD</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>الربح من الطلبية</th>
                            <td>
                                <strong>{{ order.marketer_profit }} USD</strong>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-center">
                                <router-link :to="{path:'/marketer/show-order/'+this.$route.params.order_id}" class="btn completeShoping">
                                    <i class="fas fa-eye"></i>
                                    تفاصيل الطلب
                                </router-link>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <alert-response :showsuccess="showsuccess" :showerrors="showerrors"
        @update_success="showsuccess = false"
        @update_errors="showerrors = false" :errors="errors"
        :success_message="success_message"
        :error_message="error_message"></alert-response>
        <div class="loading-overflow" v-show="showLoading">
            <img :src="loading" />
        </div>
    </div>
</template>

<script>
import loading from '@/img/loading.webp';
export default{
    components: {loading},
    data(){
        return {
            message: 'Hello World',
            loading,
            customer:{},
            cities:[
                'نواكشوط',
                'المدينة',
                'البليلة'
            ],
            order:{
                customer:{}
            },
            showsuccess:false,
            showerrors:false,
            success_message:'تم تحديث الطلب بنجاح',
            error_message:'حدث خطأ اثناء تحديث الطلب ',
            showLoading:false
        }
    },
    methods : {
        FetchOrderItems:async function(){
            let self = this;
            await axios.get('/api/marketer-orders/'+this.$route.params.order_id).then(function({data}){
                console.log(data);
                self.order = data.order;
            }).catch(function({response}){
                console.log(response);
            });
        },
        UpdateOrder:async function(field){
            let self = this;
            self.showLoading = true;
            axios.put('/api/marketer-orders/'+this.$route.params.order_id,field).then(function({data}){
                console.log(data);
                self.order = data.order;
                if(data.status){
                    self.showerrors = true;
                    self.error_message = data.status;
                } else {
                    self.showsuccess = true;
                }
                self.showLoading = false;
            }).catch(function({response}){
                console.log(response);
                self.showerrors = true;
                self.showLoading = false;
            });
        },
        PlusQuantity:async function(item,key){
            let self = this;
            self.order.order_details[key].quantity += 1;
        },
        MinusQuantity:async function(item,key){
            let self = this;
            if(item.quantity == 1){
                return;
            }
            self.order.order_details[key].quantity -= 1;
        },
        deleteItemFromOrder:async function(item,key){
            let self = this;
            self.order.order_details.splice(key,1);
        },
        UpdateOrderDetails:async function(){
           let self = this;
           let field = {};
           field.order_details = self.order.order_details;
           self.UpdateOrder(field);
        },
        UpdateCustomerInfo:async function(){
            let self = this;
            let field = {};
            field.customer = self.order.customer;
            self.UpdateOrder(field);
        }
    },
    async created(){
        let self = this;
        this.FetchOrderItems();
    }
}
</script>
<style scoped>
.order-details{
    padding:20px;
}
.order-details-info{
    /* background-color: #75e3b087; */
    background-color: white;
    box-shadow: 3px 13px 13px 14px #eee;
}
.order-details-info tr:not(tr:last-child)
{
    border-bottom: 2px dashed #5c5b5b47;
}
.order-details-info tr th,
.order-details-info tr td
{
    padding:30px;
}
.order-details-info tr th{
    text-align: right;
}
.order-details-info tr td{
    text-align: left;
}
.completeShoping{
    background-color: #171717;
    border-radius: 29px;
    padding: 6px 14px;
    color: white;
}
.DetailsSOrder{
    background-color: hsl(11deg 80% 45%);
    border-radius: 29px;
    padding: 6px 14px;
    color: white;
    margin: 10px;
}
.top-cart-complete{
    list-style: none;
    text-align: center;
}
.top-cart-complete li
{
    display: inline-block;
    padding: 22px 40px;
}
.top-cart-complete li span
{
    display: block;
    background-color: white;
    padding: 19px;
    border-radius: 74px;
    border: 6px solid #b5beba;
}
.top-cart-complete li span i
{
    font-size: 40px;
    color: #c4c4c4;
}
.top-cart-complete li label
{
    line-height: 2.5em;
}
.top-cart-complete li.active span{
    border:6px solid #087c46c9;
}
.top-cart-complete li.active span i{
    color: #ffc30d;
}

.container-page-content{
    background-color: white;
    padding: 10px;
}
.container-page-content
{
    padding: 10px 7px;
}

.container-page-content table.mini-cart tr{
    border-bottom: 2px solid #eee;;
}
.container-page-content table.mini-cart tr:first-child
{
    position: sticky;
    top: 0px;
    background-color: white;
}
.container-page-content table.mini-cart tr th{
    padding: 10px;
    text-align: right;
}
.container-page-content table.mini-cart tr th:first-child{
    width: 45%;
}
.container-page-content table.mini-cart tr td{
    padding: 10px;
    text-align: right;
    width: 35%;
}
.container-page-content table.mini-cart tr td i.fa-times-circle{
    color: red;
    cursor: pointer;
}
.go_to_checkout{
    background-color: #1b965d;
    color: white;
    margin: auto;
    border-radius: 27px;

}
.container-page-content table.mini-cart tr td img.mini-cart-product-image{
    width: 25%;

}
.quantity-mini-cart{
    background: #eee;
    text-align: center;
    font-weight: bold;
    padding: 4px 26px;
}
.quantity-varite{
    padding: 1px 6px;
    font-size: 13px;
    cursor: pointer;
}
.container-page-content table.mini-cart tr td .product-name{
    font-weight: 500;
    padding: 6px;
    font-size: 13px;
}
.buttons-arrows-actions{
    padding: 10px 0px !important;
}
.buttons-arrows-actions li .btn{
   padding: 5px 20px;
   border-radius: 30px;
}
.buttons-arrows-actions li{
    display: inline-block;
    margin: 2px 10px;
}
.buttons-arrows-actions li .btn.prev{
    background-color:#991414;
    border:2px solid #991414;
    color:white;
}
.buttons-arrows-actions li .btn.next{
    background-color:#198754;
    border:2px solid #198754;
}
.content-customer-info{
    padding:0px 10px;
}
.content-customer-info .form-group
{
    padding: 16px 15px;
}
.content-customer-info .form-group .form-control{
    height: 50px;
    background-color:#eee;
}
.content-customer-info .form-group textarea.form-control{
   height: 65px;
}
.order-status-summary{
    color:black
}
.order-status-summary tr:not(:last-child)
{
    border-bottom: 1px solid #eee;
}
.order-status-summary tr th,
.order-status-summary tr td{
    padding: 14px;
}
.order-status-summary tr:last-child th ,
.order-status-summary tr:last-child td{
    border-bottom: 0px;
}

.loading-overflow{
    position: fixed;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    z-index: 1000000;
    width: 100% !important;
    text-align: center;
    padding-top: 12%;
    background-color: #06060647;
}
.loading-overflow img{
    width: 20% !important;
    margin: auto;

}
</style>

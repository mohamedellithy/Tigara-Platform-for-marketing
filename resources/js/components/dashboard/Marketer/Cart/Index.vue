<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="top-cart-complete">
                    <li :class="!this.$route.params.action ? 'active':''">
                        <span class="container-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </span>
                        <label>السلة</label>
                    </li>
                    <li :class="this.$route.params.action == 'customer-info' ? 'active':''">
                        <span class="container-icon">
                            <i class="fas fa-id-card-alt"></i>
                        </span>
                        <label>بيانات الزبون</label>
                    </li>
                    <li :class="this.$route.params.action == 'order-status' ? 'active':''">
                        <span class="container-icon">
                            <i class="fas fa-pallet"></i>
                        </span>
                        <label>تفاصيل الطلب</label>
                    </li>
                </ul>
                <div class="row">
                    <div class="container-page-content" v-if="!this.$route.params.action">
                        <ul class="buttons-arrows-actions">
                            <li>
                                <router-link :to="{name:'marketer-products'}" class="btn prev btn-block">
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                    السابق
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{path:'/marketer/carts/customer-info'}" class="btn btn-primary next btn-block">
                                    التالى
                                    <i class="fas fa-long-arrow-alt-left"></i>
                                </router-link>
                            </li>
                        </ul>
                        <h4>تفاصيل السلة</h4>
                        <div class="content-mini-cart">
                            <table class="table mini-cart">
                                <tr>
                                    <th>المنتج</th>
                                    <th>كمية المنتج</th>
                                    <th>سعر المنتج</th>
                                    <th>ارباحك</th>
                                    <th></th>
                                </tr>
                                <tr v-for="(item,key) in cart_items" :key="key">
                                    <td>
                                        <img :src="item.product.thumbnail_item.image_url"  class="mini-cart-product-image"/>
                                        <label class="product-name">
                                            {{ item.product.name }}
                                        </label>
                                    </td>
                                    <td>
                                        <span class="fas fa-plus quantity-varite" @click="PlusQuantity(item)"></span>
                                        <label class="quantity-mini-cart">{{  item.quantity || 1  }}</label>
                                        <span class="fas fa-minus quantity-varite" @click="MinusQuantity(item)"></span>
                                    </td>
                                    <td>{{ item.price }} USD</td>
                                    <td>{{ item.product.marketer_profit * item.quantity }} USD</td>
                                    <td>
                                        <i class="fas fa-times-circle" @click="deleteItemFromCart(item)"></i>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="container-page-content" v-if="this.$route.params.action == 'customer-info'">
                        <ul class="buttons-arrows-actions">
                            <li>
                                <router-link :to="{path:'/marketer/carts'}" class="btn prev btn-block">
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                    السابق
                                </router-link>
                            </li>
                        </ul>
                        <h4>بيانات الزبون</h4>
                        <form method="post" @submit.prevent="AddCustomerInfo()">
                            <div class="row content-customer-info">
                                <div class="form-group col-md-12">
                                    <!-- <label class="form-label">اسم الزبون</label> -->
                                    <input v-model="customer.name" type="text" class="form-control" placeholder="اسم الزبون" required/>
                                </div>
                                <div class="form-group col-md-12">
                                    <!-- <label class="form-label">البريد الالكترونى</label> -->
                                    <input v-model="customer.email" type="text" class="form-control" placeholder="البريد الالكترونى" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label class="form-label">رقم الجوال</label> -->
                                    <input v-model="customer.phone" type="text" class="form-control" placeholder="رقم الجوال" required/>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label class="form-label">رقم الجوال</label> -->
                                    <input v-model="customer.another_phone" type="text" class="form-control" placeholder="رقم جوال بديل"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label class="form-label">المدينة</label> -->
                                    <select v-model="customer.city" class="form-control" placeholder="المدينة" required>
                                        <option v-for="(city,key) in cities" :value="city" :key="key">{{ city }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <!-- <label class="form-label">العنوان بالكامل</label> -->
                                    <textarea v-model="customer.address" class="form-control" placeholder="العنوان بالكامل" required></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <!-- <label class="form-label">ملاحظات </label> -->
                                    <textarea v-model="customer.notice" class="form-control" placeholder="ملاحظات "></textarea>
                                </div>
                            </div>
                            <ul class="buttons-arrows-actions">
                                <li>
                                    <button type="submit" class="btn btn-primary next btn-block">
                                        التالى
                                        <i class="fas fa-long-arrow-alt-left"></i>
                                    </button>
                                </li>
                            </ul>
                        </form>
                    </div>
                    <div class="container-page-content" v-if="this.$route.params.action == 'order-status'">
                        <p class="alert text-center" style="background-color: #5ed09b;border-radius: 0px;color: white;font-weight: bold;">
                            تم انشاء الطلبية بنجاح
                        </p>
                        <h6 style="padding:10px">حالة الطلبية </h6>
                        <table class="table order-status-summary">
                            <tr>
                                <th>رقم الطلب </th>
                                <td># {{ order.id  }}</td>
                            </tr>
                            <tr>
                                <th>كمية الطلبية</th>
                                <td>{{  order.quantity  }}</td>
                            </tr>
                            <tr>
                                <th>حالة الطلبية</th>
                                <td>{{  order.order_status_txt  }}</td>
                            </tr>
                            <tr>
                                <th>حالة الشحن</th>
                                <td>{{ order.shipping_status_txt  }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <router-link :to="{path:'/marketer/show-order/'+order.id}" class="btn DetailsSOrder">
                                        <i class="fas fa-eye"></i>
                                        تفاصيل الطلبية
                                    </router-link>
                                    <router-link :to="{path:'/marketer/products'}" class="btn completeShoping">
                                        <i class="fas fa-shopping-cart"></i>
                                        استكمال التسوق
                                    </router-link>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4 order-details">
                <div class="order-details-info">
                    <h5 style="padding:20px">تفاصيل الطلب</h5>
                    <table class="table">
                        <tr>
                            <th>كمية الطلبية</th>
                            <td>
                                <strong>{{ total_cart_items }} قطعة</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>عدد المنتجات</th>
                            <td>
                                <strong>{{  total_products  }} منتج</strong>
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
                                <strong>{{  total_cart_cost  }} USD</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>الربح من الطلبية</th>
                            <td>
                                <strong>{{ total_marketer_profits }} USD</strong>
                            </td>
                        </tr>
                       
                        <tr>
                            <td colspan="2" class="text-center">
                                <button class="btn completeShoping">
                                    <i class="fas fa-shopping-cart"></i>
                                    متابعة التسوق
                                </button>
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
            cart_items:[],
            total_cart_cost:0,
            total_cart_items : 0,
            total_products : 0,
            total_marketer_profits : 0,
            customer:{},
            cities:[
                'نواكشوط',
                'المدينة',
                'البليلة'
            ],
            order:{},
            showsuccess:false,
            showerrors:false,
            success_message:'تم تحديث السلة بنجاح',
            error_message:'حدث خطأ اثناء تحديث السلة ',
            showLoading:false
        }
    },
    methods : { 
        FetchCartItems:async function(){
            let self = this;
            await axios.get('/api/marketer-carts').then(function({data}){
                console.log(data);
                self.cart_items = data.cart_items;
                self.total_cart_cost = data.total_cart_cost;
                self.total_cart_items = data.total_cart_items;
                self.total_products = data.total_products;
                self.total_marketer_profits = data.total_marketer_profits;

            }).catch(function({response}){
                console.log(response);
            });
        },
        PlusQuantity:async function(item){
            let self = this;
            let field = {};
            field.type = "plus";
            self.showLoading = true;
            await axios.put('/api/marketer-carts/'+item.id,field).then(function({data}){
                self.cart_items = data.cart_items;
                self.$emit('updateQuantity',data.total_quantity,data.cart_items);
                self.total_cart_cost = data.total_cart_cost;
                self.total_cart_items = data.total_cart_items;
                self.total_products = data.total_products;
                self.total_marketer_profits = data.total_marketer_profits;
                if(data.status){
                    self.showerrors = true;
                    self.error_message = data.status;
                }
                console.log(data);
            }).catch(function({response}){
                console.log(response);
                self.showLoading = false;
            }).then(function(){
                self.showsuccess = true;
                self.showLoading = false;
            });
        },
        MinusQuantity:async function(item){
            let self = this;
            let field = {};
            if(item.quantity == 1){
                return;
            }
            field.type = "minus";
            self.showLoading = true;
            await axios.put('/api/marketer-carts/'+item.id,field).then(function({data}){
                self.cart_items = data.cart_items;
                self.$emit('updateQuantity',data.total_quantity,data.cart_items);
                self.total_cart_cost = data.total_cart_cost;
                self.total_cart_items = data.total_cart_items;
                self.total_products = data.total_products;
                self.total_marketer_profits = data.total_marketer_profits;
                console.log(data);
            }).catch(function({response}){
                console.log(response);
                self.showLoading = false;
            }).then(function(){
                self.showsuccess = true;
                self.showLoading = false;
            });
        },
        deleteItemFromCart:async function(item){
            let self = this;
            self.showLoading = true;
            await axios.delete('/api/marketer-carts/'+item.id).then(function({data}){
                self.cart_items = data.cart_items;
                self.total_cart_cost = data.total_cart_cost;
                self.total_cart_items = data.total_cart_items;
                self.total_products = data.total_products;
                self.total_marketer_profits = data.total_marketer_profits;
                self.$emit('updateQuantity',data.total_quantity,data.cart_items);
                console.log(data);
            }).catch(function({response}){
                console.log(response);
                self.showLoading = false;
            }).then(function(){
                self.showsuccess = true;
                self.showLoading = false;
            });
        },
        AddCustomerInfo:async function(){
            let self = this;
            self.showLoading = true;
            window.localStorage.setItem('customer',JSON.stringify(this.customer));
            await axios.post('/api/marketer-orders',this.customer).then(function({data}){
                console.log(data);
                self.$emit('updateQuantity',0,[]);
                self.$router.push({path:'/marketer/carts/order-status/'+data.order.id})
            }).catch(function({response}){
                console.log(response);
                self.showerrors = true;
                self.errors = response.data.errors;
                self.showLoading = false;
            }).then(function(){
                self.showsuccess = true;
                self.showLoading = false;
            });
        }
    },
    async created(){
        let self = this;
        this.FetchCartItems();
        self.customer = JSON.parse(window.localStorage.getItem('customer')) || {};
        if(this.$route.params.action == 'order-status'){
            await axios.get('/api/marketer-orders/'+this.$route.params.order_id).then(function({data}){
                 self.order = data.order;
                 console.log(data);
            }).catch(function({response}){
                 console.log(response);
            });
        }
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
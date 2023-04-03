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
        </div>
        <div class="row">
            <div class="content-page col-12">
                <div class="filter-bar">
                    <div class="row">
                        <div v-if="Object.keys(this.errors).length !== 0" class="col-12 container-errors">
                            <div class="alert alert-danger">
                                <ul>
                                    <li v-for="(error,index) in errors" :key="index"> {{ error[0] }}</li>
                                </ul>
                            </div>
                        </div>
                        <div v-if="this.success" class="col-12 container-errors">
                            <div class="alert alert-success">
                                <p>{{ success }}</p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <ul class="filter-results">
                                <li class="actions-btn">
                                    <button @click="ShowModelUpdateStatus" class="btn btn-warning btn-sm" :disabled="(selected.length == 0)">
                                        تحديث الحالة
                                    </button>
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-users"></i>
                                    {{ orders.length }} الطلبات
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ active_orders }} جاري التنفيذ
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                    {{ no_active_orders }} انتظار الموافقة
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-check"></i>
                                    {{ active_orders }} المكتملة
                                </li>
                                <li class="filter-item">
                                    <i class="fas fa-user-slash"></i>
                                    {{ no_active_orders }} المرفوضة
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <input type="text" placeholder="البحث فى الطلبات" v-model="search" class="form-control search-input"/>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <!--Table-->
                    <table class="table">
                        <!--Table head-->
                        <thead>
                            <tr>
                                <th>
                                    <input class="" type="checkbox" v-model="selected_all"/>
                                </th>
                                <th>رقم الطلب</th>
                                <th>المسوقين</th>
                                <th>كمية الطلبية</th>
                                <th>سعر الطلبية</th>
                                <th>حالة الطلب</th>
                                <th>حالة الشحن</th>
                                <th>تاريخ الطلب</th>
                                <th></th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            <tr v-for="(order, key) in orders" :key="key">
                                <th scope="row">
                                    <input type="checkbox" v-model="selected" :value="order.id" :checked="selected.indexOf(order.id) != -1"/>
                                </th>
                                <th scope="row"> # {{ order.id }}</th>
                                <td>{{ order.marketer.name }}</td>
                                <td>{{ order.quantity  }}</td>
                                <td>{{ order.total }} MRU</td>
                                <td>{{ order.order_status_txt }}</td>
                                <td>{{ order.shipping_status_txt }}</td>
                                <td>{{ order.created_at }}</td>
                                <td class="actions-btn">
                                    <router-link :to="{path:'/dashboard/edit-product/'+order.id}"  class="btn btn-primary btn-sm">
                                        عرض
                                    </router-link>
                                    <button @click="SingleStatus(order)" class="btn btn-warning btn-sm">
                                        تحديث الحالة
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                    <nav v-if="this.infos.length != 0" aria-label="Page navigation example">
                        <ul v-if="this.infos.total > orders.length" class="pagination">
                            <li v-if="(this.infos.current_page != 1)" class="page-item">
                                <router-link class="page-link" :to="{path: '/dashboard/show-orders-merchant/'+this.$route.params.id+'/'+(this.infos.current_page - 1 == 0 ? 1 : this.infos.current_page - 1) }" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </router-link>
                            </li>
                            <li v-for="page in this.infos.last_page" class="page-item" :key="page">
                                <template v-if="page == 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-orders-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-orders-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.current_page - 1">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-orders-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 1) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-orders-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="page == this.infos.last_page">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-orders-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>{{ page }}</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page - 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-orders-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>..</router-link>
                                </template>
                                <template v-else-if="(page == this.infos.current_page + 2) && (this.infos.current_page != this.infos.last_page)">
                                    <router-link class="page-link" :to="{path: '/dashboard/show-orders-merchant/'+this.$route.params.id+'/'+page}" active-class="active" exact>..</router-link>
                                </template>
                            </li>
                            <li v-if="this.infos.current_page != this.infos.last_page" class="page-item">
                                <router-link :to="{path: '/dashboard/show-orders-merchant/'+this.$route.params.id+'/'+(this.infos.current_page + 1) }" class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </router-link>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div v-show="this.showModel == true " id="exampleModalLive" class="modal fade " :class="[ this.showModel == true ? 'show' : '' ]" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" :style="`padding-right: 17px; display:block;padding-top: 10%;z-index: 100000;background: #0000001f;`">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
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
                        <div class="modal-footer">
                            <template v-if="field.order_id == null">
                                <button @click="UpdateStatus()" type="button" class="btn btn-primary" fdprocessedid="3xp1pw">تحديث الحالة</button>
                            </template>
                            <template v-if="field.order_id != null">
                                <button @click="UpdateSingleStatus(field.order_id)" type="button" class="btn btn-primary" fdprocessedid="3xp1pw">تحديث الحالة</button>
                            </template>
                            <button @click="CloseModelUpdateStatus()" type="button" class="btn btn-secondary" data-dismiss="modal" fdprocessedid="c9npk">الغاء</button>
                        </div>
                        </div>
                    </div>
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
            params:{
                q:null,
                delivery_id:null
            },
            no_active_orders:0,
            active_orders:0,
            infos:[],
            orders: [],
            search:null,
            params:{},
            selected:[],
            selected_all:null,
            showModel:false,
            field:{
                order_status:0,
                shipping_status:0,
                order_id:null,
                ids:[]
            },
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
        FetchOrders:function(){
            let self = this;
            axios.get('/api/orders',{
                params:self.params
            }).then(function({data}){
                console.log(data);
                self.infos            = data.data_info;
                self.orders           = self.infos.data;
                self.no_active_orders = data.no_active_orders;
                self.active_orders    = data.active_orders;
                console.log(self.orders);
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
        UpdateStatus:function(){
            let self = this;
            this.field.ids = this.selected;
            axios.put('/api/orders/update-status',this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.success  = data.result;
                console.log(self.success);
                self.params = {
                    page:(self.$route.params.page_no ? self.$route.params.page_no : 1),
                    delivery_id:self.$route.params.id
                };
                self.FetchOrders();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            })
        },
        SingleStatus:function(order){
            let self = this;
            this.field.order_status = order.order_status;
            this.field.shipping_status = order.shipping_status;
            this.field.order_id = order.id;
            this.ShowModelUpdateStatus();
        },
        UpdateSingleStatus:function(order_id){
            let self = this;
            axios.put('/api/orders/'+order_id,this.field).then(function({data}) {
                console.log(data);
                self.errors   = {};
                self.success  = data.result;
                console.log(self.success);
                self.params = {
                    page:(self.$route.params.page_no ? self.$route.params.page_no : 1),
                    delivery_id:self.$route.params.id
                };
                self.FetchOrders();
                self.CloseModelUpdateStatus();
            }).catch(function({response}) {
                console.log(response);
                self.errors = response.data;
            });
        }
    },
    created(){
        this.FetchDelivery();
        this.params = {
            page:(this.$route.params.page_no ? this.$route.params.page_no : 1),
            delivery_id:this.$route.params.id
        };
        this.FetchOrders();
    },
    watch:{
        search:function(search){
            let self = this;
            if((search.length != 0) && (search != null)){
                this.params.q = search;
                this.params.delivery_id = self.$route.params.id;
                axios.get('/api/orders/search',{
                    params:self.params
                }).then(function({data}){
                    console.log(data);
                    self.infos                 = [];
                    self.orders              = data.data_info;
                    self.no_active_products  = data.no_active_products;
                    self.active_products     = data.active_products;
                    console.log(self.infos.length);
                }).catch(function({response}){
                    console.log(response);
                });
            }else{
                self.params = {
                    page:(this.$route.params.page_no ? this.$route.params.page_no : 1),
                    delivery_id:self.$route.params.id
                };
                self.FetchOrders();
            }
        },
        selected_all:function(selected_all){
            let self = this;
            console.log(selected_all);
            if(selected_all== true){
                this.orders.forEach(function(item){
                    self.selected.push(item.id);
                });
            }else if(selected_all == false){
                this.orders.forEach(function(item){
                    self.selected.splice(self.selected.indexOf(item.id),1);
                });
            }
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
.content-page {
    padding: 2%;
}
.actions-btn .btn{
    margin:1%;
}
.filter-bar .filter-results{
    list-style: none;
    padding: 0px
}
.filter-bar .filter-results .filter-item{
    padding: 10px 10px 10px 10px;
    display: inline-block;
    width: auto;
    background-color: #eee;
    margin: 0px 3px;
}
.filter-bar .search-input{
    border:1px solid #eee;
    background-color: white;
    box-shadow: 0px 10px 23px 5px #eee;
    border-radius: 0px;
    height: 46px;
    margin-top: 34px;
}
.page-item .page-link{
    margin: 9px 0px;
}
.page-item .page-link.active{
    background-color:black;
    color:white;
    border: 1px solid black;
    border-radius: 0px;
}
.page-item .page-link[aria-label='Previous'],
.page-item .page-link[aria-label='Next']
{
    border-radius: 0;
    background-color: orange;
    color: black;
    margin: 10px;
    border: 1px solid orange;
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
